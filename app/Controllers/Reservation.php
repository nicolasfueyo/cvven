<?php namespace App\Controllers;

use App\Models\TypeLogementModel;
use CodeIgniter\Controller;

class Reservation extends Controller {
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