<?php

namespace App\Models;

use CodeIgniter\Model;

class PengirimModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pengirim';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'nomor_hp',
        'alamat',
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
