<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    // Kin columns ko fill karne ki ijazat hai
    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'issue_date',
        'return_date'
    ];

    // Relationship: Issue kis USER ka hai?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Issue kis BOOK ka hai?
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}