<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Firebase\JWT\JWT;

class LoginController extends BaseController
{
    protected $userModel;

    /**
     * Proses inisiasi Controller
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->userModel = new UserModel();
    }

    public function index()
    {
        $session = session();
        if ($session->get('logged_in')) {
            return redirect()->to('/dashboard');
        } else {
            return view('login');
        }
    }

    /**
     * Proses otentikasi user
     * @param mixed $_POST
     * @return redirect
     */
    public function auth()
    {
        // Init
        $session    = session();
        $status     = 'failed';
        $message    = 'Terjadi kesalahan, silahkan coba lagi';  

        // GET Vars
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        try {
            // Superuser (Without need DB access)
            $superuser = (($username == 'admin_kkp@super') && $password == hash('sha256', 'kkp@super'));

            // SuperUser Method
            if ($superuser) {
                $data = $this->userModel->where('id', '1')->first();

                $sessiondata = array(
                    'user_id'   => 1,
                    'username'  => 'admin_kkp',
                    'email'     => 'superadmin@tmp.id',
                    'nomor_hp'  => '123456',
                    'id_role'   => 1,
                    'logged_in' => TRUE
                );

                $session->set('user_detail', $sessiondata);
                $status = 'success';
                $message = 'Sukses login';

            // Normal User Method
            } else {
                $data = $this->userModel->where("username='$username' OR email='$username'")->first();
    
                // Jika username / email ditemukan
                if($data) {
                    $pass = $data['password'];
                    $verify_pass = password_verify($password, $pass);
    
                    // Jika password verified
                    if($verify_pass) {
                        $ses_data = [
                            'user_id'       => $data['id'],
                            'username'      => $data['username'],
                            'email'         => $data['email'],
                            'nomor_hp'      => $data['nomor_hp'],
                            'id_role'       => $data['id_role'],
                            'logged_in'     => TRUE
                        ];
    
                        $session->set('user_detail', $ses_data);
                        $status = 'success';
                        $message = 'Sukses login';
    
                    // Jika password salah
                    } else {
                        $message = 'Password anda salah';
                    }
    
                // Jika username / email tidak ditemukan
                } else {
                    $message = 'Username / Email anda tidak ditemukan';
                }
            }
        } catch(Exception $e) {
            $message = 'Otentikasi Error:'.$e->getMessage();
        }

        $result = array(
            'status' => $status,
            'message' => $message,
        );

        return json_encode($result);
    }

    /**
     * Destroy session saat ini dan redirect ke Login Page
     * @return RedirectResponse
     */
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
