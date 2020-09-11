<?php

use App\User;
use App\Ticket;
use App\Category;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {

    // @TODO: user_id must change to asignee_id or agent_id or asigned_to_id

    // User::all()->random()->id
    return [
        "title" => $faker->sentence,
        "message" => $faker->paragraph,
        "priority" => "low",
        "status" => "Open",
        "user_id" => $faker->numberBetween(2, 5),
        "ticket_id" => strtoupper(str_random(15)),
        "category_id" => Category::where('name', 'Uncategorized')->firstOrFail()->id,
        "author_name" => $faker->name,
        "author_email" => $faker->email,
    ];
});
