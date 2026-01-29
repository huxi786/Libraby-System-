<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name', 
        'email', 
        'subject', 
        'message', 
        'sender',
        'reply' // 👈 Ye bhi add kiya hai taake Admin reply save ho sake
    ];

    // ✅ Relationship: Ye message kis user ka hai?
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}