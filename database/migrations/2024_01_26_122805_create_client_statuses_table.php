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
        Schema::create('client_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Client::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status', [ClientStatusEnum::NEW, ClientStatusEnum::CONTACTED, ClientStatusEnum::INTERESTED, ClientStatusEnum::NOTINTERESTED, ClientStatusEnum::CLOSED, ClientStatusEnum::LOST])->default(ClientStatusEnum::NEW);
            $table->text('comment');
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
