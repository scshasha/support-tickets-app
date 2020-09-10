<?php
use App\Ticket;
use App\Category;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        "title" => $faker->sentence,
        "message" => $faker->paragraph,
        "priority" => "low",
        "status" => "Open",
        "ticket_id" => strtoupper(str_random(15)),
        "category_id" => Category::where('name', 'Uncategorized')->firstOrFail()->id,
        "author_name" => $faker->name,
        "author_email" => $faker->email,
    ];
});
