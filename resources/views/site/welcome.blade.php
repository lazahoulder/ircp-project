<x-layouts.site.app :title="__('IRCP')">
    @include('partials.site-partials.breadcrumb', ['breadcrumbs' => []])

    <section class="relative bg-gradient-to-br from-gray-950 via-gray-600 to-gray-950 text-white py-20 px-6 md:px-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            <!-- Image à gauche -->
            <div class="relative w-full h-72 md:h-[460px] animate-fade-in">
                <img src="{{ asset('images/certificate-bg.png') }}" alt="Certificat IRCP"
                     class="w-full h-full object-contain md:object-cover rounded-xl shadow-xl ring-1 ring-gray-700"/>
            </div>

            <!-- Texte à droite -->
            <div class="text-center md:text-left space-y-6 animate-fade-in delay-150">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white leading-tight">
                    🎓 Vérifiez un certificat.<br>
                    <span>Recherchez un(e) certifié(e).</span><br>
                    <span class="text-blue-400">Soyez sûr de l’authenticité.</span>
                </h1>

                <p class="text-lg text-gray-300 max-w-xl">
                    La plateforme officielle de l’IRCP pour garantir la crédibilité des certifications
                    professionnelles.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start pt-2">
                    <a href="{{ route('search') }}"
                       class="inline-flex items-center justify-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-lg font-semibold shadow transition">
                        🔍 Rechercher un certificat
                    </a>
                    <a href="{{ route('about') }}"
                       class="inline-flex items-center justify-center px-6 py-3 border-2 border-blue-500 text-blue-400 hover:bg-gray-700 rounded-lg text-lg font-semibold transition">
                        📄 À propos de l’IRCP
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Titre + Texte -->
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-white">🔍 Vérification simplifiée</h2>
            <p class="mt-2 text-white text-lg">
                Recherchez ou scannez, c’est aussi simple que ça.<br>
                <span class="text-sm text-white">
                Utilisez le moteur de recherche ou scannez le QR code présent sur un certificat pour vérifier instantanément sa validité.
              </span>
            </p>
        </div>

        <!-- Stepper -->
        <div class="flex flex-col md:flex-row items-center justify-center md:space-x-6 space-y-6 md:space-y-0">
            <!-- Étape 1 -->
            <div class="flex items-start space-x-3">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-white text-gray-950 hover:bg-green-700/100 hover:text-white">
                    <!-- Icône : utilisateur -->
                    <flux:icon.user></flux:icon.user>
                </div>
                <div>
                    <div class="text-blue-200 font-semibold">Saisir les informations</div>
                    <div class="text-sm text-gray-500">Entrez le nom ou le numéro du certificat</div>
                </div>
            </div>

            <!-- Ligne -->
            <div class="w-8 h-1 bg-gray-300 hidden md:block"></div>

            <!-- Étape 2 -->
            <div class="flex items-start space-x-3">
                <div
                    class="flex items-center justify-center w-12 h-12 rounded-full bg-white text-gray-950 hover:bg-green-700/100 hover:text-white">
                    <!-- Icône : loupe -->
                    <flux:icon.search></flux:icon.search>
                </div>
                <div>
                    <div class="text-blue-200 font-semibold">Lancer la recherche</div>
                    <div class="text-sm text-gray-500">Cliquez sur le bouton pour vérifier la validité</div>
                </div>
            </div>

            <!-- Ligne -->
            <div class="w-8 h-1 bg-gray-300 hidden md:block"></div>

            <!-- Étape 3 -->
            <div class="flex items-start space-x-3">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-white text-gray-950 hover:bg-green-700/100 hover:text-white">
                    <!-- Icône : check -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <div class="text-blue-200 font-semibold">Consulter les résultats</div>
                    <div class="text-sm text-gray-500">Affichage des résultats officiels du certificat</div>
                </div>
            </div>
        </div>
        <div class="mt-10 border-t border-gray-700"></div>
    </div>

    <!-- Centres Accrédités Section -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <livewire:client-slider />
    </div>

    <section class="text-white py-16 px-6 md:px-12">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">🧾 Pourquoi cette plateforme ?</h2>
            <p class="text-gray-300 text-lg mb-10 max-w-3xl mx-auto">
                Chaque certificat IRCP est unique, sécurisé et traçable.<br/>
                Cette plateforme est votre source fiable pour les vérifications.
            </p>

            <div class="grid md:grid-cols-3 gap-6 text-left">
                <div class="bg-gray-900 p-6 rounded-xl border border-gray-800">
                    <h3 class="text-blue-400 font-semibold mb-2">🔒 Lutter contre la falsification</h3>
                    <p class="text-gray-400 text-sm">Protéger l'intégrité des certifications professionnelles.</p>
                </div>
                <div class="bg-gray-900 p-6 rounded-xl border border-gray-800">
                    <h3 class="text-blue-400 font-semibold mb-2">🧑‍💼 Vérification pour les recruteurs</h3>
                    <p class="text-gray-400 text-sm">Un accès rapide à la vérification des qualifications.</p>
                </div>
                <div class="bg-gray-900 p-6 rounded-xl border border-gray-800">
                    <h3 class="text-blue-400 font-semibold mb-2">🌟 Valorisation des certifiés</h3>
                    <p class="text-gray-400 text-sm">Renforcer la reconnaissance des professionnels IRCP.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="text-white py-16 px-6 md:px-12">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">🏢 IRCP – Un acteur clé de la certification
                professionnelle</h2>
            <p class="text-gray-300 text-lg mb-8 max-w-3xl mx-auto">
                Depuis sa création, l’IRCP œuvre pour le développement des compétences à travers des programmes de
                formation, d’évaluation et de certification reconnus.<br/>
                Notre mission est de bâtir un écosystème de confiance et de reconnaissance des compétences à Madagascar.
            </p>
            <a href="{{ route('about') }}"
               class="inline-block mt-4 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-lg font-medium transition">
                En savoir plus sur l’IRCP
            </a>
        </div>
    </section>
</x-layouts.site.app>
