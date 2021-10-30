<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Room;
use App\Models\User_room;
use Auth;


class RoomTest extends TestCase
{
    public function testGetRoom()
    {
        $response = $this->get('get-room', [
            'room_id' => 1,
        ]);
        $response->assertStatus(200);
    }

    public function testGetLoginRooms()
    {
        User_room::factory()->create([
            'user_id' => 1,
            'room_id' => 1,
        ]);
        User_room::factory()->create([
            'user_id' => 2,
            'room_id' => 1,
        ]);
        $response = $this->get('get-login-rooms');
        $response->assertStatus(200);
    }

    public function testCreateRoom()
    {
        Auth::loginUsingId(1);
        $response = $this->post('create-room', [
            'id' => 1,
            'name' => "Room1",
        ]);
        $response->assertStatus(200);
    }

    public function testRemoveRoom()
    {
        $response = $this->delete('remove-room', [
            'id' => 1,
        ]);
        $response->assertStatus(200);
    }
}
