<?php


namespace App\Controllers;


use App\Models\ReservationModel;
use CodeIgniter\Controller;

class AdminReservations extends Controller
{
    public function liste(){

        # Récupère ttes les réservations non validées
        $model = new ReservationModel();
        $reservationsNonValidees = $model->where('etat', 'NON-VALIDE')
            ->orderBy('id', 'desc')
            ->findAll();

        # Récupère ttes les réservations validées
        $model = new ReservationModel();
        $reservationsValidees = $model->where('etat', 'VALIDE')
            ->orderBy('id', 'desc')
            ->findAll();

        # Renvoie vers la vue
        var_dump($reservationsNonValidees);
    }
}