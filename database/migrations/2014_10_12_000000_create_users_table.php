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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('photo');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->enum('level', ['GENERAL', 'KOOR_KAB_KOTA', 'KOOR_KECAMATAN', 'KOOR_DESA', 'KOOR_TPS']);
            $table->boolean('is_active')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
