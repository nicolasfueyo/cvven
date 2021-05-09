<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UtilisateurModel;

class Register extends Controller {
    public function index() {

        helper(['form']);
        $data = [];

        // Affiche la vue register.php
        echo view('register', $data);
    }
    
    public function save(){
        helper(['form']);

        // Validation
        $rules = [
            'prenom' => 'required|min_length[3]|max_length[20]',
            'nom' => 'required|min_length[3]|max_length[20]',
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[utilisateur.email]',
            'mdp' => 'required|min_length[6]|max_length[20]',
            'confMdp' => 'matches[mdp]',
        ];
        
        if($this->validate($rules)){// Si valide

            // Inscription en BD ds table Utilisateur
            $model = new UtilisateurModel();
            $data = [
                'prenom' => $this->request->getVar('prenom'),
                'nom' => $this->request->getVar('nom'),
                'tel' => $this->request->getVar('tel'),
                'adresse' => $this->request->getVar('adresse'),
                'email' => $this->request->getVar('email'),
                'role'=>UtilisateurModel::ROLE_CLIENT,
                'mdp' => password_hash($this->request->getVar('mdp'), PASSWORD_DEFAULT)// Crypte MDP
            ];

            $model->save($data);// Insertion en BD

            // Redirige vers le controler Login.php
            return redirect()->to(site_url('Login'));
        }else{// Si pas valide

            // Affiche la page en incluant les msg d'erreur de validation
            $data['validation'] = $this->validator;
            echo view('register', $data);
        }
    }
}