<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Reservation extends Controller {
    public function index() {
        helper(['form']);
        $data = [];
        echo view('reservation', $data);
    }
}