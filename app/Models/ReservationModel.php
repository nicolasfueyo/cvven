<?php


namespace App\Models;


use CodeIgniter\Model;

class ReservationModel extends Model
{
    protected $table = 'reservation';
    protected $allowedFields = ['id','utilisateur_id','prix_total','date_entree','date_sortie',
        'etat','type_sejour','menage_fin_sejour_inclus'];

    public function listeReservationsParEtat(bool $validees){

        if($validees==true){
            $etat='VALIDE';
        }else{
            $etat='NON-VALIDE';
        }

        return $this->select('reservation.id, reservation.prix_total, reservation.date_entree, reservation.date_sortie,
                            reservation.type_sejour, reservation.menage_fin_sejour_inclus,
                            reservation_logement.quantite, typelogement.nom tl_nom,
                            utilisateur.id util_id, utilisateur.nom, utilisateur.prenom, utilisateur.email')
            ->join('reservation_logement', 'reservation.id=reservation_logement.id_reservation')
            ->join('typelogement', 'reservation_logement.id_typelogement=typelogement.id')
            ->join('utilisateur', 'reservation.utilisateur_id=utilisateur.id')
            ->where('reservation.etat=', $etat)
            ->orderBy('reservation.id','desc')->findAll();
    }

    public function calculeNbLogementsDispo($dateEntree, $dateSortie, $typeLogementsId){
        $this->select('typelogement.nb_logements - SUM(reservation_logement.quantite) logements_libres')
            ->join('reservation_logement', 'reservation.id=reservation_logement.id_reservation', 'LEFT')
            ->join('typelogement', 'reservation_logement.id_typelogement=typelogement.id', 'LEFT')
            ->where('reservation.date_entree<=',$dateEntree)
            ->where('reservation.date_sortie>=',$dateSortie)
            ->where('reservation_logement.id_typelogement=',$typeLogementsId)
            ->where('reservation.etat=', 'VALIDE');

        $nbLogementsDispo = $this->first()['logements_libres'];
        if($nbLogementsDispo==null){// Pas de réservations du tout
            $tlModel = new TypeLogementModel();
            $nbLogementsDispo = $tlModel->find($typeLogementsId)['nb_logements'];
        }

        return $nbLogementsDispo;
    }
}