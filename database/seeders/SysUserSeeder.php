<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \DB;

class SysUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [
                'name'      => 'Fikri Reformasi Gunawan',
                'username'  => 'fikrasdi',
                'password'  => bcrypt('fikri'),
                'role_id'   => 1
            ],
            [
                'name'      => 'Fikri Z',
                'username'  => 'fikrasdasiz',
                'password'  => bcrypt('fikriz'),
                'role_id'   => 3
            ]
        ];
        DB::table('sys_users')->insert($records);
    }
}
