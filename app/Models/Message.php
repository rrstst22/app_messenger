<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ["sender_id", "room_id", "message", "sent_at"];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
