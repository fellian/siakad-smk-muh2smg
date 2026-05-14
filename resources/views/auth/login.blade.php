<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang</h2>
        <p class="text-sm text-gray-500 mt-1">Silakan masuk dengan akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-5">
            <label for="email" class="block text-xs font-bold text-gray-700 mb-2">{{ __('Email') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="far fa-id-badge text-gray-400"></i>
                </div>
                <input id="email" class="block w-full pl-10 pr-3 py-3 bg-gray-50 border-0 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan Email" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label for="password" class="block text-xs font-bold text-gray-700 mb-2">{{ __('Password') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <input id="password" class="block w-full pl-10 pr-10 py-3 bg-gray-50 border-0 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="Masukkan kata sandi" />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                    <i class="far fa-eye-slash text-gray-400 hover:text-gray-600"></i>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mb-8">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-800 shadow-sm focus:ring-blue-500 w-4 h-4" name="remember">
                <span class="ms-2 text-xs font-medium text-gray-500">{{ __('Ingat sesi ini') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-bold text-blue-800 hover:text-blue-900" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-800 hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <span class="mr-2">Masuk</span>
                <i class="fas fa-sign-in-alt mt-[2px]"></i>
            </button>
        </div>
    </form>
    
    <div class="mt-12 pt-6 border-t border-gray-200 text-center">
        <div class="mb-2">
            <i class="fas fa-headset text-xl text-gray-300"></i>
        </div>
        <p class="text-xs text-gray-500">Mengalami kesulitan saat login?</p>
        <a href="#" class="text-xs font-bold text-blue-800 hover:underline">Hubungi Kami</a>
    </div>
</x-guest-layout>
