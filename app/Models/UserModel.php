<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "id",
        "nama",
        "email",
        "nomor_hp",
        "username",
        "password",
        "id_role",
    ];

    // Settings
        // Dates
        protected $useTimestamps = false;
        protected $dateFormat    = 'datetime';
        protected $createdField  = 'ctime';
        protected $updatedField  = 'mtime';
        protected $deletedField  = 'dtime';

        // Validation
        protected $validationRules      = [];
        protected $validationMessages   = [];
        protected $skipValidation       = false;
        protected $cleanValidationRules = true;

        // Callbacks
        protected $allowCallbacks = true;
        protected $beforeInsert   = [];
        protected $afterInsert    = [];
        protected $beforeUpdate   = [];
        protected $afterUpdate    = [];
        protected $beforeFind     = [];
        protected $afterFind      = [];
        protected $beforeDelete   = [];
        protected $afterDelete    = [];
    // End of Settings

    /**
     * GET semua data laporan pengiriman berdasarkan user role
     */
    public function getAllDashboard($data)
    {
        $_select    = "
            ROW_NUMBER() OVER (ORDER BY $this->table.id) AS no,
            $this->table.id,
            $this->table.nama,
            $this->table.email,
            $this->table.nomor_hp,
            $this->table.username,
            roles.nama_role
        ";

        $builder    = $this->db->table($this->table);
        $builder->select($_select);
        $builder->join('roles', 'roles.id=id_role', 'LEFT');

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
                LOWER($this->table.nama) LIKE LOWER('%$_search%') OR 
                LOWER($this->table.username) LIKE LOWER('%$_search%') OR
                LOWER($this->table.email) LIKE LOWER('%$_search%') OR
                LOWER($this->table.nomor_hp) LIKE '%$_search%' OR
                LOWER(roles.nama_role) LIKE LOWER('%$_search%')
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
        $builder->select("$this->table.*, roles.nama_role");
        $builder->join("roles", "roles.id = $this->table.id_role", "LEFT");
        $builder->where('id', $id);
        return $builder->get()->getRow();
    }


    /**
     * Menambah data baru
     * @param mixed $data Berisi data pengguna wajib seperti nama, username, password dll
     * @return array Response
     */
    public function do_add($data) {
        $status     = 'success';
        $message    = 'Data berhasil ditambah';
        $data       = '';

		if (!isset($data['password'])) $data['password'] = hash('sha256', 'track2023');
		if (!isset($data['id_role'])) $data['id_role'] = '3';
        try {
            $process = $this->insert($data);
            if($process) {
                $data = $this->getInsertID();
            }
        } catch(Exception $e) {
            $status     = 'failed';
            $message    = 'Data gagal ditambah: '.$e->getMessage();
        }

        $result = array('status' => $status, 'data' => $data, 'message' => $message);
        
        return $result;
	}

    /**
     * Mengubah data
     * @param integer $id User ID yang ingin diubah (Wajib)
     * @param mixed $data Berisi data pengguna wajib seperti nama, username, password dll
     * @return array Response
     */
    public function do_update($id, $data = []) {
        $status     = 'success';
        $message    = 'Data berhasil diubah';

        if(isset($id)) {
            try {
                $this->update($id, $data);
            } catch(Exception $e) {
                $status     = 'failed';
                $message    = 'Data gagal diubah: '.$e->getMessage();
            }
        } else {
            $status     = 'failed';
            $message    = 'ID tidak boleh kosong';
        }

        $result = array('status' => $status, 'data' => $data, 'message' => $message);
        
        return $result;
    }

    /**
     * Menghapus data (soft delete)
     * @param integer $id User ID yang ingin diubah (Wajib)
     * @param mixed $data berisi dtime, duser_id, dan flag is_deleted = ('1')
     * @return array Response
     */
    public function do_delete($id, $data = ['is_deleted' => '1']) {
        $status     = 'success';
        $message    = 'Data berhasil dihapus';

        if(isset($id)) {
            try {
                $this->update($id, $data);
            } catch(Exception $e) {
                $status     = 'failed';
                $message    = 'Data gagal dihapus: '.$e->getMessage();
            }
        } else {
            $status     = 'failed';
            $message    = 'ID tidak boleh kosong';
        }

        $result = array('status' => $status, 'data' => $data, 'message' => $message);
        
        return $result;
    }
}
