<?php


namespace App\Models;


use CodeIgniter\Model;

class TypeLogementModel extends Model
{
    protected $table = 'typelogement';
    protected $allowedFields = ['id','nom','nb_personnes','description','nb_logements','prix_par_nuitee'];
}