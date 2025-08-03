<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePemeliharaanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_pemeliharaan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'jenis_pemeliharaan' => [
                'type' => 'TEXT',
            ],
            'lokasi_jalan' => [
                'type' => 'TEXT',
            ],
            'latitude' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'longitude' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'keterangan' => [
                'type' => 'TEXT',
            ],
            'terakhir_diupdate' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'diupdate_oleh' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'kondisi' => [
                'type'       => 'ENUM',
                'constraint' => ['perbaikan', 'penggantian', 'pemusnahan'],
                'null'       => false,
            ],
            'foto_pemeliharaan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tb_pemeliharaan_jln');
    }

    public function down()
    {
        $this->forge->dropTable('tb_pemeliharaan_jln');
    }
}
