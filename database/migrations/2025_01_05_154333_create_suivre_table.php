<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suivre', function (Blueprint $table) {
            //$table->id();
            $table->foreignId('follower_id');
            $table->foreignId('followed_id');
            $table->boolean('validee')->default(0); // 1 = validée, 0 = en attente
            //$table->foreign('follower_id')->references('id')->on('users');
            //$table->foreign('followed_id')->references('id')->on('users');
            $table->timestamps();
        });

        DB::unprepared('
                    CREATE TRIGGER auto_validate_follow BEFORE INSERT ON suivre
                    FOR EACH ROW
                    BEGIN
                        IF (SELECT est_prive FROM users WHERE id = NEW.followed_id) = 0 THEN
                            SET NEW.validee = 1;
                        END IF;
                    END
                ');
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suivre');
    }
};
