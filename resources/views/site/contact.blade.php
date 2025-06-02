<x-layouts.site.app :title="__('Contact - IRCP')">
    @include('partials.site-partials.breadcrumb', ['breadcrumbs' => [
        ['label' => 'Contact', 'url' => route('contact')]
    ]])

    <section class="relative bg-gradient-to-br from-gray-950 via-gray-600 to-gray-950 text-white py-20 px-6 md:px-12">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white leading-tight">
                    Contactez-nous
                </h1>
                <p class="mt-4 text-lg text-gray-300 max-w-3xl mx-auto">
                    Nous sommes à votre disposition pour répondre à toutes vos questions concernant les certifications IRCP.
                </p>
            </div>
        </div>
    </section>

    <section class="py-16 px-6 md:px-12">
        <div class="max-w-5xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-start">
                <!-- Informations de contact -->
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold mb-8 text-white">Nos coordonnées</h2>

                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Adresse</h3>
                                <p class="text-gray-300 mt-1">
                                    [Adresse de l'IRCP]<br>
                                    Antananarivo, Madagascar
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Téléphone</h3>
                                <p class="text-gray-300 mt-1">
                                    +261 XX XX XXX XX
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Email</h3>
                                <p class="text-gray-300 mt-1">
                                    contact@ircp-madagascar.org
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Heures d'ouverture</h3>
                                <p class="text-gray-300 mt-1">
                                    Lundi - Vendredi: 8h00 - 17h00<br>
                                    Samedi: 9h00 - 12h00<br>
                                    Dimanche: Fermé
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <h3 class="text-lg font-semibold text-white mb-4">Suivez-nous</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-300 hover:text-white" aria-label="Facebook">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22 12a10 10 0 10-11.5 9.9v-7h-2v-3h2v-2.3c0-2 1.2-3.1 3-3.1.9 0 1.8.1 1.8.1v2h-1c-1 0-1.3.6-1.3 1.2V12h2.3l-.4 3h-1.9v7A10 10 0 0022 12z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white" aria-label="X">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.633 7.997c.013.179.013.359.013.538 0 5.486-4.176 11.816-11.816 11.816-2.35 0-4.537-.69-6.373-1.867.33.038.66.051.99.051 1.946 0 3.733-.66 5.161-1.77a4.177 4.177 0 01-3.896-2.89c.26.038.52.064.793.064.384 0 .768-.051 1.127-.141a4.171 4.171 0 01-3.34-4.09v-.051c.559.312 1.2.499 1.886.525a4.166 4.166 0 01-1.857-3.477c0-.768.205-1.484.56-2.102a11.816 11.816 0 008.576 4.354 4.72 4.72 0 01-.102-.956 4.166 4.166 0 017.213-2.844 8.2 8.2 0 002.637-1.004 4.143 4.143 0 01-1.834 2.298 8.334 8.334 0 002.39-.651 8.949 8.949 0 01-2.083 2.16z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white" aria-label="LinkedIn">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6.94 21H3V8h3.94v13zM4.97 6.44C3.88 6.44 3 5.56 3 4.47S3.88 2.5 4.97 2.5 6.94 3.38 6.94 4.47 6.06 6.44 4.97 6.44zM21 21h-3.94v-6.53c0-1.56-.56-2.63-1.96-2.63-1.07 0-1.7.72-1.98 1.42-.1.24-.12.56-.12.88V21h-3.94V8h3.94v1.78h.06c.55-.86 1.54-2.1 3.75-2.1 2.73 0 4.79 1.78 4.79 5.6V21z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Formulaire de contact -->
                <livewire:contact-form />
            </div>
        </div>
    </section>

    <section class="py-16 px-6 md:px-12">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold mb-8 text-white text-center">Notre localisation</h2>
            <div class="bg-gray-900 p-4 rounded-xl border border-gray-800 h-96 flex items-center justify-center">
                <!-- Emplacement pour intégrer une carte Google Maps -->
                <p class="text-gray-400">Carte Google Maps à intégrer ici</p>
            </div>
        </div>
    </section>
</x-layouts.site.app>
