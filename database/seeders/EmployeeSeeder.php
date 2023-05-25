<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $employees = array(
            array('first_name' => "Prad",'last_name' => "Lashodoski",'company_id' => 1, 'email' => 'pradlasho@gmail.com', 'phone' => '12313434'),
            array('first_name' => "Prad",'last_name' => "Lashodoski",'company_id' => 2, 'email' => 'pradlasho@gmail.com', 'phone' => '12313434'),
            array('first_name' => "Prad",'last_name' => "Lashodoski",'company_id' => 3, 'email' => 'pradlasho@gmail.com', 'phone' => '12313434'),
            array('first_name' => "Prad",'last_name' => "Lashodoski",'company_id' => 1, 'email' => 'pradlasho@gmail.com', 'phone' => '12313434'),
            array('first_name' => "Prad",'last_name' => "Lashodoski",'company_id' => 1, 'email' => 'pradlasho@gmail.com', 'phone' => '12313434'),
            array('first_name' => "Prad",'last_name' => "Lashodoski",'company_id' => 5, 'email' => 'pradlasho@gmail.com', 'phone' => '12313434'),
            array('first_name' => "Prad",'last_name' => "Lashodoski",'company_id' => 1, 'email' => 'pradlasho@gmail.com', 'phone' => '12313434'),
            array('first_name' => "Prad",'last_name' => "Lashodoski",'company_id' => 1, 'email' => 'pradlasho@gmail.com', 'phone' => '12313434'),
            array('first_name' => "Prad",'last_name' => "Lashodoski",'company_id' => 7, 'email' => 'pradlasho@gmail.com', 'phone' => '12313434'),
            array('first_name' => "Prad",'last_name' => "Lashodoski",'company_id' => 1, 'email' => 'pradlasho@gmail.com', 'phone' => '12313434'),
            array('first_name' => "Prad",'last_name' => "Lashodoski",'company_id' => 1, 'email' => 'pradlasho@gmail.com', 'phone' => '12313434'),
            array('first_name' => "Prad",'last_name' => "Lashodoski",'company_id' => 1, 'email' => 'pradlasho@gmail.com', 'phone' => '12313434'),
            array('first_name' => "Prad",'last_name' => "Lashodoski",'company_id' => 1, 'email' => 'pradlasho@gmail.com', 'phone' => '12313434'),
        );

        Employee::insert($employees);
    }
}
