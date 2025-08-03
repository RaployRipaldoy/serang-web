<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengadaanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'jenis_perlengkapan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nama_perlengkapan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'jumlah_ketersediaan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'keterangan' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'updated_by' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tb_pengadaan_jln');
    }

    public function down()
    {
        $this->forge->dropTable('tb_pengadaan_jln');
    }
}
