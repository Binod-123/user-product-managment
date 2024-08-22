<?php

namespace App\Models;

use CodeIgniter\Model;

class BillModel extends Model
{
    protected $table = 'bills';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'bill_code', 'total_price', 'products', 'created_at', 'updated_at'];

    public function getBillsByUserId($userId)
    {
        // $bills = $this->where('user_id', $userId)->findAll();
        $bills = $this->db->table('bills')
                      ->select('bills.*, users.username') // Select columns from bills and username from users
                      ->join('users', 'users.id = bills.user_id') // Join with users table
                      ->where('bills.user_id', $userId) // Filter by user ID
                      ->get()
                      ->getResultArray();

        // Process each bill to count the number of products
        foreach ($bills as &$bill) {
            $products = json_decode($bill['products'], true);
            $bill['products_count'] = count($products); // Add product count to the response
        }

        return $bills;
    }
    public function getBillDetailsByBillNo($billNo)
{
    return $this->where('bill_code', $billNo)->first();
}
}


