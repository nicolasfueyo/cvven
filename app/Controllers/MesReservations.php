<?php


namespace App\Controllers;


use CodeIgniter\Controller;

class MesReservations extends Controller
{
    // Voir exemples ds autres controleurs

    public function annulerReservation(){

    }

    public function mesReservations(){
        echo view('mesReservations', []);
    }
}