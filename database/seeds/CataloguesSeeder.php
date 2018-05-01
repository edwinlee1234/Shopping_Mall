<?php

use Illuminate\Database\Seeder;
use App\Model\Catalogues as CataloguesModel;

class CataloguesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CataloguesModel::create(array(
            'id' => 1,
            'type' => 'Con',
            'parents' => 0,
        ));

        for($i = 1; $i <= 3; $i++) {
            CataloguesModel::create(array(
                'type' => "Ser$i",
                'parents' => 1,
            ));
        }
    }
}
