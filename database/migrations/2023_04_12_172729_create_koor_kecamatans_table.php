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
        Schema::create('koor_kecamatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('koor_kota_id');
            $table->string('slug');
            $table->string('name');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('koor_kota_id')->references('id')->on('koor_kota');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koor_kecamatans');
    }
};
