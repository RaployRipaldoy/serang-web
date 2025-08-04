<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JenisPerlengkapanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_perlengkapan' => 'Lampu Jalan LED',
                'jenis_perlengkapan' => 'Penerangan Jalan',
                'created_by' => 'admin',
                'updated_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_perlengkapan' => 'Rambu Peringatan',
                'jenis_perlengkapan' => 'Rambu Lalu Lintas',
                'created_by' => 'management',
                'updated_by' => 'management',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_perlengkapan' => 'Marka Jalan Putih',
                'jenis_perlengkapan' => 'Marka Jalan',
                'created_by' => 'admin',
                'updated_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_perlengkapan' => 'Traffic Light',
                'jenis_perlengkapan' => 'APILL',
                'created_by' => 'management',
                'updated_by' => 'management',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_perlengkapan' => 'Guardrail Baja',
                'jenis_perlengkapan' => 'Pengaman Jalan',
                'created_by' => 'admin',
                'updated_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert sample data
        $this->db->table('tb_jenis_perlengkapan')->insertBatch($data);
    }
}
