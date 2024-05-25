<?php

use App\Enum\ClientActivityActionEnum;
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
        Schema::create('client_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Client::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->morphs('activity');
            $table->enum('action', [ClientActivityActionEnum::ADDED, ClientActivityActionEnum::UPDATED, ClientActivityActionEnum::DELETED]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_activities');
    }
};
