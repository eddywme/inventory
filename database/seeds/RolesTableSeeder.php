<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            [
                [
                    'name' => 'registered-user',
                    'description' => 'registered-user',
                    'slug' => str_slug('registered-user'),
                ],

                [
                    'name' => 'account-user',
                    'description' => 'account-user',
                    'slug' => str_slug('account-user'),
                ],

                [
                    'name' => 'manager-user',
                    'description' => 'manager-user',
                    'slug' => str_slug('manager-user'),
                ],

                [
                    'name' => 'sys-admin-user',
                    'description' => 'sys-admin-user',
                    'slug' => str_slug('sys-admin-user'),
                ]


            ]

        );
    }
}
