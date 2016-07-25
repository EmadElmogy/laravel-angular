<?php

$factory->define(App\Advisor::class, function (Faker\Generator $faker) {
    return [
        'door_id' => factory(App\Door::class)->create()->id,
        'name' => $faker->name,
        'phone' => $faker->numberBetween(1000, 10000000),
        'username' => $faker->userName,
        'password' => 12345,
        'day_off' => $faker->numberBetween(1, 6),
        'title' => $faker->numberBetween(1, 3),
        'api_token' => str_random(40),
    ];
});


$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'brand' => $faker->numberBetween(1, 2),
    ];
});

$factory->define(App\Complain::class, function (Faker\Generator $faker) {
    return [
        'door_id' => factory(App\Door::class)->create()->id,
        'advisor_id' => factory(App\Advisor::class)->create()->id,
        'comment' => $faker->paragraph(),
        'date' => $faker->dateTimeBetween('2016-07-07', '2016-07-30'),
    ];
});

$factory->define(App\Door::class, function (Faker\Generator $faker) {
    return [
        'site_id' => factory(App\Site::class)->create()->id,
        'name' => $faker->company,
    ];
});

$factory->define(App\Site::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'image' => 'image.jpg',
    ];
});

$factory->define(App\Variation::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'barcode' => $faker->postcode,
    ];
});

$factory->define(App\Report::class, function (Faker\Generator $faker) {
    return [
        'door_id' => factory(App\Door::class)->create()->id,
        'advisor_id' => factory(App\Advisor::class)->create()->id,
        'date' => $faker->dateTimeBetween('2016-07-07', '2016-07-30'),
    ];
});

$factory->define(App\Wiki::class, function (Faker\Generator $faker) {
    return [
        'type' => 1,
        'title' => $faker->words(3, true),
        'link' => 'https://www.youtube.com/watch?v=708mjaHTwKc',
    ];
});