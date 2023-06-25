<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengirimanModel;
use App\Models\StatusModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Dompdf\Dompdf;
use Exception;

class ReportController extends BaseController
{
    protected $pengirimanModel;
    protected $statusModel;
    protected $userModel;

    /**
     * Proses inisiasi Controller
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->pengirimanModel = new PengirimanModel();
        $this->statusModel = new StatusModel();
        $this->userModel = new UserModel();

    }

    public function index()
    {
        $session = session();
        $config['session'] = $session->get('user_detail');

        $config['status'] = $this->statusModel->select(['id', 'nama'])->where('is_deleted', '0')->findAll();

        return view('laporan/index', $config);
    }

    public function generateReport() 
    {
        $result = array();
        $status = 'failed';
        $message = '';
        $filename = '';
        $pathfile = '';

        $user_detail = session()->get('user_detail');
        $user_detail = array_merge($user_detail, $this->userModel->select('nama')->where('id', $user_detail['user_id'])->first() ?? 'Admin');

        $config = [
            'status'            => $this->request->getVar('status'),
            'tanggal_masuk'     => $this->request->getVar('tanggal_masuk'),
            'tanggal_keluar'    => $this->request->getVar('tanggal_keluar') ?? date('Y-m-d'),
            'role'              => $user_detail['id_role'],
            'user_id'           => $user_detail['user_id'],
        ];

        try {
            $data = $this->pengirimanModel->generate_report($config);
            if(count($data) <= 0) throw new Exception("Tidak ada data");

            $filename = "TMP_Report_" . date('Ymd');
            
            $d = array('data' => $data, 'filename' => $filename, 'config' => $config, 'user_detail' => $user_detail);
    
            $dompdf = new Dompdf();
            $dompdf->loadHtml(view('laporan/report', $d)); 
            $dompdf->setPaper('A4', 'landscape');         
            $dompdf->render(); 
            $output = $dompdf->output();

            file_put_contents($filename.'.pdf', $output);

            $status = 'success';
            $filename = $filename;
            $pathfile = base64_encode(base_url($filename.'.pdf'));
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        $result = array('status' => $status, 'message' => $message, 'filename' => $filename, 'pathfile' => $pathfile);

        echo json_encode($result);
    }

    public function deleteTmpFile()
    {
        $json = file_get_contents('php://input');
        $path = parse_url($json);

        if (!unlink(FCPATH . $path['path'])) {
            echo ("Error deleting");
        } else {
            echo ("Deleted");
        };
    }
}
