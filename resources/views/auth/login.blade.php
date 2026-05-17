<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang</h2>
        <p class="text-sm text-gray-500 mt-1">Silakan masuk dengan akun Anda.</p>
    </div>

    <!-- Menggunakan Alpine.js (bawaan Laravel Breeze) untuk fitur show/hide password -->
    <form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }">
        @csrf

        <!-- Email Address -->
        <div class="mb-5">
            <label for="email" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Email') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="far fa-id-badge text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                </div>
                <input id="email" 
                       class="block w-full pl-10 pr-3 py-3 bg-gray-50/80 border border-gray-200/80 rounded-xl text-sm placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200 outline-none" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus 
                       autocomplete="username" 
                       placeholder="Masukkan Email Anda" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label for="password" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Password') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                </div>
                
                <!-- Tipe input dinamis berdasarkan state Alpine.js -->
                <input id="password" 
                       class="block w-full pl-10 pr-10 py-3 bg-gray-50/80 border border-gray-200/80 rounded-xl text-sm placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200 outline-none"
                       :type="showPassword ? 'text' : 'password'"
                       name="password"
                       required 
                       autocomplete="current-password" 
                       placeholder="Masukkan kata sandi" />
                
                <!-- Tombol interaktif untuk melihat/menyembunyikan password -->
                <button type="button" 
                        @click="showPassword = !showPassword" 
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                    <i class="far" :class="showPassword ? 'fa-eye' : 'fa-eye-slash'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500/30 w-4 h-4 transition-all" name="remember">
                <span class="ms-2 text-xs font-medium text-gray-500 hover:text-gray-700 transition-colors">{{ __('Ingat sesi ini') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-150 transform active:scale-[0.99]">
                <span>Masuk</span>
                <i class="fas fa-sign-in-alt ms-2 text-xs opacity-90"></i>
            </button>
        </div>
    </form>
    
    <!-- Footer Help Section -->
    <div class="mt-10 pt-6 border-t border-gray-100 text-center">
        <div class="mb-2">
            <i class="fas fa-headset text-lg text-gray-300"></i>
        </div>
        <p class="text-xs text-gray-400">Mengalami kesulitan saat login?</p>
        <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-800 hover:underline inline-block mt-0.5 transition-colors">
            Hubungi Kami
        </a>
    </div>
</x-guest-layout>