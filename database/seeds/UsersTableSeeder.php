<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'first_name' => 'Eddy',
                    'last_name' => 'Mugisho',
                    'slug' => str_slug("Eddy" . "-" . "Mugisho" . "-" . random_int(1, 10000)),
                    'phone_number' => "00245085220",
                    'email' => "edd@gmail.com",
                    'role_id' => "3",
                    'password' => bcrypt("secret"),
                ],

                [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'slug' => str_slug("John" . "-" . "Doe" . "-" . random_int(1, 10000)),
                    'phone_number' => "001145085220",
                    'email' => "jondoes@gmail.com",
                    'role_id' => "1",
                    'password' => bcrypt("secret"),
                ]

            ]

        );
    }
}
