<?php


namespace App\Controllers;


use App\Models\ReservationLogementModel;
use App\Models\ReservationModel;
use App\Models\UtilisateurModel;
use CodeIgniter\Controller;

class AdminReservations extends Controller
{
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