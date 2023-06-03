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

        $_search    = $data['search'];

        if($_search) {
            $builder->where("(
                LOWER(no_resi) LIKE '%$_search%' OR 
                LOWER(pengirim) LIKE '%$_search%' OR
                LOWER(penerima) LIKE '%$_search%' OR
                LOWER(status) LIKE '%$_search%'
            )");
        }
        
        $builder->orderBy($data['order'], $data['sort']);

        $result     = $builder->get()->getResult();

        return $result;
    }

    public function getDetailByResi($id)
    {
        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where('LOWER(no_resi)', $id);
        return $builder->get()->getRow();
    }

    public function do_add($data)
    {
        # code...
    }

    public function do_update($id, $data)
    {
        # code...
    }

    public function do_delete($id)
    {
        # code...
    }
    
}
