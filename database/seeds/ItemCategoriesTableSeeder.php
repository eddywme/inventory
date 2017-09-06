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
                ]

            ]

        );
    }
}
