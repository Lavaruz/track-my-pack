<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengirimanModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class PengirimanController extends BaseController
{
    protected $pengirimanModel;

    /**
     * Proses inisiasi Controller
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->pengirimanModel = new PengirimanModel();
    }

    public function index()
    {
        $session = session();
        $config['session'] = $session->get('user_detail');

        return view('pengiriman/index');
    }

    public function form($action = 'add', $id = '')
    {
        $session = session();
        $config['session'] = $session->get('user_detail');

        $data = array();
        $data['action'] = "do_$action";

        if($action == 'update') {
            if($id == '') throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Halaman tidak ditemukan');

            $detail = $this->pengirimanModel->getDetailById($id);
            if(!$detail) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('ID tidak ditemukan');

            $data['data'] = $detail;
        }

        return view('pengiriman/form', $data);
    }

    public function do_add()
    {
        
    }

    public function do_update($id)
    {
        
    }

    public function getDetailByResi()
    {
        $status = 'failed';
        $message = 'Gagal mendapatkan data';
        $data = array();

        $id = $this->request->getVar('resi');

        if($id != '') {
            $id = trim(strtolower($id));
            $data = $this->pengirimanModel->getDetailByResi($id);
            if($data) {
               $status = 'success';
               $message = 'OK';
            } else {
                $message = 'Data tidak ditemukan';
            }
        } else {
            $message = 'No Resi tidak boleh kosong!';
        }

        $response = array(
            'status' => $status,
            'data' => $data,
            'message' => $message
        );

        return json_encode($response);
    }
}
