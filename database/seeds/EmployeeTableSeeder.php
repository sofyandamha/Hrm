<?php

use App\Employee;
use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'full_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret')
        ]);
    }
}
