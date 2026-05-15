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
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="fas fa-th-large w-6 {{ request()->routeIs('admin.dashboard') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Dashboard</span>
        </a>
        
        <p class="px-4 pt-4 pb-2 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Data Master</p>
        
        <a href="{{ route('admin.siswa.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="fas fa-user-friends w-6 {{ request()->routeIs('admin.siswa.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Data Siswa</span>
        </a>
        
        <a href="{{ route('admin.guru.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.guru.*') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="fas fa-chalkboard-teacher w-6 {{ request()->routeIs('admin.guru.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Data Guru</span>
        </a>
        
        <a href="{{ route('admin.kelas.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.kelas.*') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="fas fa-school w-6 {{ request()->routeIs('admin.kelas.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Data Kelas</span>
        </a>

        <a href="{{ route('admin.jurusan.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.jurusan.*') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="fas fa-layer-group w-6 {{ request()->routeIs('admin.jurusan.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Data Jurusan</span>
        </a>
        
        <a href="{{ route('admin.mapel.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.mapel.*') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="fas fa-book w-6 {{ request()->routeIs('admin.mapel.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Mata Pelajaran</span>
        </a>
        
        <p class="px-4 pt-4 pb-2 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Akademik</p>

        <a href="{{ route('admin.tahun-ajaran.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.tahun-ajaran.*') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="fas fa-calendar-check w-6 {{ request()->routeIs('admin.tahun-ajaran.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Tahun Ajaran</span>
        </a>
        
        <a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.jadwal.*') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="far fa-calendar-alt w-6 {{ request()->routeIs('admin.jadwal.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Jadwal Pelajaran</span>
        </a>
        
        <p class="px-4 pt-4 pb-2 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Sistem</p>
        
        <a href="{{ route('admin.pengumuman.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.pengumuman.*') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="fas fa-bullhorn w-6 {{ request()->routeIs('admin.pengumuman.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Pengumuman</span>
        </a>
        
        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-800 border-l-4 border-blue-800' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-800' }}">
            <i class="fas fa-user-cog w-6 {{ request()->routeIs('admin.users.*') ? 'text-blue-800' : 'text-gray-400' }}"></i>
            <span>Manajemen User</span>
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