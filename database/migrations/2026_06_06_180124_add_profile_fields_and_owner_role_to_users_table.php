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
            $table->string('profession')->nullable();
            $table->string('etablissement_scolaire')->nullable();
            $table->string('niveau_etudes')->nullable();
            $table->string('parent_tuteur_nom')->nullable();
            $table->string('parent_tuteur_telephone')->nullable();
            $table->date('date_naissance')->nullable();
            $table->boolean('cgu_accepted')->default(false);
            $table->timestamp('cgu_accepted_at')->nullable();
            $table->string('invitation_token')->nullable()->unique();
            
            $table->string('role')->default('membre')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profession',
                'etablissement_scolaire',
                'niveau_etudes',
                'parent_tuteur_nom',
                'parent_tuteur_telephone',
                'date_naissance',
                'cgu_accepted',
                'cgu_accepted_at',
                'invitation_token'
            ]);
        });
    }
};
