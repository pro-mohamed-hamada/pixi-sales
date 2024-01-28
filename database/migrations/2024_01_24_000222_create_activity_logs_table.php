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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->onUpdate('cascade')->nullOnDelete();
            $table->dateTime('start_work_time');
            $table->dateTime('end_work_time')->nullable();
            $table->float('hours')->nullable();
            $table->string('start_work_lat');
            $table->string('start_work_lng');
            $table->string('end_work_lat')->nullable();
            $table->string('end_work_lng')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
