<?php


namespace App\Models;


use CodeIgniter\Model;

class ReservationModel extends Model
{
    protected $table = 'reservation';
    protected $allowedFields = ['id','utilisateur_id','prix_total','date_entree','date_sortie',
        'etat','type_sejour','menage_fin_sejour_inclus'];
}