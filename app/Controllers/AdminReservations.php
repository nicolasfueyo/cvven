<?php


namespace App\Controllers;


use App\Models\ReservationLogementModel;
use App\Models\ReservationModel;
use App\Models\TypeLogementModel;
use App\Models\UtilisateurModel;
use CodeIgniter\Controller;

class AdminReservations extends Controller
{
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
        $data['reservation']['date_entree'] = $dt->format('d/m/Y');

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

        # Supprimer en BD les ReservationLogement et la réservation
        $model = new ReservationLogementModel();
        $model->supprimeParReservationId($reservationId);


        $model = new ReservationModel();
        $model->delete($reservationId);

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