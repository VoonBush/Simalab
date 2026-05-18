<x-guest-layout>
    <h3 class="text-lg font-semibold text-gray-900 mb-6">Daftar Akun Baru</h3>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nama Lengkap</label>
            <div class="mt-2">
                <input id="name" name="name" type="text" autocomplete="name" required
                       class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 transition-all"
                       value="{{ old('name') }}">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </div>

        <div>
            <label for="npm" class="block text-sm font-medium leading-6 text-gray-900">NPM</label>
            <div class="mt-2">
                <input id="npm" name="npm" type="text"
                       class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 transition-all"
                       value="{{ old('npm') }}">
                <x-input-error :messages="$errors->get('npm')" class="mt-2" />
            </div>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
            <div class="mt-2">
                <input id="email" name="email" type="email" autocomplete="email" required
                       class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 transition-all"
                       value="{{ old('email') }}">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
            <div class="mt-2">
                <input id="password" name="password" type="password" autocomplete="new-password" required
                       class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 transition-all">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Konfirmasi Password</label>
            <div class="mt-2">
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                       class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 transition-all">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="pt-4">
            <button type="submit"
                    class="flex w-full justify-center rounded-xl bg-blue-600 px-3 py-2.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 active:scale-95 transition-all">
                Daftar
            </button>
        </div>
    </form>

    <p class="mt-10 text-center text-sm text-gray-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-semibold leading-6 text-blue-600 hover:text-blue-500">Masuk di sini</a>
    </p>
</x-guest-layout>
