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
        Schema::create('cellules', function (Blueprint $table) {
            $table->id();
            $table->integer('numerosection'); 
            $table->string('nomsection'); 
            $table->string('localite'); 
            $table->unsignedBigInteger('communaute_id')->nullable(); 
        
            $table->foreign('communaute_id')->references('id')->on('communautes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cellules');
    }
};
