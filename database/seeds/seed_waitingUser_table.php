<?php

use Illuminate\Database\Seeder;

class seed_waitingUser_table extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Waiting::create([
            'name' => 'ひ',
            'latitude' => '34.663749',
            'longitude' => '135.518526'
        ]);
        App\Waiting::create([
            'name' => 'ひで',
            'latitude' => '34.663622',
            'longitude' => '135.519127'
        ]);
    }
}
