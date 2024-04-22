<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\ActionTypeEnum;
use App\Enum\TaskStatusEnum;

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
            $table->date('date');
            $table->foreignIdFor(\App\Models\City::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('next_action')->nullable();
            $table->dateTime('next_action_date')->nullable();
            $table->text('comment')->nullable();
            $table->foreignId('added_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_done')->default(TaskStatusEnum::NOT_DONE);
            $table->string('person_position')->nullable();
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
