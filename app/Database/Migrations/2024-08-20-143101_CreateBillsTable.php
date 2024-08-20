<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBillsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'auto_increment' => true],
            'user_id'       => ['type' => 'INT'],
            'product_id'    => ['type' => 'INT'],
            'quantity'      => ['type' => 'INT', 'constraint' => '11'],
            'total_price'   => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bills');
    }

    public function down()
    {
        //
    }
}
