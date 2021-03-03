<?php


namespace App\Models;


use CodeIgniter\Model;

class ReservationLogementModel extends Model
{
    protected $table = 'reservation_logement';
    protected $allowedFields = ['id','id_typelogement','id_reservation','quantite'];

    public function verifieDisponibilite($dateEntree, $dateSortie, $nbLogements, $typeLogementsId){
        $this->select('typelogement.nb_logements - SUM(reservation_logement.quantite) logements_libres')
            ->join('reservation', 'reservation.id=reservation_logement.id')
            ->join('typelogement', 'typelogement.id=reservation_logement.id_typelogement')
            ->where('reservation.date_debut<=',$dateEntree)
            ->where('reservation.date_fin>=',$dateSortie)
            ->where('reservation.id_typelogement=',$typeLogementsId)
            ->where('reservation.etat=', 'VALIDE');
        $res = $this->findAll();
        var_dump($res);
        exit;
    }
}