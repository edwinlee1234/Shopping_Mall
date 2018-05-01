<?php

use Illuminate\Database\Seeder;
use App\Model\Merchandise as MerchandiseModel;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 300; $i++) {
            $intro = array(
                "intro_tw" => "<p>介紹 (繁中)$i</p>>",
                "intro_cn" => "<p>介紹 (簡中)$i</p>>",
                "intro_en" => "<p>介紹 (英文)$i</p>>",
            );

            $extra = array(
                "degrees" => array(100, 200, 300, 400, 500),
            );

            $photos = array(
                "images/merchandise/QA0608@1_50.jpg",
                "images/merchandise/MA0118@1_504.jpg",
                "images/merchandise/QA0582@1_506.jpg",
            );

            $merchandiseData = array(
                "name_tw" => "商品名稱 (繁中)$i",
                "name_cn" => "商品名稱 (簡中)$i",
                "name_en" => "商品名稱 (英文)$i",
                "introduction" => json_encode($intro),
                "brand" => "brand-$i",
                "type" => rand(2, 4),
                "price" => rand(100, 30000),
                "extra_info" => json_encode($extra),
                "remain_count" => rand(0, 30),
                "status" => "S",
                "photos" => json_encode($photos),
            );

            MerchandiseModel::create($merchandiseData);
        }
    }
}
