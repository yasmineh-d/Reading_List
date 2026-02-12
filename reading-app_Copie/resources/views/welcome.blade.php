<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Public Side - Consultation</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] antialiased">
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
            <!-- Header : Recherche & Titre -->
            <header class="mb-10">
                <h1 class="text-2xl font-semibold mb-6">Consultation des articles</h1>
                
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Barre de Recherche -->
                    <div class="flex-1">
                        <input type="text" placeholder="Rechercher..." 
                               class="w-full px-4 py-2 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] focus:outline-none focus:ring-2 focus:ring-[#f53003]">
                    </div>
                    
                    <!-- Bouton Filtre (Simple placeholder) -->
                    <div class="flex gap-2">
                        <select class="px-4 py-2 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615]">
                            <option>Toutes les catégories</option>
                            <option>Nouveautés</option>
                            <option>Populaires</option>
                        </select>
                        <button class="bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1c1c1a] px-6 py-2 rounded-lg font-medium hover:opacity-90">
                            Filtrer
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content : Grille de Consultation -->
            <main>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    
                    <!-- Carte d'item (Exemple à boucler) -->
                    @forelse($items ?? range(1, 8) as $item)
                        <div class="bg-white dark:bg-[#161615] rounded-xl overflow-hidden shadow-sm border border-[#e3e3e0] dark:border-[#3E3E3A] transition-transform hover:scale-[1.02]">
                            <div class="aspect-video bg-[#fff2f2] dark:bg-[#1D0002] flex items-center justify-center">
                                 <!-- Placeholder image -->
                                 <span class="text-[#f53003] opacity-20 font-bold text-xl">IMAGE</span>
                            </div>
                            <div class="p-4">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-[#706f6c] dark:text-[#A1A09A]">Catégorie</span>
                                <h3 class="font-medium mt-1 mb-2 text-sm lg:text-base">Titre de l'élément de consultation</h3>
                                <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] line-clamp-2">Courte description du contenu pour la recherche et l'aperçu utilisateur.</p>

                                <div class="mt-4 pt-4 border-t border-[#f5f5f5] dark:border-[#222] flex justify-between items-center">
                                    <span class="font-bold text-[#f53003]">Gratuit</span>
                                    <a href="#" class="text-sm font-medium underline underline-offset-4 decoration-[#f53003]">Voir plus</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center col-span-full py-20 text-[#706f6c]">Aucun résultat trouvé.</p>
                    @endforelse

                </div>
            </main>
        </div>

    </body>
</html>