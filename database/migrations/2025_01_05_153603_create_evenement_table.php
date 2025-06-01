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
        Schema::create('evenement', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('description');
            $table->string('image')->default('default-event.jpg');
            $table->date('date');
            $table->string('heure');
            $table->string('num_rue')->nullable();
            $table->string('allee')->nullable();
            $table->string('ville');
            $table->string('code_postal');
            $table->string('pays')->default('France');
            $table->integer('user_id');
            $table->integer('diffusion_id');
            $table->boolean('annonciateur')->default(0);
            $table->integer('max_participants')->nullable();
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('diffusion_id')->references('id')->on('diffusion')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evenement');
    }
};
