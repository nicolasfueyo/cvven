<?php


namespace App\Controllers;


use App\Models\ReservationLogementModel;
use App\Models\ReservationModel;
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

        # Passe l'état de la réservation à VALIDE en BD
        $model = new ReservationModel();
        $model->update($reservationId,['etat'=>'VALIDE']);

        # Redirection vers Liste des réservations
        return redirect()->to('/AdminReservations/liste');
    }

    public function liste(){

        # Récupère ttes les réservations non validées
        $model = new ReservationModel();
        $reservationsNonValidees = $model->listeReservationsParEtat(false);

        # Récupère ttes les réservations validées
        $model = new ReservationModel();
        $reservationsValidees = $model->listeReservationsParEtat(true);

        # Renvoie vers la vue
        return view('adminpage.php', ['reservationsNonValidees'=>$reservationsNonValidees,
                                            'reservationsValidees'=>$reservationsValidees] );
    }
}