<?php


namespace App\Models;


use CodeIgniter\Model;

class CalendrierVacancesModel extends Model
{
    protected $table = "calendriervacances";
    protected $allowedFields = ['id','date_debut','date_fin'];

    /**
     * Vérifie si les dates de vacances en params s'inscrivent dans une période de vacances.
     * @param $dateEntree
     * @param $dateSortie
     * @return bool TRUE si OK, FALSE sinon.
     */
    public function verifieDateVacancesValides($dateEntree, $dateSortie){


         $this  ->where('date_debut<=',$dateEntree)
                ->where('date_fin>=',$dateSortie);
        $res = $this->findAll();
        return count($res)>0;
    }
}