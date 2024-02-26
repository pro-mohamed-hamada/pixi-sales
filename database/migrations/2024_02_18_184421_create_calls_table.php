<?php

use App\Enum\CallStatusEnum;
use App\Enum\CallTypeEnum;
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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Client::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('type', [CallTypeEnum::INCOMING, CallTypeEnum::OUTGOING])->default(CallTypeEnum::OUTGOING);
            $table->dateTime('date');
            $table->string('comment')->nullable();
            $table->enum('status', [CallStatusEnum::ANSWERED, CallStatusEnum::NOT_ANSWERED, CallStatusEnum::NOT_AVAILABLE, CallStatusEnum::PHONE_CLOSED, CallStatusEnum::ERROR_NUMBER])->default(CallStatusEnum::ANSWERED);
            $table->integer('next_action')->nullable();
            $table->dateTime('next_action_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};
