<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            
            // ✅ 1. User ID (Yehi Error tha, ab add kar diya hai)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('name');
            $table->string('email');
            $table->string('subject')->nullable();
            $table->text('message');
            
            // ✅ 2. Sender & Reply (Extra columns jo zaroori hain)
            $table->string('sender')->default('user'); // Pata chale kisne bheja
            $table->text('reply')->nullable();         // Admin ka jawab
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};