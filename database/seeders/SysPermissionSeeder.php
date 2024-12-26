<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \DB;

class SysPermissionSeeder extends Seeder
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
                'name'          => 'Read',
                'description'   => 'read',
            ],
            [
                'name'          => 'Create',
                'description'   => 'create',
            ],
            [
                'name'          => 'Update',
                'description'   => 'update',
            ],
            [
                'name'          => 'Delete',
                'description'   => 'delete',
            ],
            [
                'name'          => 'Approve',
                'description'   => 'approve',
            ],
            [
                'name'          => 'Export',
                'description'   => 'export',
            ]
        ];
        DB::table('sys_permissions')->insert($records);
    }
}
