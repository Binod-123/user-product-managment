<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'auto_increment' => true],
            'product_name'  => ['type' => 'VARCHAR', 'constraint' => '100'],
            'product_code'  => ['type' => 'VARCHAR', 'constraint' => '50'],
            'price'         => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'stock_quantity'=> ['type' => 'INT', 'constraint' => '11'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('products');
    }

    public function down()
    {
        //
    }
}
