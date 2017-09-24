<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemAccessoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_accessories')->insert(
            [
                [
                    'name' =>"Remote Control Acer Projector",
                    'slug' => str_slug("Remote Control Acer Projector"),
                    'item_id' => 2

                ],

                [
                    'name' =>"X-Ray Lens for Acer Projector",
                    'slug' => str_slug("X-Ray Lens for Acer Projector"),
                    'item_id' => 2

                ],

                [
                    'name' =>"Flash",
                    'slug' => str_slug("Flash Lens for SONY 4K"),
                    'item_id' => 1

                ],

                [
                    'name' =>"Chest Belt",
                    'slug' => str_slug("X-Ray Lens for SONY 4K"),
                    'item_id' => 1

                ],

                [
                    'name' =>"Generic Lens",
                    'slug' => str_slug("Generic Lens for any camera"),
                    'item_id' => null

                ],

                [
                    'name' =>"Micro USB charger",
                    'slug' => str_slug("Micro USB charger any device"),
                    'item_id' => null

                ],



            ]

        );
    }
}
