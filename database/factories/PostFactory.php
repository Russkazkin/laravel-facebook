<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $image = rand(0, 1);
    return [
        'body' => $faker->sentence,
        'image' => $image ? 'https://picsum.photos/seed/' . rand(1, 1000) . '/1024/800' : null,
    ];
});
