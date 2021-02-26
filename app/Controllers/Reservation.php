<?php namespace App\Controllers;

use App\Models\CalendrierVacancesModel;
use App\Models\TypeLogementModel;
use CodeIgniter\Controller;

class Reservation extends Controller {

    /**
     * Renvoie true si la date est un samedi, sinon renvoie false.
     * @param $strDate Date au format '20/02/2021'
     * @return bool
     */
    private function estSamedi($strDate)
    {
        $dt = DateTime::createFromFormat('d/m/Y',$strDate );
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
        $dateA = DateTime::createFromFormat('d/m/Y',$strDateA );
        $dateB = DateTime::createFromFormat('d/m/Y',$strDateB );

        return $dateA->getTimestamp() < $dateB->getTimestamp();
    }

    public function post(){

        helper(['form']);

        # Validation demande de réservation
        $rules = [
            'dateEntree' => 'required',
            'dateSortie' => 'required',
            'nbLogements' => 'required',
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

            // Vérifie que les dates entrée recouvre des periodes de vacances
            // NOTE :
            // SELECT * FROM calendirer WHERE date_debut_vac BETWEEN $dateEntree AND $dateSortie
            //                                  AND date_fin_vac BETWEEN $dateEntree AND $dateSortie

            // ou WHERE dateEntree BETWEEN date_debut_vac  AND date_fin_vac
            //                                             AND dateSortie BETWEEN date_debut_vac AND date_fin_vac
            $cal = new CalendrierVacancesModel();
            //$cal->
            // Vérification des disponibilité pour ces dates


            // Si tout est valide : enreistre la réservation et redirection
        }else{
            die('errur de validation');
        }

        # Enregistre la réservation

        # Affiche vue message 'résearvation enregistrée'
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