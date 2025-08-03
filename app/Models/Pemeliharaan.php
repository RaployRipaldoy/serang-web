<?php

namespace App\Models;

use CodeIgniter\Model;

class Pemeliharaan extends Model
{

   protected $table = 'tb_pemeliharaan_jln';
   protected $primaryKey = 'id';

   protected $allowedFields = [
      'nama_perlengkapan',
      'jenis_perlengkapan',
      'lokasi_jalan',
      'latitude',
      'longitude',
      'terakhir_diupdate',
      'diupdate_oleh',
      'keterangan',
      'foto_perlengkapan',
      'kondisi' 
  ];
   public function insertData($data)
   {
        $this->db->table('tb_pemeliharaan_jln')->insert($data);
   }

   public function getCoordinates($category, $type)
   {
        $data = $this->db->table('tb_pemeliharaan_jln')
        ->select('*')
        ->where('jenis_perlengkapan', $category) 
        ->where('kondisi', $type) 
        ->get()
        ->getResultArray();
      
        return $data;
   }
}
