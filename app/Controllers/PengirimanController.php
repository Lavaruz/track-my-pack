<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\PenerimaModel;
use App\Models\PengirimanModel;
use App\Models\PengirimModel;
use App\Models\StatusModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class PengirimanController extends BaseController
{
    protected $pengirimanModel;
    protected $pengirimModel;
    protected $penerimaModel;
    protected $barangModel;
    protected $statusModel;

    /**
     * Proses inisiasi Controller
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->pengirimanModel = new PengirimanModel();
        $this->pengirimModel = new PengirimModel();
        $this->penerimaModel = new PenerimaModel();
        $this->barangModel = new BarangModel();
        $this->statusModel = new StatusModel();
    }

    public function index()
    {
        $session = session();
        $config['session'] = $session->get('user_detail');

        return view('pengiriman/index', $config);
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

            $res                = $this->pengirimanModel->getAllDashboard($data);
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

            $detail = $this->pengirimanModel->getDataByResi(strtolower($id));
            if(!$detail) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('No Resi tidak ditemukan');

            $data['data'] = $detail;
            $data['status'] = $this->statusModel->where("is_deleted != '1'")->findAll();
        }

        return view('pengiriman/form', $data);
    }

    public function do_add()
    {
        $session = session();
        $user_detail = $session->get('user_detail');

        $result = array();
        $status = 'failed';
        $message = '';
        $data = [];

        // Pengirim
        $pengirim_data = [
            'nama'      => $this->request->getVar('pengirim_nama'),
            'nomor_hp'  => $this->request->getVar('pengirim_nomor_hp'),
            'alamat'    => $this->request->getVar('pengirim_alamat'),
            'is_deleted'=> '0',
            'cusr_id'   => $user_detail['user_id'],
        ];
        $pengirim_id = $this->pengirimModel->insert($pengirim_data);

        // Penerima
        $penerima_data = [
            'nama'      => $this->request->getVar('penerima_nama'),
            'nomor_hp'  => $this->request->getVar('penerima_nomor_hp'),
            'alamat'    => $this->request->getVar('penerima_alamat'),
            'is_deleted'=> '0',
            'cusr_id'   => $user_detail['user_id'],
        ];
        $penerima_id = $this->penerimaModel->insert($penerima_data);

        // Barang
        $barang_data = [
            'nama'      => $this->request->getVar('barang_nama'),
            'berat'     => $this->request->getVar('barang_berat'),
            'is_deleted'=> '0',
            'cusr_id'   => $user_detail['user_id'],
        ];
        $barang_id = $this->barangModel->insert($barang_data);

        $rand = strtoupper($this->generate_uuid());
        $resi = 'TMP'.date('Ym').$rand;

        $data = [
            'no_resi'           => $resi,
            'id_pengirim'       => $pengirim_id,
            'id_penerima'       => $penerima_id,
            'id_barang'         => $barang_id,
            'id_user'           => $user_detail['user_id'],
            'tanggal_masuk'     => date('Y-m-d H:i:s'),
            'id_status'         => '1',
            'cuser_id'          => $user_detail['user_id'],
            'is_deleted'        => '0',
        ];
        
        $res = $this->pengirimanModel->do_add($data);
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
        $data = [];

        $dt = $this->pengirimanModel->find($id);

        // Pengirim
        $pengirim_data = [
            'nama'      => $this->request->getVar('pengirim_nama'),
            'nomor_hp'  => $this->request->getVar('pengirim_nomor_hp'),
            'alamat'    => $this->request->getVar('pengirim_alamat'),
            'musr_id'   => $user_detail['user_id'],
            'mtime'     => date('Y-m-d H:i:s'),
        ];
        $this->pengirimModel->update($dt['id_pengirim'], $pengirim_data);

        // Penerima
        $penerima_data = [
            'nama'      => $this->request->getVar('penerima_nama'),
            'nomor_hp'  => $this->request->getVar('penerima_nomor_hp'),
            'alamat'    => $this->request->getVar('penerima_alamat'),
            'musr_id'   => $user_detail['user_id'],
            'mtime'     => date('Y-m-d H:i:s'),
        ];
        $this->penerimaModel->update($dt['id_penerima'], $penerima_data);

        // Barang
        $barang_data = [
            'nama'      => $this->request->getVar('barang_nama'),
            'berat'     => $this->request->getVar('barang_berat'),
            'musr_id'   => $user_detail['user_id'],
            'mtime'     => date('Y-m-d H:i:s'),
        ];
        $this->barangModel->update($dt['id_barang'], $barang_data);

        $data = [
            'tanggal_masuk'     => $this->request->getVar('barang_tgl_masuk') == '' ? null : $this->request->getVar('barang_tgl_masuk'),
            'tanggal_keluar'    => $this->request->getVar('barang_tgl_keluar') == ''? null : $this->request->getVar('barang_tgl_keluar'),
            'id_status'         => $this->request->getVar('status'),
            'muser_id'          => $user_detail['user_id'],
            'mtime'             => date('Y-m-d H:i:s'),
        ];
        
        $res = $this->pengirimanModel->update($id, $data);
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

        $resi   = $this->request->getVar('id');

        if(isset($resi) && $resi != '') {
            $dt = $this->pengirimanModel->where('no_resi', $resi)->first();
    
            $data = [
                'duser_id'          => $user_detail['user_id'],
                'dtime'             => date('Y-m-d H:i:s'),
                'is_deleted'        => '1',
            ];
            
            $res = $this->pengirimanModel->update($dt['id'], $data);
            if($res) {
                $status = 'success';
                $message = 'Data sukses terhapus';
            }
        }

        $result = array('status' => $status, 'message' => $message);
        echo json_encode($result);
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

    public function generate_uuid() {
        return sprintf( '%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}
