<?php

use Illuminate\Database\Seeder;

class ItemConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_conditions')->insert(
            [
                [
                    'name' => 'Good',
                    'description' => 'Good',
                    'slug' => str_slug('Good'),
                ],

                [
                    'name' => 'Not Bad',
                    'description' => 'Not Bad',
                    'slug' => str_slug('Not Bad'),
                ],

                [
                    'name' => 'Bad',
                    'description' => 'bad',
                    'slug' => str_slug('bad'),
                ]

            ]

        );
    }
}
