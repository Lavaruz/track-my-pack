<?php

namespace App\Controllers;
use App\Models\PengirimanModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Psr\Log\LoggerInterface;

class Home extends BaseController
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

        return view('index', $config);
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
            $data['start']      = $this->request->getVar('start') == null ? 0 : $this->request->getVar('start');
            $data['limit']      = $this->request->getVar('length') == null ? 0 : $this->request->getVar('length');
            $data['search']     = $this->request->getVar('search') == null ? '' : $this->request->getVar('search')['value'];
            $_order             = $this->request->getVar('order') == null ? '1' : $this->request->getVar('order')[0]['column'];
            $data['order']      = $this->request->getVar('columns')[$_order]['data'];
            $data['sort']       = $this->request->getVar('order') == null ? 'asc' : $this->request->getVar('order')[0]['dir'];

            $res                = $this->pengirimanModel->getAllDashboard($data);
        }

        echo json_encode($res);
    }

}
