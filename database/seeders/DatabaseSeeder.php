<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CompanySeeder;


class DatabaseSeeder extends Seeder

{
      public function run():void
    {
        $this->call([
            CompanySeeder::class,
            ProductsTableSeeder::class,
        ]);
    }
}
