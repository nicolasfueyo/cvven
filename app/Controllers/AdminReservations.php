<?php


namespace App\Controllers;


use App\Models\ReservationModel;
use CodeIgniter\Controller;

class AdminReservations extends Controller
{
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