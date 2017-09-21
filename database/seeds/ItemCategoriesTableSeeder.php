<?php

use Illuminate\Database\Seeder;

class ItemCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_categories')->insert(
            [
                [
                    'name' => 'Smart-phones',
                    'description' => 'Smart-phones',
                    'slug' => str_slug('smart-phones'),
                ],

                [
                    'name' => 'Tablets',
                    'description' => 'tablets',
                    'slug' => str_slug('tablets'),
                ],

                [
                    'name' => 'Projectors',
                    'description' => 'projectors',
                    'slug' => str_slug('projectors'),
                ],

                [
                    'name' => 'Laptops',
                    'description' => 'Laptops',
                    'slug' => str_slug('laptops'),
                ],

                [
                    'name' => 'Cameras',
                    'description' => 'Cameras',
                    'slug' => str_slug('Cameras'),
                ]

            ]

        );
    }
}
