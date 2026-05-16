<aside class="w-full bg-white border-r border-gray-200 flex flex-col h-full">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-100 flex items-center space-x-3">
        <div class="w-10 h-10 bg-blue-900 rounded-lg flex items-center justify-center text-white">
            <i data-lucide="graduation-cap" class="w-6 h-6"></i>
        </div>
        <div>
            <h1 class="text-lg font-bold text-blue-900 leading-tight">SIAKAD</h1>
            <p class="text-[10px] text-gray-500 uppercase tracking-wider">SMK Muhammadiyah 2</p>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 py-6 space-y-1 overflow-y-auto">
        <p class="px-8 pb-2 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Menu Utama</p>
        
        <a href="{{ route('siswa.dashboard') }}" class="flex items-center py-3 text-sm font-medium transition-colors {{ request()->routeIs('siswa.dashboard') ? 'ml-0 mr-4 pl-7 pr-4 rounded-r-xl bg-indigo-50/50 text-blue-800 border-l-4 border-blue-900' : 'mx-4 px-4 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3 {{ request()->routeIs('siswa.dashboard') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('siswa.jadwal.index') }}" class="flex items-center py-3 text-sm font-medium transition-colors {{ request()->routeIs('siswa.jadwal.*') ? 'ml-0 mr-4 pl-7 pr-4 rounded-r-xl bg-indigo-50/50 text-blue-800 border-l-4 border-blue-900' : 'mx-4 px-4 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i data-lucide="calendar-days" class="w-5 h-5 mr-3 {{ request()->routeIs('siswa.jadwal.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Jadwal Pelajaran</span>
        </a>
        
        <a href="{{ route('siswa.nilai.index') }}" class="flex items-center py-3 text-sm font-medium transition-colors {{ request()->routeIs('siswa.nilai.*') ? 'ml-0 mr-4 pl-7 pr-4 rounded-r-xl bg-indigo-50/50 text-blue-800 border-l-4 border-blue-900' : 'mx-4 px-4 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i data-lucide="line-chart" class="w-5 h-5 mr-3 {{ request()->routeIs('siswa.nilai.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Nilai</span>
        </a>
        
        <a href="{{ route('siswa.absensi.index') }}" class="flex items-center py-3 text-sm font-medium transition-colors {{ request()->routeIs('siswa.absensi.*') ? 'ml-0 mr-4 pl-7 pr-4 rounded-r-xl bg-indigo-50/50 text-blue-800 border-l-4 border-blue-900' : 'mx-4 px-4 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i data-lucide="clock" class="w-5 h-5 mr-3 {{ request()->routeIs('siswa.absensi.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Presensi</span>
        </a>

        <p class="px-8 pt-4 pb-2 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Lainnya</p>

        <a href="{{ route('siswa.pengumuman.index') }}" class="flex items-center py-3 text-sm font-medium transition-colors {{ request()->routeIs('siswa.pengumuman.*') ? 'ml-0 mr-4 pl-7 pr-4 rounded-r-xl bg-indigo-50/50 text-blue-800 border-l-4 border-blue-900' : 'mx-4 px-4 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i data-lucide="megaphone" class="w-5 h-5 mr-3 {{ request()->routeIs('siswa.pengumuman.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Pengumuman</span>
        </a>
        
        <a href="{{ route('siswa.profile.index') }}" class="flex items-center py-3 text-sm font-medium transition-colors {{ request()->routeIs('siswa.profile.*') ? 'ml-0 mr-4 pl-7 pr-4 rounded-r-xl bg-indigo-50/50 text-blue-800 border-l-4 border-blue-900' : 'mx-4 px-4 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i data-lucide="user" class="w-5 h-5 mr-3 {{ request()->routeIs('siswa.profile.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Profil</span>
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-gray-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center px-4 py-2.5 w-full text-sm font-bold text-gray-600 hover:text-red-700 hover:bg-red-50 rounded-xl transition-colors">
                <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
