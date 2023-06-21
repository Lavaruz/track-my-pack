<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PerusahaanModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class PerusahaanController extends BaseController
{
    protected $perusahaanModel;

    /**
     * Proses inisiasi Controller
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->perusahaanModel = new PerusahaanModel();

    }

    public function index()
    {
        $session = session();
        $config['session'] = $session->get('user_detail');

        return view('perusahaan/index', $config);
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

            $res                = $this->perusahaanModel->getAllDashboard($data);
        }

        echo json_encode($res);
    }

    public function form($action = 'add', $id = '')
    {
        $session = session();
        $config['session'] = $session->get('user_detail');

        $data = array();
        $data['action'] = "do_$action";
        $data['data'] = [];

        if($action == 'update' || $action == 'view') {
            if($id == '') throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Halaman tidak ditemukan');

            $detail = $this->perusahaanModel->getDetailById($id);
            if(!$detail) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('No Resi tidak ditemukan');

            $data['data'] = $detail;
        }

        return view('perusahaan/form', $data);
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
            'alamat'            => $this->request->getVar('alamat'),
            'nomor_telepon'     => $this->request->getVar('nomor_telepon'),
            'cuser_id'          => $user_detail['user_id'],
            'is_deleted'        => '0',
        ];
        
        $res = $this->perusahaanModel->insert($data);
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
            'alamat'            => $this->request->getVar('alamat'),
            'nomor_telepon'     => $this->request->getVar('nomor_telepon'),
            'muser_id'          => $user_detail['user_id'],
            'mtime'             => date('Y-m-d H:i:s'),
        ];
        
        $res = $this->perusahaanModel->update($id, $data);
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
            
            $res = $this->perusahaanModel->update($id, $data);
            if($res) {
                $status = 'success';
                $message = 'Data sukses terhapus';
            }
        }

        $result = array('status' => $status, 'message' => $message);
        echo json_encode($result);
    }
}
