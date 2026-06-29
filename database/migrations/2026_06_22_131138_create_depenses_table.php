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
        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->decimal('montant', 12, 2);
            $table->date('date_depense');
            $table->unsignedBigInteger('evenement_id')->nullable();
            $table->unsignedBigInteger('communaute_id');
            $table->timestamps();

            $table->foreign('evenement_id')->references('id')->on('evenements')->onDelete('set null');
            $table->foreign('communaute_id')->references('id')->on('communautes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depenses');
    }
};
