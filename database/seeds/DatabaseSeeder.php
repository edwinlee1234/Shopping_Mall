<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(ProductsSeeder::class);
         $this->call(CataloguesSeeder::class);
         $this->call(UsersSeeder::class);
    }
}
