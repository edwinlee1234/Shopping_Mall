<?php

use Illuminate\Database\Seeder;
use App\Model\User as UserModel;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserModel::create(array(
            "name" => "test",
            "type" => "G",
            "email" => "test@test.com",
            "password" => "$2y$10$6T2MyJMfj4s56GGNB.vvNOhVsBJ4ZdEqIiy/6a/F0pzVJuK7Yh7ii",
            "address" => "edwin's home",
            "phone" => "12345678",
        ));

        UserModel::create(array(
            "name" => "admin",
            "type" => "A",
            "email" => "admin@admin.com",
            "password" => "$2y$10$6T2MyJMfj4s56GGNB.vvNOhVsBJ4ZdEqIiy/6a/F0pzVJuK7Yh7ii",
            "address" => "admin's home",
            "phone" => "12345678",
        ));
    }
}
