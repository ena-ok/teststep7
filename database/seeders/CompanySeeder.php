<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    
    public function run()
    {
        Company::create([
            'name' => 'テスト企業A',
            
        ]);

        Company::create([
            'name' => 'テスト企業B',
            
        ]);
    }
}

