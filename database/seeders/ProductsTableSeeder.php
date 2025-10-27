<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Product::create([
            'product_name' => 'コーラ',
            'price' => 120,
            'stock' => 10,
            'company_id' => 1, // コカコーラ
        ]);

        Product::create([
            'product_name' => '天然水',
            'price' => 100,
            'stock' => 20,
            'company_id' => 2, // サントリー
        ]);

        Product::create([
            'product_name' => '午後の紅茶',
            'price' => 130,
            'stock' => 15,
            'company_id' => 3, // キリン
        ]);
    }
}
