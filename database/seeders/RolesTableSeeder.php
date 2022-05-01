<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Roles;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //loại bỏ dữ liệu cũ trước khi thêm dữ liệu mới
        Roles::truncate();

        Roles::create(['name'=>'admin']);
        Roles::create(['name'=>'author']);
        Roles::create(['name'=>'user']);
    }
}
