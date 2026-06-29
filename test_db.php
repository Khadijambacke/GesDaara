<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::first();
if ($user) {
    echo "First user attributes:\n";
    echo "Nom (capital): " . $user->Nom . "\n";
    echo "nom (lowercase): " . $user->nom . "\n";
    echo "Prenom (capital): " . $user->Prenom . "\n";
    echo "prenom (lowercase): " . $user->prenom . "\n";
} else {
    echo "No user found.\n";
}
