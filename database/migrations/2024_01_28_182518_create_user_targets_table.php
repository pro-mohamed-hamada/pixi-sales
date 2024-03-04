<?php

use App\Enum\TargetsEnum;
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
        Schema::create('user_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('target', [TargetsEnum::CALL, TargetsEnum::VISIT, TargetsEnum::MEETING, TargetsEnum::PROPOSAL, TargetsEnum::WHATSAPP_MESSAGE, TargetsEnum::CLIENT]);
            $table->integer('target_value');
            $table->integer('target_done')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_targets');
    }
};
