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
        Role::create([
            'name' => 'Super Admin',
            'guard_name'=>'web'

            ]);
        $x = Employee::create([
            // 'scan_id' => '999',
            'full_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret')
        ]);

        $data = DB::table('model_has_roles')->insert([
            [
                'role_id' => 1,
                'model_type' => 'App\Employee',
                'model_id' => 1
            ]
        ]);
    }
}
