<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Models\User;
use Auth;

class LoginTest extends TestCase
{

    public function testGuestLogin()
    {
        $this->post('guest-login', ['id'=>1]);
        $user1 = Auth::id();
        $this->assertEquals($user1, 1);
    }

    public function testCreateUser()
    {
        $count_before = User::count();
        $this->post('create-user', [
            'name' => Str::random(8),
        ]);
        $count_after = User::count();
        $this->assertEquals($count_before+1, $count_after);
    }
}
