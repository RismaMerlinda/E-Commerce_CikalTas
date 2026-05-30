<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    
                    <div class="mt-6">
                        <p class="mb-4">Berikut adalah gambar yang ada di folder public:</p>
                        <!-- Ganti 'gambar/Logo.png' dengan nama file gambar yang baru Anda masukkan -->
                        <img src="{{ asset('gambar/Logo.png') }}" alt="Gambar Dashboard" class="max-w-full h-auto rounded shadow-sm">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
