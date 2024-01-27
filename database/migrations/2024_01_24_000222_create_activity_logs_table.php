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
            $table->dateTime('login_time');
            $table->dateTime('logout_time')->nullable();
            $table->float('hours')->nullable();
            $table->string('login_lat');
            $table->string('login_lng');
            $table->string('logout_lat')->nullable();
            $table->string('logout_lng')->nullable();
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
