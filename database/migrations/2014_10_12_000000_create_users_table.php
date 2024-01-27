<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\UserTypeEnum;
use App\Enum\UserActiveEnum;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('type',[UserTypeEnum::SUPERADMIN, UserTypeEnum::EMPLOYEE])->default(UserTypeEnum::EMPLOYEE);
            $table->enum('is_active',[UserActiveEnum::ACTIVE, UserActiveEnum::NONACTIVE])->default(UserActiveEnum::ACTIVE);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
