<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User_room;

class User_roomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User_room::insert([
            [
                'user_id' => '1',
                'room_id' => '1',
            ],
            [
                'user_id' => '2',
                'room_id' => '1',
            ],
            [
                'user_id' => '3',
                'room_id' => '2',
            ],
            [
                'user_id' => '4',
                'room_id' => '2',
            ],
          ]);
    }
}
