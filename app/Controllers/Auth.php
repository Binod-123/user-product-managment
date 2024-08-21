<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    public function register()
    {
        $data = [];
        if ($this->request->getMethod() == 'POST') {
            // Validation rules
            //echo "hello world";
            $rules = [
                'username' => 'required|min_length[3]|max_length[20]|alpha_numeric|is_unique[users.username]',
                'email'    => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]|numeric',
            ];

            if ($this->validate($rules)) {
                // If validation passes, save the user
                $userModel = new UserModel();

                $newData = [
                    'username' => $this->request->getPost('username'),
                    'email'    => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                ];

                $userModel->save($newData);
                return redirect()->to('login'); // Redirect to login after successful registration
            } else {
                // If validation fails, pass validation errors to view
                $data['validation'] = $this->validator;
                
            }
        }
        
        echo view('auth/register', $data); // Load the register view
    }
    public function login()
    {
        $data = [];
    //echo $this->request->getMethod();
        if ($this->request->getMethod() == 'POST') {
           // echo "hello world";
            // Validation rules
            $rules = [
                'username' => 'required',
                'password' => 'required',
            ];
    
            if ($this->validate($rules)) {
                $userModel = new UserModel();
                $loginAttemptsModel = new \App\Models\LoginAttemptsModel();
              
                $user = $userModel->where('username', $this->request->getPost('username'))->first();
                $ipAddress = $this->request->getIPAddress();
                
                if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
                    // Set session or token for the logged-in user
                    session()->set([
                        'user_id'   => $user['id'],
                        'username'  => $user['username'],
                        'logged_in' => true,
                    ]);
    
                    // Log successful login attempt
                    $loginAttemptsModel->save([
                        'username'    => $this->request->getPost('username'),
                        'success'     => true,
                        'attempt_time'=> date('Y-m-d H:i:s'),
                        'ip_address'  => $ipAddress,
                    ]);
    
                    return redirect()->to('/dashboard'); // Redirect to a secure area
                } else {
                    // Log failed login attempt
                    $loginAttemptsModel->save([
                        'username'    => $this->request->getPost('username'),
                        'success'     => false,
                        'attempt_time'=> date('Y-m-d H:i:s'),
                        'ip_address'  => $ipAddress,
                    ]);
    
                    session()->setFlashdata('error', 'Invalid login credentials');
                    return redirect()->back()->withInput();
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
    
        echo view('Auth/login', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
