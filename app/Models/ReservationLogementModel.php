<?php


namespace App\Models;


use CodeIgniter\Model;

class ReservationLogementModel extends Model
{
    protected $table = 'reservation_logement';
    protected $allowedFields = ['id','id_typelogement','id_reservation','quantite'];

    /**
     * Supprime de la table les lignes relatives à la réservation en paramètre.
     * @param $reservationId
     */
    public function supprimeParReservationId($reservationId){

        // Sléectionne les reservationLogement associés à la réservation
        $tab = $this->select('id')
            ->where('id_reservation=', $reservationId)
            ->findAll();

        // Supprime chacune d'eux ( reservationLogement sélectionnés )
        foreach ($tab as $ligne){
            $this->delete( $ligne['id'] );
        }
    }
}