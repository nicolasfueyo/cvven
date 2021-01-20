<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller {
    public function index(){
        //$session = session();
        //echo "Content de vous revoir, ".$session->get('user_name');
        echo view('dashboard');
    }
    
    public function dash(){
        return redirect()->to(site_url('param.php'));
    }
}