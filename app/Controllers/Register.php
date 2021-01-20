<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Register extends Controller {
    public function index() {
        helper(['form']);
        $data = [];
        echo view('register', $data);
    }
    
    public function save(){
        helper(['form']);
        
        $rules = [
            'name' => 'required|min_length[3]|max_length[20]',
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.user_email]',
            'password' => 'required|min_length[6]|max_length[20]',
            'confpassword' => 'matches[password]',
        ];
        
        if($this->validate($rules)){
            $model = new UserModel();
            $data = [
                'user_name' => $this->request->getVar('name'),
                'user_email' => $this->request->getVar('email'),
                'user_password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $model->save($data);
            return redirect()->to(site_url('Login'));
        }else{
            $data['validation'] = $this->validator;
            echo view('register', $data);
        }
    }
}