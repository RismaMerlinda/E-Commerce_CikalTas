<x-main-layout>
    <x-slot name="title">Dashboard - CikalTas</x-slot>

    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6" style="color: #202224;">Dashboard</h1>

        <div class="bg-white rounded-2xl shadow-md p-8">
            <p class="mb-6" style="color: #606060;">Selamat datang di CikalTas! 👋</p>
            
            <div class="mt-6">
                <p class="mb-4" style="color: #606060;">Berikut adalah logo CikalTas kami:</p>
                <img src="{{ asset('gambar/Logo.png') }}" alt="CikalTas Logo" class="max-w-xs h-auto rounded shadow-sm">
            </div>
        </div>
    </div>
</x-main-layout>
