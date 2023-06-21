<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'roles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_role',
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
}
