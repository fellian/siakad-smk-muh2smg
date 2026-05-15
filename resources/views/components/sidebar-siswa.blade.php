<aside class="w-64 bg-white border-r border-gray-200 flex flex-col h-full">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-100 flex items-center space-x-3">
        <div class="w-10 h-10 bg-blue-900 rounded-lg flex items-center justify-center text-white">
            <i class="fas fa-graduation-cap text-xl"></i>
        </div>
        <div>
            <h1 class="text-lg font-bold text-blue-900 leading-tight">SIAKAD</h1>
            <p class="text-[10px] text-gray-500 uppercase tracking-wider">SMK Muhammadiyah 2</p>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <a href="{{ route('siswa.dashboard') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('siswa.dashboard') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="fas fa-th-large w-6 {{ request()->routeIs('siswa.dashboard') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('siswa.jadwal.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('siswa.jadwal.*') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="far fa-calendar-alt w-6 {{ request()->routeIs('siswa.jadwal.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Jadwal Pelajaran</span>
        </a>
        
        <a href="{{ route('siswa.nilai.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('siswa.nilai.*') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="far fa-star w-6 {{ request()->routeIs('siswa.nilai.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Nilai</span>
        </a>
        
        <a href="{{ route('siswa.absensi.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('siswa.absensi.*') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="fas fa-user-check w-6 {{ request()->routeIs('siswa.absensi.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Presensi</span>
        </a>

        <a href="{{ route('siswa.pengumuman.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('siswa.pengumuman.*') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="fas fa-bullhorn w-6 {{ request()->routeIs('siswa.pengumuman.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Pengumuman</span>
        </a>
        
        <a href="{{ route('siswa.profile.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors text-gray-600 hover:bg-gray-50 hover:text-blue-800">
            <i class="far fa-user w-6 text-gray-400"></i>
            <span>Profil</span>
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-6 border-t border-gray-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center px-4 py-2 w-full text-sm font-medium text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                <i class="fas fa-sign-out-alt w-6"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
