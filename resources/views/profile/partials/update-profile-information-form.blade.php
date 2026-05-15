<section>
    <header>
        <h2 class="text-lg font-bold text-gray-900">
            Informasi Profil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Perbarui informasi profil dan alamat email akun Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Foto Profil (Avatar) --}}
        <div>
            <x-input-label for="avatar" :value="__('Foto Profil')" class="mb-2" />
            <div class="flex items-center gap-4">
                <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="Avatar Preview" class="w-20 h-20 rounded-full object-cover border border-gray-200">
                <div class="flex-1">
                    <input type="file" id="avatar" name="avatar" accept="image/*" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-xl file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100 transition-all cursor-pointer"
                        onchange="document.getElementById('avatar-preview').src = window.URL.createObjectURL(this.files[0])">
                    <p class="mt-1 text-xs text-gray-400">Format: JPG, PNG, GIF. Maksimal: 2MB.</p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="nama" :value="__('Nama Lengkap')" />
            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $user->name ?? $user->nama)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="npm" :value="__('NPM')" />
                <x-text-input id="npm" name="npm" type="text" class="mt-1 block w-full" :value="old('npm', $user->npm)" required />
                <x-input-error class="mt-2" :messages="$errors->get('npm')" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('No. Handphone')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="jurusan" :value="__('Jurusan')" />
                <x-text-input id="jurusan" name="jurusan" type="text" class="mt-1 block w-full" :value="old('jurusan', $user->jurusan)" />
                <x-input-error class="mt-2" :messages="$errors->get('jurusan')" />
            </div>

            <div>
                <x-input-label for="prodi" :value="__('Program Studi')" />
                <x-text-input id="prodi" name="prodi" type="text" class="mt-1 block w-full" :value="old('prodi', $user->prodi)" />
                <x-input-error class="mt-2" :messages="$errors->get('prodi')" />
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        Email Anda belum diverifikasi.

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Klik di sini untuk mengirim ulang email verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            Tautan verifikasi baru telah dikirim ke alamat email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>

            @if (session('success') || session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 font-medium"
                >{{ __('Berhasil disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
