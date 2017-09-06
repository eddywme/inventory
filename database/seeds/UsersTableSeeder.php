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
                ]

            ]

        );
    }
}
