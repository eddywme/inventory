<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $user_slug = str_slug($firstName . " " . $lastName . " " . random_int(1, 1000));
    return [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $faker->unique()->safeEmail,
        'phone_number' => $faker->phoneNumber,
        'role_id' => $faker->numberBetween(1,3),
        'slug' => $user_slug,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});



$factory->define(App\ItemCategory::class, function (Faker\Generator $faker) {


    return [
        'name' => $faker->name,
        'description' => $faker->paragraph,
        'slug' => str_slug($faker->name)
    ];
});

$factory->define(App\ItemCondition::class, function (Faker\Generator $faker) {


    $name = $faker->name;
    return [
        'name' => $name,
        'description' => $faker->paragraph,
        'slug' => str_slug($name)
    ];
});




$factory->define(App\Item::class, function (Faker\Generator $faker) {


    $serial_number = strtoupper(str_random(4)) . "-" . $faker->numberBetween(1000, 2000) . "-" . $faker->numberBetween(1000, 2000);
    $identifier = strtoupper(str_random(4)) . $faker->numberBetween(100, 200) . "-" . $faker->numberBetween(1000, 2000) . "-" . $faker->numberBetween(1000, 2000);
    $name = $faker->name;
    return [
        'name' =>$name,
        'description' => $faker->paragraph,
        'time_span' => $faker->numberBetween(1,200),
        'serial_number' => $serial_number,
        'identifier' => $identifier,
        'slug' => str_slug($name ." ".$identifier),
        'location' => $faker->city,
        'price' => $faker->numberBetween(100,50000),
        'status' => $faker->numberBetween(0,2),
        'model_number' => strtoupper(str_random(6)).$faker->numberBetween(100,200),
        'date_acquired' => $faker->dateTime,
        'lastly_edited_by' => $faker->numberBetween(18,20),
        'recorded_by' => $faker->numberBetween(18,20),
        'owned_by' => $faker->numberBetween(1,20),
        'category_id' => $faker->numberBetween(1,10),
        'condition_id' => $faker->numberBetween(1,4),
    ];
});


$factory->define(App\ItemAccessory::class, function (Faker\Generator $faker) {


    $name = $faker->name;
    return [
        'name' => $name,
        'description' => $faker->paragraph,
        'slug' => str_slug($name." ".$faker->randomNumber(6)),
        'item_id' => $faker->numberBetween(1,50)
    ];
});










