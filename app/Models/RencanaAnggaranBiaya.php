<?php

namespace App\Models;

use CodeIgniter\Model;

class RencanaAnggaranBiaya extends Model
{

    protected $table = 'tb_rencana_anggaran_biaya';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_perlengkapan',
        'jumlah_unit',
        'keterangan',
        'biaya',
        'created_at',
        'updated_at',
    ];
    public function insertData($data)
    {
        $this->db->table('tb_rencana_anggaran_biaya')->insert($data);
    }
}
