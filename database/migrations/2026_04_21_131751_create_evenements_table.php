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
        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->string('numeroevent'); 
            $table->decimal('objectifmontant',8, 2);
            $table->decimal('cotisations',8, 2);
            $table->decimal('montantotalparticipe',8, 2);
            $table->date('datedebut');
            $table->date('datecloture');
            $table->enum('statut', ['En_cours ', 'planifie', 'termine'])->default('planifie'); 
            $table->unsignedBigInteger('communaute_id')->nullable(); 
            $table->timestamps();
            $table->foreign('communaute_id')->references('id')->on('communautes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evenements');
    }
};
