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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('content_id'); // FK to contents
            $table->enum('format', ['physical', 'digital']); // Media format
            $table->string('file_path')->nullable(); // If digital, the file path
            $table->string('isbn')->nullable(); // If applicable
            $table->timestamps();
        
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
