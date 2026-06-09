<x-main-layout>
    <x-slot name="title">Edit Profil - CikalTas</x-slot>

    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6" style="color: #202224;">Edit Profil</h1>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-md p-8">
                <h2 class="text-xl font-bold mb-6" style="color: #202224;">Informasi Profil</h2>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-8">
                <h2 class="text-xl font-bold mb-6" style="color: #202224;">Ubah Kata Sandi</h2>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-8">
                <h2 class="text-xl font-bold mb-6" style="color: #202224;">Hapus Akun</h2>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
