<x-layouts.site.app :title="__('À propos - IRCP')">
    @include('partials.site-partials.breadcrumb', ['breadcrumbs' => [
        ['label' => 'À propos', 'url' => route('about')]
    ]])

    <section class="relative bg-gradient-to-br from-gray-950 via-gray-600 to-gray-950 text-white py-20 px-6 md:px-12">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white leading-tight">
                    À propos de l'IRCP
                </h1>
                <p class="mt-4 text-lg text-gray-300 max-w-3xl mx-auto">
                    IRCP : International Registry for Certified Professional
                </p>
            </div>
        </div>
    </section>

    <section class="py-16 px-6 md:px-12">
        <div class="max-w-5xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold mb-6 text-white">Notre Mission</h2>
                    <p class="text-gray-300 mb-4">
                        L'IRCP a pour mission de promouvoir et de valoriser les compétences professionnelles à travers un système de certification reconnu et fiable.
                    </p>
                    <p class="text-gray-300">
                        Nous œuvrons pour le développement des compétences à travers des programmes de formation, d'évaluation et de certification reconnus, contribuant ainsi à l'amélioration de la qualité de la main-d'œuvre à Madagascar.
                    </p>
                </div>
                <div class="relative w-full h-72 md:h-[360px]">
                    <img src="{{ asset('images/certificate-bg.png') }}" alt="Mission IRCP" class="w-full h-full object-cover rounded-xl shadow-xl ring-1 ring-gray-700"/>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
                <div class="order-2 md:order-1 relative w-full h-72 md:h-[360px]">
                    <img src="{{ asset('images/certificate-bg.png') }}" alt="Vision IRCP" class="w-full h-full object-cover rounded-xl shadow-xl ring-1 ring-gray-700"/>
                </div>
                <div class="order-1 md:order-2">
                    <h2 class="text-2xl md:text-3xl font-bold mb-6 text-white">Notre Vision</h2>
                    <p class="text-gray-300 mb-4">
                        Devenir l'institution de référence en matière de certification professionnelle à Madagascar et dans la région de l'Océan Indien.
                    </p>
                    <p class="text-gray-300">
                        Nous aspirons à bâtir un écosystème de confiance et de reconnaissance des compétences, où chaque certification délivrée par l'IRCP est synonyme d'excellence et de crédibilité.
                    </p>
                </div>
            </div>

            <div class="mb-16">
                <h2 class="text-2xl md:text-3xl font-bold mb-8 text-white text-center">Nos Valeurs</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-gray-900 p-6 rounded-xl border border-gray-800">
                        <h3 class="text-blue-400 font-semibold mb-2">Intégrité</h3>
                        <p class="text-gray-400 text-sm">Nous agissons avec honnêteté et transparence dans tous nos processus de certification.</p>
                    </div>
                    <div class="bg-gray-900 p-6 rounded-xl border border-gray-800">
                        <h3 class="text-blue-400 font-semibold mb-2">Excellence</h3>
                        <p class="text-gray-400 text-sm">Nous visons l'excellence dans nos services et dans les compétences que nous certifions.</p>
                    </div>
                    <div class="bg-gray-900 p-6 rounded-xl border border-gray-800">
                        <h3 class="text-blue-400 font-semibold mb-2">Innovation</h3>
                        <p class="text-gray-400 text-sm">Nous adoptons des approches innovantes pour répondre aux besoins évolutifs du marché du travail.</p>
                    </div>
                </div>
            </div>

            <div class="mb-16">
                <h2 class="text-2xl md:text-3xl font-bold mb-8 text-white text-center">Notre Histoire</h2>
                <div class="bg-gray-900 p-8 rounded-xl border border-gray-800">
                    <p class="text-gray-300 mb-4">
                        Fondé en [année de fondation], l'IRCP est né de la volonté de combler le fossé entre les compétences acquises et leur reconnaissance sur le marché du travail.
                    </p>
                    <p class="text-gray-300 mb-4">
                        Au fil des années, nous avons développé un réseau de partenaires comprenant des entreprises, des institutions de formation et des organismes gouvernementaux, tous engagés dans la promotion des compétences professionnelles.
                    </p>
                    <p class="text-gray-300">
                        Aujourd'hui, l'IRCP est fier d'avoir certifié des milliers de professionnels dans divers domaines, contribuant ainsi à l'amélioration de leur employabilité et à la croissance économique de Madagascar.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-900 py-16 px-6 md:px-12">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-8 text-white">Notre Équipe</h2>
            <p class="text-gray-300 mb-12 max-w-3xl mx-auto">
                L'IRCP est composé d'une équipe de professionnels dévoués et expérimentés, passionnés par le développement des compétences et l'excellence professionnelle.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Membre d'équipe 1 -->
                <div class="bg-gray-800 p-6 rounded-xl">
                    <div class="w-24 h-24 rounded-full bg-gray-700 mx-auto mb-4 overflow-hidden">
                        <!-- Image du membre -->
                    </div>
                    <h3 class="text-white font-semibold">Nom du Directeur</h3>
                    <p class="text-blue-400 text-sm mb-3">Directeur Général</p>
                    <p class="text-gray-400 text-sm">
                        Description brève du parcours et de l'expertise du directeur.
                    </p>
                </div>

                <!-- Membre d'équipe 2 -->
                <div class="bg-gray-800 p-6 rounded-xl">
                    <div class="w-24 h-24 rounded-full bg-gray-700 mx-auto mb-4 overflow-hidden">
                        <!-- Image du membre -->
                    </div>
                    <h3 class="text-white font-semibold">Nom du Responsable</h3>
                    <p class="text-blue-400 text-sm mb-3">Responsable des Certifications</p>
                    <p class="text-gray-400 text-sm">
                        Description brève du parcours et de l'expertise du responsable.
                    </p>
                </div>

                <!-- Membre d'équipe 3 -->
                <div class="bg-gray-800 p-6 rounded-xl">
                    <div class="w-24 h-24 rounded-full bg-gray-700 mx-auto mb-4 overflow-hidden">
                        <!-- Image du membre -->
                    </div>
                    <h3 class="text-white font-semibold">Nom du Coordinateur</h3>
                    <p class="text-blue-400 text-sm mb-3">Coordinateur des Formations</p>
                    <p class="text-gray-400 text-sm">
                        Description brève du parcours et de l'expertise du coordinateur.
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.site.app>
