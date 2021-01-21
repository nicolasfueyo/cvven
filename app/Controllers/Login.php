<?php namespace App\Controllers;
 
use CodeIgniter\Controller;
use App\Models\UserModel;
 
class Login extends Controller
{
    public function index()
    {
        helper(['form']);
        echo view('login');
    } 
 
    public function auth(){
        $adm_mail = 'admin@gmail.com';
        $session = session();
        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $model->where('user_email', $email)->first();
        if($data){
            $ses_data = [
                    'user_id'       => $data['user_id'],
                    'user_name'     => $data['user_name'],
                    'user_email'    => $data['user_email'],
                    'logged_in'     => TRUE
                ];
            $pass = $data['user_password'];
            $verify_pass = password_verify($password, $pass);
            
            if($verify_pass && $email === $adm_mail){
                
                $session->set($ses_data);
                return redirect()->to(site_url('AdminPage'));
            }
                if($verify_pass){
                    $session->set($ses_data);
                    return redirect()->to(site_url('Dashboard'));
                }else{
                    $session->setFlashdata('msg', 'Mauvais mot de passe');
                    return redirect()->to(site_url('Login'));
                }

            }else{
                $session->setFlashdata('msg', 'Email non trouvée');
                return redirect()->to(site_url('Login'));
            
    }
    }
 
    public function logout()
    {
        //$session = session();
        session()->destroy();
        return redirect()->to(site_url());
    }
} 