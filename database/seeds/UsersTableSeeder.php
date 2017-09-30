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
                ],

                [
                    'first_name' => 'Mark',
                    'last_name' => 'Carneggie',
                    'slug' => str_slug("Mark" . "-" . "Carneggie" . "-" . random_int(1, 10000)),
                    'phone_number' => "00114508520",
                    'email' => "markc@gmail.com",
                    'role_id' => "4",
                    'password' => bcrypt("secret"),
                ],

                [
                    'first_name' => 'Godfreid',
                    'last_name' => 'Maybach',
                    'slug' => str_slug("Godfreid" . "-" . "Maybach" . "-" . random_int(1, 10000)),
                    'phone_number' => "021145085220",
                    'email' => "godm@gmail.com",
                    'role_id' => "2",
                    'password' => bcrypt("secret"),
                ]

            ]

        );
    }
}
