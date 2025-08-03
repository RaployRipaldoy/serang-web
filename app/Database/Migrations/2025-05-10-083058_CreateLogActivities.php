<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogActivities extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'user_id'     => ['type' => 'INT', 'null' => true],
            'activity'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'url'         => ['type' => 'TEXT', 'null' => true],
            'method'      => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'user_agent'  => ['type' => 'TEXT', 'null' => true],
            'ip_address'  => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('tb_log_activities');
    }
    
    public function down()
    {
        $this->forge->dropTable('tb_log_activities');
    }
    
}
