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
                    'name' => 'simple-user',
                    'description' => 'simple-user',
                    'slug' => str_slug('simple-user'),
                ],

                [
                    'name' => 'admin',
                    'description' => 'admin',
                    'slug' => str_slug('admin'),
                ],

                [
                    'name' => 'super-admin',
                    'description' => 'super-admin',
                    'slug' => str_slug('super-admin'),
                ]

            ]

        );
    }
}
