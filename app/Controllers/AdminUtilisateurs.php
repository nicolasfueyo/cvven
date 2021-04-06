<?php


namespace App\Controllers;


use App\Models\ReservationLogementModel;
use App\Models\ReservationModel;
use App\Models\UtilisateurModel;
use CodeIgniter\Controller;

class AdminUtilisateurs extends Controller
{
    public function supprimer($id){

        # Redirige vers une pages d'erreur si l'utilisateur possède des réservations validées
        $model = new ReservationModel();
        $reservations = $model->listeReservationsParEtat(true, $id);
        if( count($reservations)>0 ){
            return view('admin_message.php',[
                'titre'=>'Erreur',
                'message'=>'Vous ne pouvez supprimer un client qui possède des réservations validée']);
        }

        # Redirige vers une pages d'erreur si l'utilisateur possède des réservations non validées
        $model = new ReservationModel();
        $reservations = $model->listeReservationsParEtat(false, $id);
        if( count($reservations)>0 ){
            return view('admin_message.php',[
                'titre'=>'Erreur',
                'message'=>"Supprimez d'abord les réservations non validées de cet utilisateur !"]);
        }

        # Supprimer l'utilisateur
        $model = new UtilisateurModel();
        $model->delete($id);

        return redirect()->to( '/AdminUtilisateurs/liste' );
    }

    public function liste(){

        # Récupère ts les utilisateurs
        $model = new UtilisateurModel();
        $allUtils = $model->findAll();

        # Renvoie vers la vue
        return view('admin_utilisateurs.php', ['utilisateurs'=>$allUtils] );
    }
}