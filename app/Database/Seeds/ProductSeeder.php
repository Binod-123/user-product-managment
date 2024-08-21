<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'product_name' => 'iPhone 15',
                'product_code' => 'M001',
                'price' => 50000,
                'stock_quantity' => 100,
            ],
            [
                'product_name' => 'galaxy s24',
                'product_code' => 'M002',
                'price' => 60000,
                'stock_quantity' => 50,
            ],
            [
                'product_name' => 'moto G64',
                'product_code' => 'M003',
                'price' => 20000,
                'stock_quantity' => 3,
            ],
            [
                'product_name' => 'galaxy s24pro',
                'product_code' => 'M004',
                'price' => 80000,
                'stock_quantity' => 2,
            ],
            [
                'product_name' => 'moto P25',
                'product_code' => 'M005',
                'price' => 20000,
                'stock_quantity' => 4,
            ],
            [
                'product_name' => 'iQoo Neo7pro',
                'product_code' => 'M006',
                'price' => 30000,
                'stock_quantity' => 5,
            ],
            [
                'product_name' => 'CFM buds',
                'product_code' => 'TWS001',
                'price' => 2000,
                'stock_quantity' => 20,
            ],
            [
                'product_name' => 'Realme buds 3pro',
                'product_code' => 'TWS002',
                'price' => 2500,
                'stock_quantity' => 3,
            ],
            [
                'product_name' => 'Nike',
                'product_code' => 'SH001',
                'price' => 3000,
                'stock_quantity' => 40,
            ],
            
            // Add more products as needed
        ];

        // Using Query Builder
        $this->db->table('products')->insertBatch($data);
    }
}
