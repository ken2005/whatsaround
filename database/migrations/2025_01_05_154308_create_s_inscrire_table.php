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
        Schema::create('s_inscrire', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('evenement_id');
            //$table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('evenement_id')->references('id')->on('evenement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_inscrire');
    }
};
