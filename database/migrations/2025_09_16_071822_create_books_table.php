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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name', 15);
            $table->year('publication_year');
            
            
            // تعريف المفتاح الخارجي الذي يربط هذا الجدول بجدول 'book_types'
            $table->unsignedBigInteger('book_type_id')->nullable();
            $table->foreign('book_type_id')->references('id')->on('book_types')->onDelete('set null');//->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
