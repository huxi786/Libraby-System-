<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();

            // Kis user ne book li?
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Konsi book li?
            $table->foreignId('book_id')->constrained()->onDelete('cascade');

            // Status: pending, approved, returned, rejected
            $table->string('status')->default('pending')->index();

            // Dates
            $table->date('issue_date')->nullable();
            $table->date('return_date')->nullable()->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
