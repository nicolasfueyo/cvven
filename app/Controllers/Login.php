<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UtilisateurModel;

class Login extends Controller
{
    public function index()
    {
        helper(['form']);
        echo view('login');
    }

    public function auth()
    {
        $session = session(); // Crée ou récupère la session
        $model = new UtilisateurModel();
        $email = $this->request->getVar('email');// Récupère données du formulaire
        $mdpEntre = $this->request->getVar('password');
        $data = $model->where('email', $email)->first();// Récup l'util par son email
        if ($data) { // Util

            // Prépare les variables de session au cas où la connexion serait OK
            $ses_data = [
                'user_id' => $data['id'],
                'user_name' => $data['nom'],
                'user_email' => $data['email'],
                'logged_in' => TRUE
            ];

            // Vérifie le MDP
            $mdpCrypte = $data['mdp'];
            $verify_pass = password_verify($mdpEntre, $mdpCrypte);

            // Redirige vers login si erreur de connexion
            if ($verify_pass == false) {
                $session->setFlashdata('msg', 'Mauvais mot de passe');
                return redirect()->to(site_url('Login'));
            }

            // Redirige vers l'admin si l'util est admin
            if ($data['role']==='ADMIN') {

                $session->set($ses_data);
                return redirect()->to(site_url('AdminReservations/liste'));# Renvoi l'admin vers gestion réservations
            }

            // Si client => Redirige vers dashboard
            $session->set($ses_data);
            return redirect()->to(site_url('Dashboard'));

        } else {
            // Redirige vers login avec mdg d'erreur
            $session->setFlashdata('msg', 'Email non trouvée');
            return redirect()->to(site_url('Login'));

        }
    }

    public function logout()
    {
        // Supprime session
        session()->destroy();

        // Redirige vers racine du site
        return redirect()->to(site_url());
    }
} 