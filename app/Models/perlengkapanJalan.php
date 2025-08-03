<?php

namespace App\Models;

use CodeIgniter\Model;

class perlengkapanJalan extends Model
{

   protected $table = 'tb_perlengkapan_jln';
   protected $primaryKey = 'id_perlengkapan_jln';

   protected $allowedFields = [
      'pengadaan_id',
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
        $this->db->table('tb_perlengkapan_jln')->insert($data);
   }

   public function getCoordinates($category, $type)
   {
        $data = $this->db->table('tb_perlengkapan_jln')
        ->select('*')
        ->where('jenis_perlengkapan', $category) 
        ->where('kondisi', $type) 
        ->get()
        ->getResultArray();
      
        return $data;
   }

   public function pengadaan()
   {
        return $this->belongsTo(Pengadaan::class, 'pengadaan_id', 'id');
   }
}
