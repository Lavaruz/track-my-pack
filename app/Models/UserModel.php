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
    protected $insertID         = 0;
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
    public function do_update($id, $data) {
        $status     = 'success';
        $message    = 'Data berhasil diubah';
        $data       = '';

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
    public function do_delete($id, $data) {
        $status     = 'success';
        $message    = 'Data berhasil dihapus';
        $data       = '';

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
