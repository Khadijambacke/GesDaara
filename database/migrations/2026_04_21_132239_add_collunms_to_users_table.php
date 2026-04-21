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
        Schema::table('users', function (Blueprint $table) {
            $table->string('Prenom')->unique();
            $table->string('telephone')->unique();
            $table->string('adresse');
            $table->string('photo')->nullable(); 
            $table->enum('role', ['admin', 'responsble', 'membre'])->default('membre');
            $table->unsignedBigInteger('communaute_id');
            $table->unsignedBigInteger('cellule_id')->nullable(); 
            $table->foreign('communaute_id')->references('id')->on('communautes');
            $table->foreign('cellule_id')->references('id')->on('cellules');
        



            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
          
        });
    }
};
