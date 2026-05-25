@extends('layouts.admin')

@section('title', 'Profil')
@section('page-title', 'Profil')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    
    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="space-y-2">
            <h3 class="text-lg font-semibold text-gray-900">
                Informasi Akun
            </h3>

            <p class="text-sm text-gray-500">
                Perbarui nama dan alamat email akun Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Nama -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    class="mt-1 block w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                />

                @error('name')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    class="mt-1 block w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                />

                @error('email')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>

        <div class="flex justify-end">
            <button
                type="submit"
                class="inline-flex items-center rounded-xl bg-blue-800 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-300"
            >
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-6">

    <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <h3 class="text-lg font-semibold text-gray-900">
                Ubah Password
            </h3>

            <p class="text-sm text-gray-500">
                Gunakan password yang kuat dan aman.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700">
                    Password Lama
                </label>

                <input
                    type="password"
                    name="current_password"
                    id="current_password"
                    required
                    class="mt-1 block w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                />

                @error('current_password')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Password Baru
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    class="mt-1 block w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                />

                @error('password')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                    Konfirmasi Password Baru
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    required
                    class="mt-1 block w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                />
            </div>

        </div>

        <div class="flex justify-end">
            <button
                type="submit"
                class="inline-flex items-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300"
            >
                Ubah Password
            </button>
        </div>

    </form>
</div>

@endsection