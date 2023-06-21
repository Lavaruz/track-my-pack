<?php

namespace App\Models;

use CodeIgniter\Model;

class PerusahaanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'perusahaan_logistik';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'alamat',
        'nomor_telepon',
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
            $this->table.id,
            $this->table.nama,
            $this->table.alamat,
            $this->table.nomor_telepon,
        ";

        $builder    = $this->db->table($this->table);
        $builder->select($_select);

        $builder->where("COALESCE($this->table.is_deleted, '0') != '1'");
        
        // Get Total
        $count      = $builder->countAllResults(false);

        $_search    = $data['search'];
        if($_search) {
            $builder->where("(
                LOWER($this->table.nama) LIKE LOWER('%$_search%') OR 
                LOWER($this->table.alamat) LIKE LOWER('%$_search%') OR
                LOWER($this->table.nomor_telepon) LIKE LOWER('%$_search%')
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
        $builder->where("$this->table.id", $id);
        return $builder->get()->getRow();
    }
}
