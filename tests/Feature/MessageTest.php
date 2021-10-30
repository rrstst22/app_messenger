<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User_room;
use App\Models\Message;
use App\Models\User;
use App\Models\Room;
use Auth;


class MessageTest extends TestCase
{

    public function setUp() :void
    {
        parent::setUp();    
        Auth::loginUsingId(1);
    }
    
    public function testShow()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testGetMessages()
    {
        $response = $this->get('get-messages',[
            'room_id' => 1,
        ]);
        $response->assertStatus(200);
    }

    public function testSendMessage()
    {
        $response = $this->post('send-message',[
            'room_id' => 1,
            'message' => "Test",
        ]); 
        $response->assertStatus(200);
    }
}