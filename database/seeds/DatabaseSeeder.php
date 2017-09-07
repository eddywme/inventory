<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(ItemCategoriesTableSeeder::class);
        $this->call(ItemConditionsTableSeeder::class);

        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        $this->call(ItemsTableSeeder::class);



    }
}
