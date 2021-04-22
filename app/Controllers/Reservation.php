<?php namespace App\Controllers;

use App\Models\CalendrierVacancesModel;
use App\Models\ReservationLogementModel;
use App\Models\ReservationModel;
use App\Models\TypeLogementModel;
use App\Models\UtilisateurModel;
use CodeIgniter\Controller;
use CodeIgniter\Session\Session;

class Reservation extends Controller {

    public function supprimer($id){

        # Supprimer le réservation_logement pour cette réservation
        $model=new ReservationLogementModel();
        $model->supprimeParReservationId($id);

        # Supprimer la réservation
        $model=new ReservationModel();
        $model->delete($id);

        # Affiche vue message 'résearvation enregistrée'
        echo view('message_client',
            [   'titre'=>'Réservation supprimée',
                'message'=>'Nous avons bien supprimé votre réservation!!']);
    }

    public function mesReservations(){

        // Récup userid en session
        $session=session();
        $userId=$session->get("user_id");

        // Récup mes réservations en BD
        $model=new ReservationModel();
        $reservationsValidees=$model->listeReservationsParEtat(true,$userId);
        $reservationNonValidees=$model->listeReservationsParEtat(false,$userId);

        // Renvoie vers la vue

        return view('mes_reservations', [
            'reservationsNonValidees'=>$reservationNonValidees,
            'reservationsValidees'=>$reservationsValidees
        ]);
    }

    public function post(){

        $session = session();
        helper(['form']);
        helper("reservation_helper");

        # Validation demande de réservation
        $rules = [
            'dateEntree' => 'required',
            'dateSortie' => 'required',
            'nbLogements' => 'required',
            'typeLogementId' => 'required'
        ];

        # Charle les types de logement
        $data = [];
        $typesLogements = [];
        $model = new TypeLogementModel();
        foreach ( $model->findAll() as $typeLogement ){
            $typesLogements[ $typeLogement['id'] ] = $typeLogement['nom'];
        }
        $data['typesLogements'] = $typesLogements;

        #Validation de base
        $validationOk = $this->validate($rules);
        if($validationOk){

            // Valide dateEntree samedi
            $dateEntree = $_POST['dateEntree'];
            if (! estSamedi($dateEntree)){
                $this->validator->setError('date_entree', 'Date entrée doit être un samedi');
            }
            // Valide que la date de sortie est un samedi
            $dateSortie = $_POST['dateSortie'];
            if (! estSamedi($dateSortie)){
                $this->validator->setError('date_sortie', 'Date sortie doit être un samedi');
            }

            // Valide que dateEntree est plus petite que dateSortie
            if (!dateAnterieure($dateEntree,$dateSortie)){
                $this->validator->setError('date_sortie', 'Date sortie est doit etre supérieure a date entrée');
            }

            // Valide que les dates demandées correspondent à une période de vacances
            $model = new CalendrierVacancesModel();
            if( !$model->verifieDateVacancesValides($dateEntree, $dateSortie) ){
                $this->validator->setError('date_entree', 'Les dates doivent correspondre à une période de vacances');
            }

            // Vérification des disponibilité pour ces dates
            $model = new ReservationModel();
            $nbLogementsDispos = $model->calculeNbLogementsDispo($dateEntree, $dateSortie, $_POST['typeLogementId']);
            if( $nbLogementsDispos<$_POST['nbLogements'] ){
                $this->validator->setError('prix_total','Pas assez de logements displonibles : ' .$nbLogementsDispos);
            }


            // Si tout est valide : enreistre la réservation et redirection
        }

        if( count($this->validator->getErrors())>0 ){
            $session = session();
            $session->setFlashdata( 'etape_reservation', '1' );

            # Prépare valeurs du formulaire
            $data['reservation'] = [];
            $data['reservation']['typeLogementId'] = $_POST['typeLogementId'];
            $data['reservation']['nbLogements'] = $_POST['nbLogements'];
            $data['reservation']['dateEntree'] = $_POST['dateEntree'];
            $data['reservation']['dateSortie'] = $_POST['dateSortie'];
            $data['reservation']['typePension'] = $_POST['typePension'];
            $data['reservation']['menageInclus'] = isset($_POST['menageInclus']) ? $_POST['menageInclus'] : false;

            $data['validation'] = $this->validator;

            echo view('reservation', $data);
            return;
        }

        # Calcule prix total
        $menageInclus = isset( $_POST['menageInclus'] ) ? true : false;
        $prixTotal=calculerPrixReservation($_POST['typeLogementId'],$_POST['nbLogements'],$dateEntree,$dateSortie,$menageInclus,$_POST['typePension']);

        # Affiche le prix si on a pas encore validé
        $etapeReservation = $session->getFlashdata('etape_reservation');
        if( $etapeReservation==1 ){
            $session->setFlashdata('etape_reservation', 2);
            $session->setFlashdata('prix_total', $prixTotal);

            # Prépare valeurs du formulaire
            $data['reservation'] = [];
            $data['reservation']['typeLogementId'] = $_POST['typeLogementId'];
            $data['reservation']['nbLogements'] = $_POST['nbLogements'];
            $data['reservation']['dateEntree'] = $_POST['dateEntree'];
            $data['reservation']['dateSortie'] = $_POST['dateSortie'];
            $data['reservation']['typePension'] = $_POST['typePension'];
            $data['reservation']['menageInclus'] = isset($_POST['menageInclus']) ? $_POST['menageInclus'] : false;

            helper(['form']);

            echo view('reservation', $data);
            return;
        }

        // Etape réservation == 2

        # Enregistre réservation
        $reservationModel = new ReservationModel();
        $reservation = [

        ];
        $user_id = (session())->get('user_id');

        // Formate date entree / sortie
        $dt = new \DateTime($_POST['dateEntree']);
        $dateEntree = $dt->format('Y-m-d');
        $dt = new \DateTime($_POST['dateSortie']);
        $dateSortie = $dt->format('Y-m-d');

        $nouvResId = $reservationModel->insert([
            'utilisateur_id'=>$user_id,
            'prix_total'=>$prixTotal,
            'date_entree'=>$dateEntree,
            'date_sortie'=>$dateSortie,
            'etat'=>'NON-VALIDE',
            'type_sejour'=>$_POST['typePension'],
            'menage_fin_sejour_inclus'=>isset( $_POST['menageInclus'] )
            ]);

        # Enregistre réservationLogement
        $typeLogement = (new TypeLogementModel())->find($_POST['typeLogementId']);
        $resLogementModel = new ReservationLogementModel();
        $resLogementModel->insert([
            'id_typelogement'=>$typeLogement['id'],
            'id_reservation'=>$nouvResId,
            'quantite'=>$_POST['nbLogements']
        ]);

        # Envoie email à l'admin
        $model = new UtilisateurModel();
        $client = $model->find($user_id);
        helper("email_helper");
        $message = sprintf("Nouvelle demande de réservation de la part de %s %s: 
            , du %s au %s, %d %s x %d nuitées", $client['prenom'], $client['nom'], $dateEntree, $dateSortie, $_POST['nbLogements'],
            $typeLogement["nom"], calculeNbJoursEntreDates($dateEntree, $dateSortie));
        envoyerEmail("nicolas93100.fueyo@gmail.com","Nouvelle réservation",
            $message);

        # Affiche vue message 'résearvation enregistrée'
        echo view('message_client',
            ['titre'=>'Réservation enregistrée',
            'message'=>'Merci pour votre réservation. Nous revenons vers vous pour confirmation!']);
    }

    public function index() {

        $session = session();
        $session->setFlashdata( 'etape_reservation', '1' );

        $data = [];

        // Charge types de logement
        $model = new TypeLogementModel();
        $typesLogements = [];
        foreach ( $model->findAll() as $typeLogement ){
            $typesLogements[ $typeLogement['id'] ] = $typeLogement['nom'];
        }
        $data['typesLogements'] = $typesLogements;
        $data['reservation'] = [];
        $data['reservation']['typeLogementId'] = '';
        $data['reservation']['nbLogements'] = '';
        $data['reservation']['dateEntree'] = '';
        $data['reservation']['dateSortie'] = '';
        $data['reservation']['typePension'] = '';
        $data['reservation']['menageInclus'] = false;

        helper(['form']);

        echo view('reservation', $data);
    }
}