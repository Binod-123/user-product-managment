<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_name', 'product_code', 'price', 'stock_quantity'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    public function searchProducts($query)
    {
        return $this->groupStart()
                        ->like('product_name', $query)
                        ->orLike('product_code', $query)
                    ->groupEnd()
                    ->where('stock_quantity >', 0)
                    ->where('price >', 0)
                    ->findAll();
    }
}
