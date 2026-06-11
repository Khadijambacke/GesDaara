<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('evenements', function (Blueprint $table) {
            $table->unsignedBigInteger('cellule_id')->nullable()->after('communaute_id');
            $table->foreign('cellule_id')->references('id')->on('cellules')->onDelete('cascade');
        });
    }

  
    public function down(): void
    {
        Schema::table('evenements', function (Blueprint $table) {
            $table->dropForeign(['cellule_id']);
            $table->dropColumn('cellule_id');
        });
    }
};
