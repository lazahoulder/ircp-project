<footer class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
    <div class="py-6 border-t border-gray-200 dark:border-neutral-700">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

            <!-- Logo & Description -->
            <div>
                <h2 class="text-xl font-bold text-white">IRCP Madagascar</h2>
                <p class="mt-4 text-sm text-gray-400">
                    Institut de Reconnaissance des Compétences Professionnelles. Un acteur clé de la certification à Madagascar.
                </p>
            </div>

            <!-- Navigation -->
            <div>
                <h3 class="text-white font-semibold mb-4">Navigation</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('search') }}" class="hover:text-white">🔍 Rechercher un certificat</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white">🏛 À propos de l'IRCP</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white">📨 Contact</a></li>
                </ul>
            </div>

            <!-- Légal - Commenté car pas encore de contenu
            <div>
                <h3 class="text-white font-semibold mb-4">Informations légales</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white">Mentions légales</a></li>
                    <li><a href="#" class="hover:text-white">Politique de confidentialité</a></li>
                    <li><a href="#" class="hover:text-white">Conditions d’utilisation</a></li>
                </ul>
            </div>
            -->

            <!-- Réseaux sociaux -->
            <div>
                <h3 class="text-white font-semibold mb-4">Suivez-nous</h3>
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-white" aria-label="Facebook">
                        <!-- Icône Facebook -->
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12a10 10 0 10-11.5 9.9v-7h-2v-3h2v-2.3c0-2 1.2-3.1 3-3.1.9 0 1.8.1 1.8.1v2h-1c-1 0-1.3.6-1.3 1.2V12h2.3l-.4 3h-1.9v7A10 10 0 0022 12z"/>
                        </svg>
                    </a>
                    <a href="#" class="hover:text-white" aria-label="X">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.633 7.997c.013.179.013.359.013.538 0 5.486-4.176 11.816-11.816 11.816-2.35 0-4.537-.69-6.373-1.867.33.038.66.051.99.051 1.946 0 3.733-.66 5.161-1.77a4.177 4.177 0 01-3.896-2.89c.26.038.52.064.793.064.384 0 .768-.051 1.127-.141a4.171 4.171 0 01-3.34-4.09v-.051c.559.312 1.2.499 1.886.525a4.166 4.166 0 01-1.857-3.477c0-.768.205-1.484.56-2.102a11.816 11.816 0 008.576 4.354 4.72 4.72 0 01-.102-.956 4.166 4.166 0 017.213-2.844 8.2 8.2 0 002.637-1.004 4.143 4.143 0 01-1.834 2.298 8.334 8.334 0 002.39-.651 8.949 8.949 0 01-2.083 2.16z"/>
                        </svg>
                    </a>
                    <a href="#" class="hover:text-white" aria-label="LinkedIn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6.94 21H3V8h3.94v13zM4.97 6.44C3.88 6.44 3 5.56 3 4.47S3.88 2.5 4.97 2.5 6.94 3.38 6.94 4.47 6.06 6.44 4.97 6.44zM21 21h-3.94v-6.53c0-1.56-.56-2.63-1.96-2.63-1.07 0-1.7.72-1.98 1.42-.1.24-.12.56-.12.88V21h-3.94V8h3.94v1.78h.06c.55-.86 1.54-2.1 3.75-2.1 2.73 0 4.79 1.78 4.79 5.6V21z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <!-- Ligne © centrée -->
        <div class="mt-10 border-t border-gray-700 pt-6">
            <p class="text-sm text-gray-500 text-center">
                © {{ now()->format('Y') }} IRCP Madagascar. Tous droits réservés.
            </p>
        </div>
    </div>
</footer>
