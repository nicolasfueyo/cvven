<?php


namespace App\Controllers;


use App\Models\ReservationLogementModel;
use App\Models\ReservationModel;
use App\Models\UtilisateurModel;
use CodeIgniter\Controller;

class AdminUtilisateurs extends Controller
{
    public function modifierSave($idUtil){
        helper(['form']);

        // Validation de base
        $rules = [
            'prenom' => 'required|min_length[3]|max_length[20]',
            'nom' => 'required|min_length[3]|max_length[20]',
            'email' => 'required|min_length[6]|max_length[50]|valid_email',
        ];

        // Ajoute une règle de validation du mdp si il est spécifié ds le formulaire
        if( $this->request->getVar('mdp')!=null ){

            $rules['mdp'] = 'required|min_length[6]|max_length[20]';
            $rules['confMdp'] = 'matches[mdp]';
        }

        // Modif de l'utilisateur db BD si validation OK, puis redirection vers liste utils
        if($this->validate($rules)){
            $model = new UtilisateurModel();
            $data = [
                'id' => $idUtil,
                'prenom' => $this->request->getVar('prenom'),
                'nom' => $this->request->getVar('nom'),
                'tel' => $this->request->getVar('tel'),
                'adresse' => $this->request->getVar('adresse'),
                'email' => $this->request->getVar('email'),
            ];

            // Crypte le MDP si il est spécifié ds le formulaire
            if( $this->request->getVar('mdp')!=null ){
                $data['mdp'] = password_hash($this->request->getVar('mdp'), PASSWORD_DEFAULT);
            }

            $model->save($data);
            return redirect()->to(site_url('AdminUtilisateurs/liste'));
        }

        // Erreur de validation

        $model = new UtilisateurModel();
        $util = $model->find($idUtil);

        $data['validation'] = $this->validator;
        $data['util'] = $util;
        echo view('admin_utilisateur_modifier', $data);
    }

    public function modifier($utilId){

        helper(['form']);
        $model = new UtilisateurModel();
        $util = $model->find($utilId);
        echo view('admin_utilisateur_modifier', ['util'=>$util]);
    }

    public function save(){
        helper(['form']);

        // Validation des données issues du formulaire
        $rules = [
            'prenom' => 'required|min_length[3]|max_length[20]',
            'nom' => 'required|min_length[3]|max_length[20]',
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[utilisateur.email]',
            'mdp' => 'required|min_length[6]|max_length[20]',
            'confMdp' => 'matches[mdp]',
        ];

        // Update en BD si valide et redirection vers liste utilis
        if($this->validate($rules)){
            $model = new UtilisateurModel();
            $data = [
                'prenom' => $this->request->getVar('prenom'),
                'nom' => $this->request->getVar('nom'),
                'tel' => $this->request->getVar('tel'),
                'adresse' => $this->request->getVar('adresse'),
                'email' => $this->request->getVar('email'),
                'role'=>$this->request->getVar('role'),
                'mdp' => password_hash($this->request->getVar('mdp'), PASSWORD_DEFAULT)
            ];

            $model->save($data);
            return redirect()->to(site_url('AdminUtilisateurs/liste'));
        }

        // Pas valide

        // Réaffiche le formulaire avec ses erreurs de validation
        $data['validation'] = $this->validator;
        echo view('admin_utilisateur_ajouter', $data);
    }

    public function ajouter(){
        helper(['form']);
        $data = [];
        echo view('admin_utilisateur_ajouter', $data);
    }

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

        // L'utilisateur ne possède aucune réservation ( validée ou non )

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