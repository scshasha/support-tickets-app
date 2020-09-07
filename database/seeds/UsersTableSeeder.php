<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::truncate();

        User::create([
            'name' => 'tony',
            'email' => 'admin@myapp.com',
            'is_admin' => 1,
            'password' => 'password',
        ]);
        User::create([
            'name' => 'jacky',
            'email' => 'user2@app.com',
            'is_admin' => 0,
            'password' => 'password',
        ]);
        User::create([
            'name' => 'lorraine',
            'email' => 'user1@app.com',
            'is_admin' => 0,
            'password' => 'password',
        ]);

        // @TODO: Integrate with facker and e-mail functionality
    }
}
