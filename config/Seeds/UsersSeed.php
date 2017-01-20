<?php
use Migrations\AbstractSeed;
use Cake\Auth\DefaultPasswordHasher;

class UsersSeed extends AbstractSeed
{

    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => (new DefaultPasswordHasher)->hash('admin'),
                'role' => 'admin',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'author',
                'password' => (new DefaultPasswordHasher)->hash('author'),
                'role' => 'author',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ]
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
