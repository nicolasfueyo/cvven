<?php


namespace App\Models;


use CodeIgniter\Model;

class CalendrierVacancesModel extends Model
{
    protected $table = "calendriervacances";
    protected $allowedFields = ['id','date_jour'];
}