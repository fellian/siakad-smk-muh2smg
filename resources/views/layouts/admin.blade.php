<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | SIAKAD SMK Muhammadiyah 2</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <!-- Tailwind CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #eff6ff !important;
            border-color: #bfdbfe !important;
            color: #1d4ed8 !important;
            border-radius: 0.375rem;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 antialiased overflow-hidden" x-data="{ sidebarOpen: false, profileOpen: false }">
    <div class="flex h-screen w-full bg-gray-50">
        
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden" 
             @click="sidebarOpen = false" style="display: none;"></div>
        
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 lg:w-72 flex flex-col shadow-sm">
            @include('components.sidebar')
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 shadow-sm z-30">
                <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-3 h-16">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md p-1 lg:hidden mr-4">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>
                        <h2 class="text-sm font-bold text-gray-600 tracking-wider uppercase truncate">@yield('page-title')</h2>
                    </div>
                    
                    <div class="flex items-center space-x-3 sm:space-x-5">
                        <button class="text-gray-500 hover:text-gray-700 transition-colors relative p-1">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                            </span>
                        </button>
                        
                        <button class="text-gray-500 hover:text-gray-700 transition-colors p-1">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                        </button>
                        
                        <div class="h-8 w-px bg-gray-200 hidden sm:block mx-2"></div>
                        
                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center space-x-3 focus:outline-none hover:bg-gray-50 p-1.5 rounded-xl transition-colors">
                                <div class="hidden md:block text-right">
                                    <p class="text-sm font-bold text-blue-900 leading-tight">{{ auth()->user()->name ?? 'Administrator' }}</p>
                                    <p class="text-[11px] font-medium text-gray-500">Admin</p>
                                </div>
                                <div class="w-9 h-9 rounded-full bg-blue-50 border-2 border-white shadow-sm flex items-center justify-center overflow-hidden shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Administrator') }}&background=EFF6FF&color=1D4ED8&bold=true" alt="Profile" class="w-full h-full object-cover">
                                </div>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="profileOpen" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 focus:outline-none" style="display: none;">
                                
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                    <i data-lucide="user" class="w-4 h-4 mr-2 flex-shrink-0"></i> 
                                    <span>Profil Saya</span>
                                </a>
                                
                                <div class="border-t border-gray-100 my-1"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                        <i data-lucide="log-out" class="w-4 h-4 mr-2 flex-shrink-0"></i> 
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50/50 p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm mb-6 flex items-start animate-fade-in-down">
                            <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mt-0.5 mr-3"></i>
                            <div>
                                <h3 class="text-sm font-medium">Berhasil</h3>
                                <p class="text-sm mt-1">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm mb-6 flex items-start animate-fade-in-down">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 mt-0.5 mr-3"></i>
                            <div>
                                <h3 class="text-sm font-medium">Terjadi Kesalahan</h3>
                                <p class="text-sm mt-1">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        lucide.createIcons();
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
            },
            classes: {
                sWrapper: "dataTables_wrapper dt-tailwindcss",
            }
        });
    </script>
    @stack('scripts')
</body>
</html>