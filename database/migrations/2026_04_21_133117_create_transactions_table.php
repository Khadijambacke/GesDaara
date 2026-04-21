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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('numero'); 
            $table->string('libelle');
            $table->string('description');
            $table->decimal('montanttr',10, 0);
            $table->enum('methode_transactions', [
                'cash',
                'wave',
                'orange_money',
                'free_money',
                'bank'
            ]);
            $table->enum('typeTransctions', [
                'contribution',
                'don',
                'depenses',
                'transfer',
            ])->default('depenses');
            $table->string('justificatif')->nullable;
            $table->unsignedBigInteger('users_id'); 
            $table->unsignedBigInteger('evenement_id'); 
            $table->timestamps();
            $table->foreign('evenement_id')->references('id')->on('evenements'); 
            $table->foreign('users_id')->references('id')->on('users'); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
