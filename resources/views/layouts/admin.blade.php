<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIAKAD SMK Muhammadiyah 2 Semarang')</title>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-[#f8fafc] border-b border-gray-200">
                <div class="flex items-center justify-between px-8 py-4">
                    <h2 class="text-sm font-semibold text-gray-600 uppercase tracking-wider">@yield('page-title')</h2>
                    <div class="flex items-center space-x-6">
                        <button class="text-gray-400 hover:text-gray-600">
                            <i class="far fa-bell text-lg"></i>
                        </button>
                        <button class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-cog text-lg"></i>
                        </button>
                        <div class="flex items-center space-x-3 border-l pl-6 border-gray-200">
                            <div class="text-right">
                                <p class="text-sm font-semibold text-blue-900">{{ auth()->user()->name ?? 'Administrator' }}</p>
                                <p class="text-xs text-gray-500">Super Admin</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden border border-gray-200">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=0D8ABC&color=fff" alt="Profile" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f8fafc] p-8">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    @stack('scripts')
</body>
</html>