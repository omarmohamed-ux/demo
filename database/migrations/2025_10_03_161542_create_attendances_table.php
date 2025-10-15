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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            // ربط سجل الحضور بالمستخدم
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // وقت تسجيل الدخول
            $table->timestamp('check_in')->nullable();

            // وقت تسجيل الخروج
            $table->timestamp('check_out')->nullable();

            // المدة بين تسجيل الدخول والخروج (بالدقائق)
            $table->integer('duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
