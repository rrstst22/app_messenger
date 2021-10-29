<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Message;
use App\Models\User;
use App\Models\Room;

class MessageTest extends TestCase
{
    public function setUp() :void
    {
        parent::setUp();    
        User::factory()->count(50)->create();
        Room::factory()->count(50)->create();
        Message::factory()->count(50)->create();
    }

    public function testShow()
    {
        $response = $this->get('/');
        $response->assertStatus(302);
    }

    public function testGetMessages()
    {
        $response = $this->get('get-messages',[
            'room_id' => 1,
        ]);
        $this->assertNotNull($response);
    }
}
