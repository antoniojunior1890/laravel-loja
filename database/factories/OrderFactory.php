<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use phpDocumentor\Reflection\Types\Integer;

$factory->define(\App\Models\Order::class, function (Faker $faker) {
    return [
        'name_client' => $faker->name,
        'status' => rand ( 1 , 3 ),
        'payment_method' => rand ( 1 , 2 ),
        'date' => $faker->date($format = 'Ymd', $max = 'now'),
        'date_refresh_status' => $faker->date($format = 'Ymd', $max = 'now'),
    ];
});

