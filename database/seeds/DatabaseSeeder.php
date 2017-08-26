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
        factory(App\ItemCategory::class, 10)->create();
        factory(App\ItemCondition::class, 5)->create();

        $this->call(RolesTableSeeder::class);

        factory(App\User::class, 20)->create();

        factory(App\Item::class, 50)->create();

        factory(App\ItemAccessory::class, 100)->create();


    }
}
