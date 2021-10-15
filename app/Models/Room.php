<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ["room_name"];

    public function user_rooms()
    {
      return $this->hasMany('User_room');
    }
}
