<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PerusahaanModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class UserController extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $perusahaanModel;

    /**
     * Proses inisiasi Controller
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->perusahaanModel = new PerusahaanModel();
    }

    public function index()
    {
        $session = session();
        $config['session'] = $session->get('user_detail');
        if(!isset($config['session']) || $config['session']['id_role'] != '1') {
            return redirect('Home::index');
        }

        return view('user/index', $config);
    }

    /**
     * Proses mendapat data datatable AJAX
     * @param mixed $_POST
     * @return json
     */
    public function getAllDashboard()
    {
        $session            = session();
        $user_detail        = $session->get('user_detail');

        $res                = array();
        if(isset($user_detail) || 1==1) {
            $data['role']       = $user_detail['id_role'];
            $data['user_id']    = $user_detail['user_id'];
            $data['start']      = $this->request->getVar('start') == null ? 0 : $this->request->getVar('start');
            $data['limit']      = $this->request->getVar('length') == null ? 0 : $this->request->getVar('length');
            $data['search']     = !isset($this->request->getVar('search')['value']) ? '' : $this->request->getVar('search')['value'];
            $_order             = $this->request->getVar('order') == null ? '1' : $this->request->getVar('order')[0]['column'];
            $data['order']      = $this->request->getVar('columns')[$_order]['data'];
            $data['sort']       = $this->request->getVar('order') == null ? 'asc' : $this->request->getVar('order')[0]['dir'];

            $res                = $this->userModel->getAllDashboard($data);
        }

        echo json_encode($res);
    }

    public function form($action = 'add', $id = '')
    {
        $session = session();
        $config['session'] = $session->get('user_detail');

        $data = array();
        $data['action'] = "do_$action";
        $data['role'] = $this->roleModel->select(['id', 'nama_role'])->where("is_deleted != '1'")->findAll();
        $data['perusahaan'] = $this->perusahaanModel->select(['id', 'nama'])->where("is_deleted != '1'")->findAll();
        $data['data'] = [];

        if($action == 'update' || $action == 'view') {
            if($id == '') throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Halaman tidak ditemukan');

            $detail = $this->userModel->getDetailById($id);
            if(!$detail) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('ID tidak ditemukan');

            $data['data'] = $detail;
        }
        
        return view('user/form', $data);
    }

    public function do_add()
    {
        $session = session();
        $user_detail = $session->get('user_detail');

        $result = array();
        $status = 'failed';
        $message = '';

        $data = [
            'nama'              => $this->request->getVar('nama'),
            'email'             => $this->request->getVar('email') ?? null,
            'nomor_hp'          => $this->request->getVar('nomor_hp') ?? null,
            'username'          => $this->request->getVar('username'),
            'password'          => password_hash($this->request->getVar('password') ?? 'tmp2023', PASSWORD_DEFAULT),
            'id_role'           => $this->request->getVar('id_role'),
            'id_perusahaan'     => $this->request->getVar('id_perusahaan'),
            'cuser_id'          => $user_detail['user_id'],
            'is_deleted'        => '0',
        ];

        $res = $this->userModel->insert($data);
        if($res) {
            $status = 'success';
            $message = 'Data sukses tersimpan';
        }

        $result = array('status' => $status, 'message' => $message);
        echo json_encode($result);
    }

    public function do_update($id)
    {
        $session = session();
        $user_detail = $session->get('user_detail');

        $result = array();
        $status = 'failed';
        $message = '';
        $data = [
            'nama'              => $this->request->getVar('nama'),
            'email'             => $this->request->getVar('email') ?? null,
            'nomor_hp'          => $this->request->getVar('nomor_hp') ?? null,
            'username'          => $this->request->getVar('username'),
            'id_role'           => $this->request->getVar('id_role'),
            'id_perusahaan'     => $this->request->getVar('id_perusahaan'),
            'muser_id'          => $user_detail['user_id'],
            'mtime'             => date('Y-m-d H:i:s'),
        ];

        if($this->request->getVar('password') != '') {
            $data['password'] = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        }

        $res = $this->userModel->update($id, $data);
        if($res) {
            $status = 'success';
            $message = 'Data sukses tersimpan';
        }

        $result = array('status' => $status, 'message' => $message);
        echo json_encode($result);
    }

    public function do_delete()
    {
        $session = session();
        $user_detail = $session->get('user_detail');

        $result = array();
        $status = 'failed';
        $message = 'Data tidak ditemukan';
        $data = [];

        $id   = $this->request->getVar('id');

        if(isset($id) && $id != '') {
            $data = [
                'duser_id'          => $user_detail['user_id'],
                'dtime'             => date('Y-m-d H:i:s'),
                'is_deleted'        => '1',
            ];
            
            $res = $this->userModel->update($id, $data);
            if($res) {
                $status = 'success';
                $message = 'Data sukses terhapus';
            }
        }

        $result = array('status' => $status, 'message' => $message);
        echo json_encode($result);
    }

    public function getDetailById($id)
    {
        $status = 'failed';
        $message = 'Gagal mendapatkan data';
        $data = array();

        if($id != '') {
            $id = trim(strtolower($id));
            $data = $this->userModel->getDetailById($id);
            if($data) {
               $status = 'success';
               $message = 'OK';
            } else {
                $message = 'Data tidak ditemukan';
            }
        } else {
            $message = 'ID tidak boleh kosong!';
        }

        $response = array(
            'status' => $status,
            'data' => $data,
            'message' => $message
        );

        return json_encode($response);
    }
}
