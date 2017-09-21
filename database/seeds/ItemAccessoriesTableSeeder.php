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



            ]

        );
    }
}
