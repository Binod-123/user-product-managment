<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BillModel;
class BillsController extends ResourceController
{
    protected $modelName = 'App\Models\BillModel';
    protected $format    = 'json';

    /**
     * Get bills for a specific user.
     *
     * @param int $userId
     * @return \CodeIgniter\HTTP\Response
     */
    public function getBillsByUser($userId)
    {
        // Instantiate the BillModel
        $billModel =  new BillModel();

        // Fetch bills for the specified user
        $bills = $billModel->getBillsByUserId($userId);

        // Check if bills are found
        if ($bills) {
            $data = [];
            foreach ($bills as $bill) {
                $data[] = [
                    'user_name'=>$bill['username'],
                    'bill_no' => $bill['bill_code'],
                    'product_count' => $bill['products_count'], // Assuming you have user_name
                    'total_price' => $bill['total_price'],
                    'created_at' => $bill['created_at'],
                    'action' => '<button data-id="' . $bill['bill_code'] . '" class="btn btn-info">View</button>'
                ];
            }
           //echo json_encode($bills);die;
            return $this->respond([
                'status' => 'success',
                'data' => $data
            ]);
        } else {
            return $this->respond([
                'status' => 'error',
                'message' => 'No bills found for this user'
            ]);
        }
    }
    public function getBillDetails($billNo)
{           $billModel =  new BillModel();
    $bill = $billModel->getBillDetailsByBillNo($billNo);

    if ($bill) {
        return $this->respond([
            'status' => 'success',
            'data' => $bill
        ]);
    } else {
        return $this->respond([
            'status' => 'error',
            'message' => 'No details found for this bill'
        ], 404);
    }
}
}
