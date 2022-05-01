<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Roles;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Admin::truncate();

        $adminRoles = Roles::where('name','admin')->first();
        $authorRoles = Roles::where('name','author')->first();
        $userRoles = Roles::where('name','user')->first();

        $admin = Admin::create([
            'admin_name'=>'admin',
            'admin_mail'=>'admin@gmail.com',
            'admin_phone'=>'0978671451',
            'admin_password'=>md5('123456')
        ]);

        $author = Admin::create([
            'admin_name'=>'quan',
            'admin_mail'=>'quan@gmail.com',
            'admin_phone'=>'0978671451',
            'admin_password'=>md5('123456')
        ]);

        $user = Admin::create([
            'admin_name'=>'linh',
            'admin_mail'=>'linh@gmail.com',
            'admin_phone'=>'0978671451',
            'admin_password'=>md5('123456')
        ]);

        $admin->roles()->attach($adminRoles);
        $author->roles()->attach($authorRoles);
        $user->roles()->attach($userRoles);

        
    }
}
