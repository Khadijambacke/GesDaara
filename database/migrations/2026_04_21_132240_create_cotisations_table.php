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
        Schema::create('cotisations', function (Blueprint $table) {
            $table->id();
            $table->string('numerocontributions'); 
            $table->decimal('montantcotise', 10, 0);
            $table->enum('methodepayement', [
                'cash',
                'wave',
                'orange_money',
                'free_money',
                'bank' 
            ])->nullable();
            $table->date('datecotisations');
            $table->unsignedBigInteger('evenement_id'); 
            $table->unsignedBigInteger('membre_id'); 
            $table->timestamps();
            $table->foreign('evenement_id')->references('id')->on('evenements'); 
            $table->foreign('membre_id')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotisations');
    }
};
