<?php

namespace App\Controllers;
use App\Models\ProductModel;
class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    public function dashboard()
    {
        return view('dashboard');
    }
    public function generate_bill(){
        return view('generate_bill');
    }
    
     public function searchProduct()
    {
        $productModel = new ProductModel();
        $query = $this->request->getVar('query');
        $products = $productModel->searchProducts($query);

        return $this->response->setJSON($products);
    
    }
    public function save(){
        
    }
}
