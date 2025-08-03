<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRencanaAnggaranBiaya extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama_perlengkapan' => ['type' => 'VARCHAR', 'constraint' => 100],
            'jumlah_unit' => ['type' => 'INT', 'unsigned' => true],
            'keterangan' => ['type' => 'TEXT', 'null' => true],
            'biaya' => ['type' => 'BIGINT', 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tb_rencana_anggaran_biaya');
    }

    public function down()
    {
        $this->forge->dropTable('tb_rencana_anggaran_biaya');
    }
}
