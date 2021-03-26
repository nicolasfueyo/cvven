<?php namespace App\Controllers;

use App\Models\CalendrierVacancesModel;
use App\Models\ReservationLogementModel;
use App\Models\ReservationModel;
use App\Models\TypeLogementModel;
use CodeIgniter\Controller;

class Reservation extends Controller {

    private function calculeNbJoursEntreDates($strDateDebut, $strDateFin){
        $dtDebut = \DateTime::createFromFormat('Y-m-d',$strDateDebut );
        $dtFin = \DateTime::createFromFormat('Y-m-d',$strDateFin );

        $di = $dtFin->diff($dtDebut);
        $nbJours = $di->format('%a');

        return $nbJours;
    }

    /**
     * Renvoie true si la date est un samedi, sinon renvoie false.
     * @param $strDate Date au format '20/02/2021'
     * @return bool
     */
    private function estSamedi($strDate)
    {
        $dt = \DateTime::createFromFormat('Y-m-d',$strDate );
        $numJour = $dt->format('w');
        return $numJour==6;
    }

    /**
     * Renvoie TRUE si la date strDateA < strDateB
     * @param $strDateA
     * @param $strDateB
     * @return bool
     */
    private function dateAnterieure($strDateA, $strDateB){
        $dateA = \DateTime::createFromFormat('Y-m-d',$strDateA );
        $dateB = \DateTime::createFromFormat('Y-m-d',$strDateB );

        return $dateA->getTimestamp() < $dateB->getTimestamp();
    }

    public function post(){

        helper(['form']);

        # Validation demande de réservation
        $rules = [
            'dateEntree' => 'required',
            'dateSortie' => 'required',
            'nbLogements' => 'required',
            'typeLogement' => 'required'
        ];

        #Validation de base
        $validationOk = $this->validate($rules);
        if($validationOk){

            // Valide dateEntree sazmedi
            $dateEntree = $_POST['dateEntree'];
            if (! $this->estSamedi($dateEntree)){
                die('Date entrée doit être un samedi');
            }
            // Valide que la date de sortie est un samedi
            $dateSortie = $_POST['dateSortie'];
            if (! $this->estSamedi($dateSortie)){
                die('La date de sortie doit être un samedi');
            }

            // Valide que dateEntree est plus petite que dateSortie
            if (!$this->dateAnterieure($dateEntree,$dateSortie)){
                die('Date sortie est doit etre supérieur a date entrée');
            }

            // Valide que les dates demandées correspondent à une période de vacances
            $model = new CalendrierVacancesModel();
            if( !$model->verifieDateVacancesValides($dateEntree, $dateSortie) ){
                die('Les dates doivent correspondre à une période de vacances');
            }

            // Vérification des disponibilité pour ces dates
            $model = new ReservationModel();
            $nbLogementsDispos = $model->calculeNbLogementsDispo($dateEntree, $dateSortie, $_POST['typeLogement']);
            if( $nbLogementsDispos<$_POST['nbLogements'] ){
                die('Pas assez de logements displonibles : ' .$nbLogementsDispos);
            }


            // Si tout est valide : enreistre la réservation et redirection
        }else{
            die('errur de validation');
        }

        # Calcule prix total
        # Prix résa = (nb logements * ppn du tl*nb nuitées) + (ménage*nb logements) + (nb personnes*prix demi-p * nbnuits)
        $typeLogement = (new TypeLogementModel())->find( $_POST['typeLogement'] );
        $nbNuitee = $this->calculeNbJoursEntreDates($dateEntree, $dateSortie);
        $prixTotal = $_POST['nbLogements'] * $typeLogement['prix_par_nuitee'] * $nbNuitee;

        if( isset( $_POST['menageInclus'] ) ){// Ménage
            $prixTotal += 25 * $_POST['nbLogements'];
        }

        if(  $_POST['typePension']=='PENSION COMPLETE'){// +20€ / logement / nuitée
            $prixTotal += $_POST['nbLogements']  * $nbNuitee * 20;
        }

        # Enregistre réservation
        $reservationModel = new ReservationModel();
        $reservation = [

        ];
        $user_id = (session())->get('user_id');
        $nouvResId = $reservationModel->insert([
            'utilisateur_id'=>$user_id,
            'prix_total'=>$prixTotal,
            'date_entree'=>$dateEntree,
            'date_sortie'=>$dateSortie,
            'etat'=>'NON-VALIDE',
            'type_sejour'=>$_POST['typePension'],
            'menage_fin_sejour_inclus'=>isset( $_POST['menageInclus'] )
            ]);

        # Enregistre réservationLogement
        $resLogementModel = new ReservationLogementModel();
        $resLogementModel->insert([
            'id_typelogement'=>$typeLogement['id'],
            'id_reservation'=>$nouvResId,
            'quantite'=>$_POST['nbLogements']
        ]);

        # Affiche vue message 'résearvation enregistrée'
        echo view('message',
            ['titre'=>'Réservation enregistrée',
            'message'=>'Merci pour votre réservation. Nous revenons vers vous pour confirmation!']);
    }

    public function index() {

        $data = [];

        // Charge types de logement
        $model = new TypeLogementModel();
        $typesLogements = [];
        foreach ( $model->findAll() as $typeLogement ){
            $typesLogements[ $typeLogement['id'] ] = $typeLogement['nom'];
        }
        $data['typesLogements'] = $typesLogements;

        helper(['form']);

        echo view('reservation', $data);
    }
}