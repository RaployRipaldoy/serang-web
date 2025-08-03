<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePelaporan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'foto_bukti' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tb_pelaporan');
    }

    public function down()
    {
        $this->forge->dropTable('tb_pelaporan');
    }
}
