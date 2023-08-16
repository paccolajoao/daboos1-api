<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class User extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'darth',
            'password'    => 'adsfasdfasdf',
            'name'    => 'jp paccola',
            'email'    => 'darth@theempire.com',
            'status'    => 'ATIVO'
        ];

        $this->db->table('user')->insert($data);
    }
}
