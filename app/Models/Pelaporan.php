<?php

namespace App\Models;

use CodeIgniter\Model;

class Pelaporan extends Model
{

    protected $table = 'tb_pelaporan';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'email',
        'no_hp',
        'keterangan',
        'foto_bukti',
        'created_at',
        'updated_at',
    ];
    public function insertData($data)
    {
        $this->db->table('tb_pelaporan')->insert($data);
    }
}
