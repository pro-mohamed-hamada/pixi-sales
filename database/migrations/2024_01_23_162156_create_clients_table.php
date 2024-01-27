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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('industry');
            $table->string('company_name');
            $table->foreignIdFor(\App\Models\City::class)->nullable()->constrained()->onUpdate('cascade')->nullOnDelete();
            $table->string('other_person_name');
            $table->string('other_person_phone');
            $table->string('other_person_position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
