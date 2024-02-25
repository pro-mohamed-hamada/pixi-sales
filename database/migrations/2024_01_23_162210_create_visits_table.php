<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\ActionTypeEnum;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Client::class)->nullable()->constrained()->onUpdate('cascade')->nullOnDelete();
            $table->enum('action_type', [ActionTypeEnum::CALL, ActionTypeEnum::MEETING, ActionTypeEnum::WHATSAPP, ActionTypeEnum::VISIT]);
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
