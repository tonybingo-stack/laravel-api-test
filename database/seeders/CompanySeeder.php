<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $companies = array(
            array('name' => "Company1",'email' => "company1@company.com",'logo' => 'company/company1.jpeg', 'website' => 'https://company_1'),
            array('name' => "Company2",'email' => "company2@company.com",'logo' => 'company/company1.jpeg', 'website' => 'https://company_2'),
            array('name' => "Company3",'email' => "company3@company.com",'logo' => 'company/company1.jpeg', 'website' => 'https://company_3'),
            array('name' => "Company4",'email' => "company4@company.com",'logo' => 'company/company2.jpeg', 'website' => 'https://company_4'),
            array('name' => "Company5",'email' => "company5@company.com",'logo' => 'company/company2.jpeg', 'website' => 'https://company_5'),
            array('name' => "Company6",'email' => "company6@company.com",'logo' => 'company/company2.jpeg', 'website' => 'https://company_6'),
            array('name' => "Company7",'email' => "company7@company.com",'logo' => 'company/company2.jpeg', 'website' => 'https://company_7'),
            array('name' => "Company8",'email' => "company8@company.com",'logo' => 'company/company2.jpeg', 'website' => 'https://company_8'),
            array('name' => "Company9",'email' => "company9@company.com",'logo' => 'company/company2.jpeg', 'website' => 'https://company_9'),
            array('name' => "Company10",'email' => "company10@company.com",'logo' => 'company/company1.jpeg', 'website' => 'https://company_10'),
            array('name' => "Company11",'email' => "company11@company.com",'logo' => 'company/company1.jpeg', 'website' => 'https://company_11'),
            array('name' => "Company12",'email' => "company12@company.com",'logo' => 'company/company1.jpeg', 'website' => 'https://company_12'),
        );

        Company::insert($companies);
    }
}
