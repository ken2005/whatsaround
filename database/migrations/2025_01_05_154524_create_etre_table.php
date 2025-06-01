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
        Schema::create('etre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evenement_id');
            $table->foreignId('categorie_id');
            //$table->foreign('evenement_id')->references('id')->on('evenement');
            //$table->foreign('categorie_id')->references('id')->on('categorie');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etre');
    }
};
