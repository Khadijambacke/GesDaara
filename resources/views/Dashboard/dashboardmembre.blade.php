<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white p-6">

            <h1 class="text-3xl font-bold mb-10">
                Gestion Daara
            </h1>

            <nav class="space-y-4">

                <a href="#" class="block p-3 rounded-lg hover:bg-gray-800 transition">
                    Dashboard
                </a>

                <a href="#" class="block p-3 rounded-lg hover:bg-gray-800 transition">
                    Élèves
                </a>

                <a href="#" class="block p-3 rounded-lg hover:bg-gray-800 transition">
                    Professeurs
                </a>

                <a href="#" class="block p-3 rounded-lg hover:bg-gray-800 transition">
                    Paiements
                </a>

                <a href="#" class="block p-3 rounded-lg hover:bg-gray-800 transition">
                    Rapports
                </a>

            </nav>

        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-10">

                <div>
                    <h2 class="text-4xl font-bold text-gray-800">
                        Tableau de bord
                    </h2>

                    <p class="text-gray-500 mt-2">
                        Bienvenue dans votre espace administrateur.
                    </p>
                </div>

                <div class="bg-white px-5 py-3 rounded-xl shadow">
                    <p class="text-gray-500 text-sm">Connecté en tant que</p>
                    <p class="font-bold text-gray-800">
                        Admin
                    </p>
                </div>

            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-gray-500">Élèves</p>
                    <h3 class="text-4xl font-bold mt-3">120</h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-gray-500">Professeurs</p>
                    <h3 class="text-4xl font-bold mt-3">12</h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-gray-500">Paiements</p>
                    <h3 class="text-4xl font-bold mt-3">45</h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-gray-500">Cours</p>
                    <h3 class="text-4xl font-bold mt-3">8</h3>
                </div>

            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl shadow p-6">

                <div class="flex justify-between items-center mb-6">

                    <h3 class="text-2xl font-bold text-gray-800">
                        Derniers élèves
                    </h3>

                    <button class="bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-black transition">
                        Ajouter
                    </button>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>
                            <tr class="border-b">

                                <th class="text-left py-4">Nom</th>
                                <th class="text-left py-4">Classe</th>
                                <th class="text-left py-4">Téléphone</th>
                                <th class="text-left py-4">Statut</th>

                            </tr>
                        </thead>

                        <tbody>

                            <tr class="border-b hover:bg-gray-50">

                                <td class="py-4">Mamadou Diallo</td>
                                <td>CM2</td>
                                <td>77 000 00 00</td>

                                <td>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                        Actif
                                    </span>
                                </td>

                            </tr>

                            <tr class="border-b hover:bg-gray-50">

                                <td class="py-4">Aminata Ndiaye</td>
                                <td>6e</td>
                                <td>78 000 00 00</td>

                                <td>
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                        En attente
                                    </span>
                                </td>

                            </tr>

                            <tr class="hover:bg-gray-50">

                                <td class="py-4">Ibrahima Fall</td>
                                <td>5e</td>
                                <td>76 000 00 00</td>

                                <td>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                        Actif
                                    </span>
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </main>

    </div>

</body>
</html>
