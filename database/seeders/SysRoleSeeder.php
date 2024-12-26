<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \DB;

class SysRoleSeeder extends Seeder
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
                'name'      => 'System',
                'branch_id' => 0
            ],
            [
                'name'      => 'Pusat',
                'branch_id' => 0
            ],
            [
                'name'      => 'User Supervisor',
                'branch_id' => 15
            ],
            [
                'name'      => 'User Maker',
                'branch_id' => 13
            ],
            [
                'name'      => 'Fikri Role Baru',
                'branch_id' => 32
            ]
        ];
        DB::table('sys_roles')->insert($records);
    }
}
