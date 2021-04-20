<?php


namespace App\Controllers;


use App\Models\CalendrierVacancesModel;
use App\Models\ReservationLogementModel;
use App\Models\ReservationModel;
use App\Models\TypeLogementModel;
use App\Models\UtilisateurModel;
use CodeIgniter\Controller;

class AdminReservations extends Controller
{
    public function modifierSave($reservationId){
        # Validation demande de réservation
        $rules = [
            'dateEntree' => 'required',
            'dateSortie' => 'required',
            'nbLogements' => 'required',
            'typeLogement' => 'required'
        ];

        #Validation de base
        $validationOk = $this->validate($rules);
        if($validationOk){

            // Valide dateEntree samedi
            $dateEntree = $_POST['dateEntree'];
            if (! Reservation::estSamedi($dateEntree)){
                die('Date entrée doit être un samedi');
            }
            // Valide que la date de sortie est un samedi
            $dateSortie = $_POST['dateSortie'];
            if (! Reservation::estSamedi($dateSortie)){
                die('La date de sortie doit être un samedi');
            }

            // Valide que dateEntree est plus petite que dateSortie
            if (!Reservation::dateAnterieure($dateEntree,$dateSortie)){
                die('Date sortie est doit etre supérieur a date entrée');
            }

            // Valide que les dates demandées correspondent à une période de vacances
            $model = new CalendrierVacancesModel();
            if( !$model->verifieDateVacancesValides($dateEntree, $dateSortie) ){
                die('Les dates doivent correspondre à une période de vacances');
            }

            // Vérification des disponibilité pour ces dates
            $model = new ReservationModel();
            $nbLogementsDispos = $model->calculeNbLogementsDispo($dateEntree, $dateSortie, $_POST['typeLogement']);
            if( $nbLogementsDispos<$_POST['nbLogements'] ){
                die('Pas assez de logements displonibles : ' .$nbLogementsDispos);
            }


            // Si tout est valide : enreistre la réservation et redirection
        }else{
            die('errur de validation');
        }

        # Calcule prix total
        # Prix résa = (nb logements * ppn du tl*nb nuitées) + (ménage*nb logements) + (nb personnes*prix demi-p * nbnuits)
        $typeLogement = (new TypeLogementModel())->find( $_POST['typeLogement'] );
        $nbNuitee = Reservation::calculeNbJoursEntreDates($dateEntree, $dateSortie);
        $prixTotal = $_POST['nbLogements'] * $typeLogement['prix_par_nuitee'] * $nbNuitee;

        if( isset( $_POST['menageInclus'] ) ){// Ménage
            $prixTotal += 25 * $_POST['nbLogements'];
        }

        if(  $_POST['typePension']=='PENSION COMPLETE'){// +20€ / logement / nuitée
            $prixTotal += $_POST['nbLogements']  * $nbNuitee * 20;
        }

        # Enregistre réservation
        $reservationModel = new ReservationModel();
        $user_id = $_POST['utilisateur'];
        $reservationModel->update($reservationId,
            [
            'utilisateur_id'=>$user_id,
            'prix_total'=>$prixTotal,
            'date_entree'=>$dateEntree,
            'date_sortie'=>$dateSortie,
            'etat'=>'NON-VALIDE',
            'type_sejour'=>$_POST['typePension'],
            'menage_fin_sejour_inclus'=>isset( $_POST['menageInclus'] )
        ]);

        # Enregistre réservationLogement
        $resLogementModel = new ReservationLogementModel();
        $resLogementModel->where('id_reservation=', $reservationId)->update(null,[
            'id_typelogement'=>$typeLogement['id'],
            'quantite'=>$_POST['nbLogements']
        ]);

        # Affiche vue message 'résearvation enregistrée'
        echo view('admin_message',
            ['titre'=>'Réservation enregistrée',
                'message'=>'Réservation modifiée avec succès!']);
    }

    public function modifier($reservationId){

        $data = [];

        // Charge types de logement
        $model = new TypeLogementModel();
        $typesLogements = [];
        foreach ( $model->findAll() as $typeLogement ){
            $typesLogements[ $typeLogement['id'] ] = $typeLogement['nom'];
        }
        $data['typesLogements'] = $typesLogements;

        // Charge les infos de réservation
        helper(['form']);
        $model = new ReservationModel();
        $reservation = $model->find( $reservationId );
        $data['reservation'] = $reservation;

        // Charge le typelogement de la réservation
        $model=new ReservationLogementModel();
        $reservationLogement = $model->where('id_reservation=',$reservation['id'])->first();
        $data['reservation']['typeLogementId'] = $reservationLogement['id_typelogement'];
        $data['reservation']['nbLogements'] = $reservationLogement['quantite'];

        // Formate date entree / sortie
        $dt = new \DateTime($reservation['date_entree']);
        $data['reservation']['date_entree'] = $dt->format('Y-m-d');
        $dt = new \DateTime($reservation['date_sortie']);
        $data['reservation']['date_sortie'] = $dt->format('Y-m-d');

        // Charge les utilisateurs
        $model = new UtilisateurModel();
        $utilisateurs = $model->orderBy('nom')->orderBy('prenom')->findAll();
        $utils = [];
        foreach ( $utilisateurs as $util ){
            $utils[ $util['id'] ] = sprintf('%s, %s', $util['nom'], $util['prenom']);
        }
        $data['utilisateurs'] = $utils;



        // Affiche la vue
        echo view('admin_reservation_modifier', $data);
    }

    public function refuser($reservationId){

        # Récupère email du client
        $model = new ReservationModel();
        $reservation = $model->find($reservationId);
        $model = new UtilisateurModel();
        $client = $model->find($reservation["utilisateur_id"]);
        $emailClient = $client['email'];

        # Supprimer en BD les ReservationLogement et la réservation
        $model = new ReservationLogementModel();
        $model->supprimeParReservationId($reservationId);

        $model = new ReservationModel();
        $model->delete($reservationId);

        # Envoi mail refus de la réservation
        helper('email_helper');
        envoyerEmail($emailClient,"Réservation refusée", "Votre réservation à été refusée, n'hésitez pas à nous contacter!");

        # Redirection vers Liste des réservations
        return redirect()->to('/AdminReservations/liste');
    }

    public function valider($reservationId){

        // Vérification des disponibilité pour ces dates
        $modelReservation = new ReservationModel();
        $modelReservationLogement = new ReservationLogementModel();
        $reservation = $modelReservation->find($reservationId);
        $reservationLogement = $modelReservationLogement->where('id_reservation=', $reservationId)->first();
        $nbLogementsDispos = $modelReservation->calculeNbLogementsDispo($reservation['date_entree'],
            $reservation['date_sortie'], $reservationLogement['id_typelogement']);
        if( $nbLogementsDispos<$reservationLogement['quantite'] ){
            die('Pas assez de logements displonibles : ' .$nbLogementsDispos);
        }

        # Passe l'état de la réservation à VALIDE en BD
        $modelReservation = new ReservationModel();
        $modelReservation->update($reservationId,['etat'=>'VALIDE']);

        # Envoi mail validation de la réservation
        $model = new UtilisateurModel();
        $client = $model->find($reservation["utilisateur_id"]);
        $emailClient = $client['email'];
        helper('email_helper');
        envoyerEmail($emailClient,"Réservation accepté", "Votre réservation à été acceptée!");

        # Redirection vers Liste des réservations
        return redirect()->to('/AdminReservations/liste');
    }

    public function liste(){

        # Récupère ttes les réservations non validées
        $model = new ReservationModel();
        $clientId = null;
        if( isset($_POST['client_id']) and $_POST['client_id']!=false){
            $clientId = $_POST['client_id'];
        }
        $reservationsNonValidees = $model->listeReservationsParEtat(false, $clientId);

        # Récupère ttes les réservations validées
        $model = new ReservationModel();
        $reservationsValidees = $model->listeReservationsParEtat(true, $clientId);

        # Récupère liste de tous les clients
        $model = new UtilisateurModel();
        $clients = $model->listerClients();
        $clientsPourForm = [];
        $clientsPourForm[null]='TOUS';
        foreach ($clients as $client){
            $clientsPourForm[ $client['id'] ] = $client['nom'] . ' ' . $client['prenom'];
        }
        helper(['form']);
        # Renvoie vers la vue
        return view('adminpage.php', ['reservationsNonValidees'=>$reservationsNonValidees,
                                            'reservationsValidees'=>$reservationsValidees,
                                            'clients'=>$clientsPourForm,
                                            'clientId'=>$clientId] );
    }
}