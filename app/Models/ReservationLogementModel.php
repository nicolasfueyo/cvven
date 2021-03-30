<?php


namespace App\Models;


use CodeIgniter\Model;

class ReservationLogementModel extends Model
{
    protected $table = 'reservation_logement';
    protected $allowedFields = ['id','id_typelogement','id_reservation','quantite'];

    public function supprimeParReservationId($reservationId){
        $tab = $this->select('id')
            ->where('id_reservation=', $reservationId)
            ->findAll();

        foreach ($tab as $ligne){
            $this->delete( $ligne['id'] );
        }
    }
}