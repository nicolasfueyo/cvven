<?php namespace App\Controllers;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use CodeIgniter\Controller;

class Pages extends Controller {
    public function index() {
        return view('welcome_message');
    }
    public function view($page = 'home'){
        if ( !is_file(APPPATH.'/Views/pages/'.$page.'.php')) {
            // Whoops, we don't have a page for that!
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
        
        $data['title'] = ucfirst($page); // Capitaliize the first letter
        
        echo view('templates/header', $data);
        echo view('pages/' .$page, $data);
        echo view ('templates/footer', $data);
    }
}