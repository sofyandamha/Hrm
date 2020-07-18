<?php

use App\Role;
use App\User;
use App\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Super Admin',
            'guard_name'=>'web'

            ]); // add role in table role
        // Role::create(['name' => 'Manager']); // add role in table role
        // Role::create(['name' => 'Head HRD']); // add role in table role
        // Role::create(['name' => 'HRD Asistan']); // add role in table role
        // Role::create(['name' => 'Supervisor']); // add role in table role
        // Role::create(['name' => 'Employee']); // add role in table role
        $x = User::create([
            // 'scan_id' => '999',
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('1234')
        ]);
        $y = Employee::where('full_name','Admin')->first();

        $data = DB::table('model_has_roles')->insert([
            [
                'role_id' => 1,
                'model_type' => 'App\User',
                'model_id' => 1
            ]
        ]);
    }
}
