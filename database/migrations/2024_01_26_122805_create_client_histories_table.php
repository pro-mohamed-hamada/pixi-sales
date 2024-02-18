<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\ClientStatusEnum;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Client::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status', [ClientStatusEnum::NEW, ClientStatusEnum::CONTACTED_INCOMING, ClientStatusEnum::CONTACTED_OUTGOING, ClientStatusEnum::INTERESTED, ClientStatusEnum::NOT_INTERESTED, ClientStatusEnum::PROPOSAL, ClientStatusEnum::MEETING, ClientStatusEnum::CLOSED, ClientStatusEnum::LOST])->default(ClientStatusEnum::NEW);
            $table->foreignIdFor(\App\Models\Reason::class)->nullable()->constrained()->onUpdate('cascade')->nullOnDelete();
            $table->text('comment')->nullable();
            $table->dateTime('date_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_statuses');
    }
};
