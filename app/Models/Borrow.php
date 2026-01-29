<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $guarded = []; // Sab kuch allow karo

    // Relation: Ek Borrow request ka ek User hota hai
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation: Ek Borrow request ki ek Book hoti hai
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}