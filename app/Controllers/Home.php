<?php

namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\BillModel;
class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    public function dashboard()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }else{
        return view('dashboard');
        }
    }
    public function generate_bill(){
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }else{
        return view('generate_bill');
        }
    }
    
     public function searchProduct()
    {
        $productModel = new ProductModel();
        $query = $this->request->getVar('query');
        $products = $productModel->searchProducts($query);

        return $this->response->setJSON($products);
    
    }
    public function save()
    {
        // Auto-generate the bill code
        //$session = session();
       //echo session()->get('user_id');die;
        $billCode = $this->generateBillCode();
    //echo $billCode;die;
        // Retrieve the JSON data from the hidden input field
        $cartDataJson = $this->request->getPost('cart_data');
        $cartData = json_decode($cartDataJson, true);
    
        // Calculate total price from the cart data
        $totalPrice = array_sum(array_column($cartData, 'total'));
       // $userId = $session->get('user_id');
        // Prepare data to be saved
        $data = [
            'user_id' => session()->get('user_id'), // Assuming a static user ID for this example
            'bill_code' => $billCode,
            'total_price' => $totalPrice,
            'products' => json_encode($cartData),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
    
        // Save to the database
        $billModel = new BillModel(); // Assuming you have a model for the bills
        $billModel->insert($data);
        $productModel = new ProductModel();
        foreach ($cartData as $item) {
            // Check current quantity
            $product = $productModel->find($item['id']);
            if ($product && $product['stock_quantity'] >= $item['qty']) {
                // Update the quantity
                $productModel->update($item['id'], [
                    'stock_quantity' => $product['stock_quantity'] - $item['qty']
                ]);
            }
        }
        // Redirect to the home page
        return $this->response->setJSON(['status' => 'success', 'redirect_url' => '/dashboard']);
    }
    
    private function generateBillCode()
    {
        // Example bill code generation: 'BILL' + Current Year + Unique Number
        $currentYear = date('Y');
        $uniqueNumber = mt_rand(1000, 9999); // Or use a more sophisticated logic based on your requirements
    
        return 'BILL' . $currentYear . $uniqueNumber;
    }
}
