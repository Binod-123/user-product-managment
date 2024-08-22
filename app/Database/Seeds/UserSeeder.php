<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => password_hash('Admin@123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
            ],];
            $this->db->table('users')->insertBatch($data);
    }
}
