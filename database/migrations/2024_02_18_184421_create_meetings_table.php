<?php

use App\Enum\CallStatusEnum;
use App\Enum\CallTypeEnum;
use App\Enum\TaskStatusEnum;
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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Client::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('date');
            $table->integer('next_action')->nullable();
            $table->dateTime('next_action_date')->nullable();
            $table->text('comment')->nullable();
            $table->foreignId('added_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_done')->default(TaskStatusEnum::NOT_DONE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
