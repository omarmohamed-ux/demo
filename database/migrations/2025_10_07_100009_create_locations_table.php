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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            // اسم المكان مثلاً الجامعه او الشغل"
            $table->string('name');
            //لتخزين احداثيات خطوط الطول
            $table->decimal('latitude', 10, 7)->nullable();
            //لتخزين احداثيات خطوط العرض
            $table->decimal('longitude', 10, 7)->nullable();
            //المسافه المسموح بها
            $table->integer('allowed_radius')->default(100);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
