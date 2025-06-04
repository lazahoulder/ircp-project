<div class="bg-gray-900 p-8 rounded-xl border border-gray-800">
    <h2 class="text-2xl font-bold mb-6 text-white">Envoyez-nous un message</h2>

    @if($successMessage)
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ $successMessage }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Nom complet</label>
            <input type="text" id="name" wire:model="name" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Votre nom">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
            <input type="email" id="email" wire:model="email" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="votre@email.com">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="subject" class="block text-sm font-medium text-gray-300 mb-1">Sujet</label>
            <input type="text" id="subject" wire:model="subject" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Sujet de votre message">
            @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-gray-300 mb-1">Message</label>
            <textarea id="message" wire:model="message" rows="5" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Votre message"></textarea>
            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit" class="w-full px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-lg font-semibold shadow transition">
                Envoyer le message
            </button>
        </div>
    </form>
</div>
