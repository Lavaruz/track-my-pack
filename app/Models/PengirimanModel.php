<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class PengirimanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'laporan_pengiriman';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'no_resi',
        'id_pengirim',
        'id_penerima',
        'id_barang',
        'id_user',
        'tanggal_masuk',
        'tanggal_keluar',
        'id_status',
        'ctime',
        'cuser_id',
        'mtime',
        'muser_id',
        'dtime',
        'duser_id',
        'is_deleted',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'ctime';
    protected $updatedField  = 'mtime';
    protected $deletedField  = 'dtime';

    /**
     * GET semua data laporan pengiriman berdasarkan user role
     */
    public function getAllDashboard($data)
    {
        $_select    = "
            ROW_NUMBER() OVER (ORDER BY $this->table.id) AS no,
            no_resi,
            pengirim.nama AS pengirim,
            penerima.nama AS penerima,
            penerima.alamat AS destinasi,
            status.nama AS status
        ";

        $builder    = $this->db->table($this->table);
        $builder->select($_select);
        $builder->join('pengirim', 'pengirim.id=id_pengirim', 'LEFT');
        $builder->join('penerima', 'penerima.id=id_penerima', 'LEFT');
        $builder->join('status', 'status.id=id_status', 'LEFT');

        $builder->where("COALESCE($this->table.is_deleted, '0') != '1'");
        
        // Based on User role
        if($data['role'] == '2') {
            $builder->where("id_user", $data['user_id']);
        }

        // Get Total
        $count      = $builder->countAllResults(false);

        $_search    = $data['search'];
        if($_search) {
            $builder->where("(
                LOWER($this->table.no_resi) LIKE '%$_search%' OR 
                LOWER(pengirim.nama) LIKE '%$_search%' OR
                LOWER(penerima.nama) LIKE '%$_search%' OR
                LOWER(status.nama) LIKE '%$_search%'
            )");
        }

        $builder->orderBy($data['order'], $data['sort']);

        // Get Filtered Total
        $filtered   = $builder->countAllResults(false);
        // Get Data
        $dt         = $builder->get()->getResult();

        return array('draw' => $_POST['draw'], 'recordsTotal' => $count, 'recordsFiltered' => $filtered, 'data' => $dt);
    }

    public function getDetailById($id)
    {
        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where('id', $id);
        return $builder->get()->getRow();
    }

    public function getDetailByResi($id)
    {
        $builder = $this->db->table($this->table);
        $builder->select(
            "$this->table.no_resi, DATE_FORMAT($this->table.tanggal_masuk,'%d-%m-%Y') AS tanggal_masuk,
            pengirim.nama AS nama_pengirim,
            pengirim.nomor_hp AS nomor_pengirim,
            pengirim.alamat AS alamat_pengirim,
            penerima.nama AS nama_penerima,
            penerima.nomor_hp AS nomor_penerima,
            penerima.alamat AS alamat_penerima,
            status.nama AS status,
            barang.nama AS nama_barang, barang.berat AS berat_barang"
        );
        $builder->join('pengirim', 'pengirim.id=id_pengirim', 'LEFT');
        $builder->join('penerima', 'penerima.id=id_penerima', 'LEFT');
        $builder->join('status', 'status.id=id_status', 'LEFT');
        $builder->join('barang', 'barang.id=id_barang', 'LEFT');
        $builder->where("LOWER($this->table.no_resi)", $id);
        return $builder->get()->getRow();
    }

    public function do_add($data)
    {
        $builder = $this->db->table($this->table);
        $builder->insert($data);
        return $this->db->insertID();
    }

    public function do_update($id, $data)
    {
        $builder = $this->db->table($this->table);
        $builder->where('id', $id);
        $result = $builder->update($data);

        return $result;
    }
    
}
