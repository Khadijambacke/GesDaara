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
        Schema::create('comptes', function (Blueprint $table) {
            $table->id();
            $table->string('numerocompte')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('montant_total', 15, 2)->default(0.00);
            $table->decimal('montantotalsas', 15, 2)->default(0.00);
            $table->timestamps();
        });

        // Initialiser les comptes pour les utilisateurs existants
        $users = Illuminate\Support\Facades\DB::table('users')->get();
        foreach ($users as $user) {
            Illuminate\Support\Facades\DB::table('comptes')->insert([
                'numerocompte' => 'CPTE-' . strtoupper(bin2hex(random_bytes(4))),
                'user_id' => $user->id,
                'montant_total' => 0.00,
                'montantotalsas' => 0.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comptes');
    }
};
