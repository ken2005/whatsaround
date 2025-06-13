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
        Schema::create('editer', function (Blueprint $table) {
            $table->foreignId('user_id');
            $table->foreignId('evenement_id');
            $table->timestamps();
        });

        /*
        CREATE TABLE editer(
            id INT,
            Id_Evenement INT,
            PRIMARY KEY(id, Id_Evenement),
            FOREIGN KEY(id) REFERENCES users(id),
            FOREIGN KEY(Id_Evenement) REFERENCES Evenement(Id_Evenement)
            );

        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editer');
    }
};
