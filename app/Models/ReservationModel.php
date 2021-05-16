<?php


namespace App\Models;


use CodeIgniter\Model;

class ReservationModel extends Model
{
    protected $table = 'reservation';
    protected $allowedFields = ['id','utilisateur_id','prix_total','date_entree','date_sortie',
        'etat','type_sejour','menage_fin_sejour_inclus'];

    /**
     * Liste les réservations à l'état fourni ( valide / non valides ), toutes ou celles
     * relatives à un client dont àn passe l'ID en 2ème paramètre.
     * @param bool $validees
     * @param int|null $clientId
     * @return array
     */
    public function listeReservationsParEtat(bool $validees, int $clientId=null){

        if($validees==true){
            $etat='VALIDE';
        }else{
            $etat='NON-VALIDE';
        }

        // Crée le  builder afin de sélectionner TOUTES les réservations à l'état voulu (indépendament du client)
        $builder = $this->select('reservation.id, reservation.prix_total, reservation.date_entree, reservation.date_sortie,
                            reservation.type_sejour, reservation.menage_fin_sejour_inclus,
                            reservation_logement.quantite, typelogement.nom tl_nom,
                            utilisateur.id util_id, utilisateur.nom, utilisateur.prenom, utilisateur.email')
            ->join('reservation_logement', 'reservation.id=reservation_logement.id_reservation')
            ->join('typelogement', 'reservation_logement.id_typelogement=typelogement.id')
            ->join('utilisateur', 'reservation.utilisateur_id=utilisateur.id')
            ->where('reservation.etat=', $etat)
            ->orderBy('reservation.id','desc');

        // Complete la requete contenue dans le builder au cas où le clientId est spécifié
        if( $clientId!=null ){
            $builder->where('utilisateur_id=', $clientId);
        }

        return $builder->findAll();
    }

    /**
     * Renvoie le nombre de logements dispos pour le type de logement et la période passés en param.
     * @param $dateEntree
     * @param $dateSortie
     * @param $typeLogementsId
     * @return mixed
     */
    public function calculeNbLogementsDispo($dateEntree, $dateSortie, $typeLogementsId){

        // Sélectionne les logements dispos d'un type donné (parm $typeLogementId) pour la période donnée
        // ( dateEntree -> dateSortie )
        // UNIQEMENT si il existe des réservations pour ce logement
        $this->select('typelogement.nb_logements - SUM(reservation_logement.quantite) logements_libres')
            ->join('reservation_logement', 'reservation.id=reservation_logement.id_reservation', 'LEFT')
            ->join('typelogement', 'reservation_logement.id_typelogement=typelogement.id', 'LEFT')
            ->where('reservation.date_entree<=',$dateEntree)
            ->where('reservation.date_sortie>=',$dateSortie)
            ->where('reservation_logement.id_typelogement=',$typeLogementsId)
            ->where('reservation.etat=', 'VALIDE');
        $nbLogementsDispo = $this->first()['logements_libres'];

        // Si pas trouvé ( aucune réservation trouvée ) alors charge le nb de logements total du type de logement.
        if($nbLogementsDispo==null){// Pas de réservations du tout
            $tlModel = new TypeLogementModel();
            $nbLogementsDispo = $tlModel->find($typeLogementsId)['nb_logements'];
        }

        return $nbLogementsDispo;
    }
}