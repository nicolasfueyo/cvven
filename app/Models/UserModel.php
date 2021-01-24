<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
    protected $table = 'utilisateur';
    protected $allowedFields = ['id','nom','email','mdp','prenom','tel','role','adresse'];
}