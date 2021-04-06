<?php


namespace App\Controllers;


use App\Models\ReservationLogementModel;
use App\Models\ReservationModel;
use App\Models\UtilisateurModel;
use CodeIgniter\Controller;

class AdminUtilisateurs extends Controller
{
    public function liste(){

        # Récupère ts les utilisateurs
        $model = new UtilisateurModel();
        $allUtils = $model->findAll();

        # Renvoie vers la vue
        return view('admin_utilisateurs.php', ['utilisateurs'=>$allUtils] );
    }
}