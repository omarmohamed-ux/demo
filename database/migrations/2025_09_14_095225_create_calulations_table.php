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
        Schema::create('calulations', function (Blueprint $table) {
            $table->id();

            $table->decimal('first_number',15,5);

            $table->decimal('second_number',15,5);
            $table->string('operation',1);
            $table->decimal('the_answer',15,5);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calulations');
    }
};
