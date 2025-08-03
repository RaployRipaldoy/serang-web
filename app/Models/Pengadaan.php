<?php

namespace App\Models;

use CodeIgniter\Model;

class Pengadaan extends Model
{

   protected $table = 'tb_pengadaan_jln';
   protected $primaryKey = 'id';

   protected $allowedFields = [
      'nama_perlengkapan',
      'jenis_perlengkapan',
      'jumlah_ketersediaan',
      'keterangan',
      'created_at',
      'updated_at',
      'created_by',
      'updated_by',
  ];
   public function insertData($data)
   {
        $this->db->table('tb_pengadaan_jln')->insert($data);
   }

   public function perlengkapanJalan()
   {
        return $this->hasMany(perlengkapanJalan::class, 'pengadaan_id', 'id');
   }

   public function getPengadaanByPerlengkapan($jenis_perlengkapan)
   {
      $pengadaan = $this->where('jenis_perlengkapan', $jenis_perlengkapan)
         ->where('jumlah_ketersediaan >', 0)
         ->findAll();
      return $pengadaan;
   }

   public function checkKetersediaan($id)
   {
      $pengadaan = $this->find($id);
      if ($pengadaan && $pengadaan['jumlah_ketersediaan'] > 0) {
         return true;
      }
      return false;
   }

   public function decreementPengadaan($id)
   {
      $pengadaan = $this->find($id);
      if ($pengadaan && $pengadaan['jumlah_ketersediaan'] > 0) {
         $pengadaan['jumlah_ketersediaan'] -= 1;
         $this->update($id, ['jumlah_ketersediaan' => $pengadaan['jumlah_ketersediaan']]);
         return true;
      }
      return false;
   }
}
