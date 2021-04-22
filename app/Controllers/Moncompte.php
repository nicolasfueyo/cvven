<?php


namespace App\Controllers;


use App\Models\UtilisateurModel;
use CodeIgniter\Controller;

class Moncompte extends Controller
{
    // Voir exemples ds autres controleurs

    public function changerMdpPost(){

        // Retourne sur le formulaire changement mdp en cas d'erreur de validation
        $rules = [
            'mdp1' => 'required|min_length[6]|max_length[20]',
            'mdp2' => 'matches[mdp1]',
        ];
        if( ! $this->validate($rules) ){

            echo view( 'changerMdp', ['validation'=>$this->validator] );
            return;
        }

        // MDP valide

        // Modif du mdp de l'util en session
        $session = session();
        $idUtilConnecte = $session->get('user_id');
        $model = new UtilisateurModel();
        $mdpCrypte = password_hash($this->request->getVar('mdp1'), PASSWORD_DEFAULT);
        $model->update($idUtilConnecte, ['mdp'=>$mdpCrypte]);

        // Redirection vers
        echo view('message_client', ['titre'=>'Mot-de-passe modifié','message'=>'Votre mdp à bien été modifié !']);
    }

    public function changermdpget(){

        echo view('changerMdp', []);
    }
}