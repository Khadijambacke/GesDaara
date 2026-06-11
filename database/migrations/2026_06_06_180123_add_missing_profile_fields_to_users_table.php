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
            if (!Schema::hasColumn('users', 'matricule')) {
                $table->string('matricule')->nullable()->unique();
            }
            if (!Schema::hasColumn('users', 'numero_identite')) {
                $table->string('numero_identite')->nullable();
            }
            if (!Schema::hasColumn('users', 'nom_pere')) {
                $table->string('nom_pere')->nullable();
            }
            if (!Schema::hasColumn('users', 'nom_mere')) {
                $table->string('nom_mere')->nullable();
            }
            if (!Schema::hasColumn('users', 'situation_matrimoniale')) {
                $table->string('situation_matrimoniale')->nullable();
            }
            if (!Schema::hasColumn('users', 'est_enfant')) {
                $table->boolean('est_enfant')->default(false);
            }
            if (!Schema::hasColumn('users', 'type_membre')) {
                $table->enum('type_membre', ['adulte', 'adolescent', 'enfant'])->default('adulte');
            }
            if (!Schema::hasColumn('users', 'genre')) {
                $table->enum('genre', ['homme', 'femme'])->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('users', 'matricule')) $columns[] = 'matricule';
            if (Schema::hasColumn('users', 'numero_identite')) $columns[] = 'numero_identite';
            if (Schema::hasColumn('users', 'nom_pere')) $columns[] = 'nom_pere';
            if (Schema::hasColumn('users', 'nom_mere')) $columns[] = 'nom_mere';
            if (Schema::hasColumn('users', 'situation_matrimoniale')) $columns[] = 'situation_matrimoniale';
            if (Schema::hasColumn('users', 'est_enfant')) $columns[] = 'est_enfant';
            if (Schema::hasColumn('users', 'type_membre')) $columns[] = 'type_membre';
            if (Schema::hasColumn('users', 'genre')) $columns[] = 'genre';

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
