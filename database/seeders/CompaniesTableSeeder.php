// database/seeders/CompanySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run()
    {
        Company::create([
            'company_name' => 'テスト企業A',
            'street_address' => '東京都新宿区1-1-1',
            'representative_name' => '山田太郎',
        ]);

        Company::create([
            'company_name' => 'テスト企業B',
            'street_address' => '大阪市中央区2-2-2',
            'representative_name' => '佐藤花子',
        ]);
    }
}

