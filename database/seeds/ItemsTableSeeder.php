<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert(
            [
                [
                    'name' =>"Sony Camera 4k",
                    'description' => "Sony Camera 4k",
                    'time_span' => "250",
                    'serial_number' => "SON-CAM-450XDS",
                    'identifier' => "WSX-4520-HJXC",
                    'slug' => str_slug("Sony Camera 4k"." "."SON-CAM-450XDS"),
                    'location' => "New York",
                    'price' => "50000",
                    'model_number' => "DF-220-WSX-4520-HJXC",
                    'date_acquired' => \Carbon\Carbon::now(),
                    'recorded_by' => 1,
                    'owned_by' => 1,
                    'category_id' => 1,
                    'condition_id' =>1,
                ],
                [
                    'name' =>"Acer Projector XDF-J",
                    'description' => "Acer Projector XDF-",
                    'time_span' => "20",
                    'serial_number' => "ACER-PROJ-OP-450XDS",
                    'identifier' => "IOP-WSX-4520-JIT",
                    'slug' => str_slug("Acer Projector XDF-J"." "."PROJ-OP-450XDS"),
                    'location' => "Kampala",
                    'price' => "50000",
                    'model_number' => "VTF-220-WSX-4520-SPK",
                    'date_acquired' => \Carbon\Carbon::now(),
                    'recorded_by' => 1,
                    'owned_by' => 1,
                    'category_id' => 1,
                    'condition_id' =>1,
                ]


            ]

        );
    }
}
