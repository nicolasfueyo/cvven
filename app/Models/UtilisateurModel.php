<?php namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model{

    public const ROLE_CLIENT = 'CLIENT';
    public const ROLE_ADMIN = 'ADMIN';

    protected $table = 'utilisateur';
    protected $allowedFields = ['id','nom','email','mdp','prenom','tel','role','adresse'];

    /**
     * Renvoie la liste des clients triées par nom et prénom.
     * @return array
     */
    public function listerClients(){
        return $this->where("role='CLIENT'")->orderBy('nom')->orderBy('prenom')->findAll();
    }
}