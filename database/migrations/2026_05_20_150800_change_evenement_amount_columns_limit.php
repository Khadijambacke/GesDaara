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
        Schema::table('evenements', function (Blueprint $table) {
            $table->decimal('objectifmontant', 15, 2)->change();
            $table->decimal('cotisations', 15, 2)->change();
            $table->decimal('montantotalparticipe', 15, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evenements', function (Blueprint $table) {
            $table->decimal('objectifmontant', 8, 2)->change();
            $table->decimal('cotisations', 8, 2)->change();
            $table->decimal('montantotalparticipe', 8, 2)->change();
        });
    }
};
