<?php

use App\Employee;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Super Admin']); // add role in table role
        Role::create(['name' => 'Manager']); // add role in table role
        Role::create(['name' => 'Head HRD']); // add role in table role
        Role::create(['name' => 'HRD Asistan']); // add role in table role
        Role::create(['name' => 'Supervisor']); // add role in table role
        Role::create(['name' => 'Employee']); // add role in table role
        $x = Employee::create([
            'scan_id' => '999',
            'full_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt(' ')
        ]);
        $y = Employee::where('full_name','Admin')->first();

        $data = DB::table('model_has_roles')->insert([
            [
                'role_id' => 1,
                'model_type' => 'App\Employee',
                'model_id' => $y['id']
            ]
        ]);
    }
}
