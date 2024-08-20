<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoginAttemptsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'auto_increment' => true],
            'username'     => ['type' => 'VARCHAR', 'constraint' => '100'],
            'success'      => ['type' => 'BOOLEAN'],
            'attempt_time' => ['type' => 'DATETIME'],
            'ip_address'   => ['type' => 'VARCHAR', 'constraint' => '45'], // to handle both IPv4 and IPv6
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('login_attempts');
    }

    public function down()
    {
        $this->forge->dropTable('login_attempts');
    }
}
