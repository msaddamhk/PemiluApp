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
        Schema::create('dpt', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('desa_id');
            $table->unsignedBigInteger('tps_id')->nullable();
            $table->string('name');
            $table->string('indentity_number')->unique();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->string('phone_number');
            $table->boolean('is_voters')->default(false);
            $table->timestamps();
            $table->foreign('desa_id')->references('id')->on('koor_desa')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('tps_id')->references('id')->on('koor_tps')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('SET NULL')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpts');
    }
};
