<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJenisPerlengkapan extends Migration
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
            'nama_perlengkapan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'jenis_perlengkapan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
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
                'constraint' => 100,
                'null'       => true,
            ],
            'updated_by' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tb_jenis_perlengkapan');
    }

    public function down()
    {
        
        $this->forge->dropTable('tb_jenis_perlengkapan', true);
    }
}
