-- Active: 1763710824626@@127.0.0.1@3306@library_crud
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('books', function (Blueprint $table) {
        $table->id(); // Primary Key (Automatic Index)

        // 1. TITLE (Sabse Zaroori Index)
        // Log kitaab ka naam likh kar search karenge. Index ke bina system slow ho jayega.
        $table->string('title')->index(); 

        // 2. AUTHOR (Ye aapne pehle se lagaya tha, Good!)
        $table->string('author')->index(); 

        // 3. YEAR (Agar filter lagana ho "New Books" ka)
        $table->integer('year')->nullable();

        // 4. CATEGORY (Missing tha - Ye Zaroori hai)
        // Taake aap "Science" ya "History" ki books alag kar sakein.
        $table->foreignId('category_id')->constrained()->onDelete('cascade'); 

        // 5. STATUS (Available / Issued)
        // Admin bar bar check karega ke konsi books Available hain.
        $table->string('status')->default('available')->index();

        // 6. ISBN (Unique Index)
        // Har book ka code alag hota hai, duplicate rokne ke liye.
        $table->string('isbn')->nullable()->unique(); 

        $table->decimal('price', 8, 2)->nullable();
        $table->string('image')->nullable();
        
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
