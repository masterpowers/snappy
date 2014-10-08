<?php

use Snappy\User;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'email_address' => 'chris@brayniverse.com',
            'password'      => 'Password1',
            'name'          => 'Christopher L Bray'
        ]);

        User::create([
            'email_address' => 'igor@chainy.com',
            'password'      => 'Password2',
            'name'          => 'Igor'
        ]);

        for ($i = 0; $i < 5; $i++)
        {
            $fake = Faker::create();

            User::create([
                'email_address' => $fake->email,
                'password'      => $fake->password,
                'name'          => $fake->name
            ]);
        }
    }
}