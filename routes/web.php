<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

// Public
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// ADMIN ROUTES

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Siswa
    Route::resource('siswa', App\Http\Controllers\Admin\SiswaController::class);
    Route::post('siswa/import', [App\Http\Controllers\Admin\SiswaController::class, 'import'])->name('siswa.import');

    // Guru
    Route::resource('guru', App\Http\Controllers\Admin\GuruController::class);

    // Kelas & Jurusan
    Route::resource('kelas', App\Http\Controllers\Admin\KelasController::class)->parameters(['kelas' => 'kelas']);
    Route::resource('jurusan', App\Http\Controllers\Admin\JurusanController::class);

    // Mapel
    Route::resource('mapel', App\Http\Controllers\Admin\MapelController::class);

    // Tahun Ajaran
    Route::resource('tahun-ajaran', App\Http\Controllers\Admin\TahunAjaranController::class);
    Route::post('tahun-ajaran/{tahun_ajaran}/activate', [App\Http\Controllers\Admin\TahunAjaranController::class, 'activate'])->name('tahun-ajaran.activate');

    // Jadwal
    Route::resource('jadwal', App\Http\Controllers\Admin\JadwalController::class);
    Route::get('jadwal/check-bentrok', [App\Http\Controllers\Admin\JadwalController::class, 'checkBentrok'])->name('jadwal.check-bentrok');

    // Pengumuman
    Route::resource('pengumuman', App\Http\Controllers\Admin\PengumumanController::class);

    // Users
    Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::post('users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
});


// GURU ROUTES

Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\Guru\DashboardController::class, 'index'])->name('dashboard');

    // Nilai
    Route::get('nilai', [App\Http\Controllers\Guru\NilaiController::class, 'index'])->name('nilai.index');
    Route::get('nilai/input/{kelas_id}/{mapel_id}', [App\Http\Controllers\Guru\NilaiController::class, 'inputNilai'])->name('nilai.input');
    Route::post('nilai/store', [App\Http\Controllers\Guru\NilaiController::class, 'storeNilai'])->name('nilai.store');
    Route::get('nilai/rekap/{kelas_id}', [App\Http\Controllers\Guru\NilaiController::class, 'rekap'])->name('nilai.rekap');
    Route::get('nilai/export/{kelas_id}', [App\Http\Controllers\Guru\NilaiController::class, 'export'])->name('nilai.export');

    // Presensi (sesi jam pelajaran)
    Route::get('absensi', [App\Http\Controllers\Guru\AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('absensi/rekap', [App\Http\Controllers\Guru\AbsensiController::class, 'rekap'])->name('absensi.rekap');
    Route::post('absensi/jadwal/{jadwal}/mulai', [App\Http\Controllers\Guru\AbsensiController::class, 'mulaiSesi'])->name('absensi.sesi.mulai');
    Route::get('absensi/sesi/{presensi_sesi}', [App\Http\Controllers\Guru\AbsensiController::class, 'showSesi'])->name('absensi.sesi.show');
    Route::post('absensi/sesi/{presensi_sesi}/tutup', [App\Http\Controllers\Guru\AbsensiController::class, 'tutupSesi'])->name('absensi.sesi.tutup');
    Route::post('absensi/sesi/{presensi_sesi}/siswa', [App\Http\Controllers\Guru\AbsensiController::class, 'upsertAbsensiSiswa'])->name('absensi.sesi.siswa');

    // Jadwal
    Route::get('jadwal', [App\Http\Controllers\Guru\JadwalController::class, 'index'])->name('jadwal.index');

    // Pengumuman
    Route::get('pengumuman', [App\Http\Controllers\Guru\PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('pengumuman/{pengumuman}', [App\Http\Controllers\Guru\PengumumanController::class, 'show'])->name('pengumuman.show');

    // Profil
    Route::get('profile', [App\Http\Controllers\Guru\ProfileController::class, 'index'])->name('profile.index');
    Route::patch('profile', [App\Http\Controllers\Guru\ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [App\Http\Controllers\Guru\ProfileController::class, 'updatePassword'])->name('profile.password');
});


//siswa

Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');

    Route::get('nilai', [App\Http\Controllers\Siswa\NilaiController::class, 'index'])->name('nilai.index');

    Route::get('rapor', [App\Http\Controllers\Siswa\RaporController::class, 'index'])->name('rapor.index');
    Route::get('rapor/print', [App\Http\Controllers\Siswa\RaporController::class, 'print'])->name('rapor.print');

    Route::get('jadwal', [App\Http\Controllers\Siswa\JadwalController::class, 'index'])->name('jadwal.index');

    Route::get('absensi', [App\Http\Controllers\Siswa\AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('absensi/presensi', [App\Http\Controllers\Siswa\AbsensiController::class, 'simpanPresensi'])->name('absensi.presensi.store');

    Route::get('pengumuman', [App\Http\Controllers\Siswa\PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('pengumuman/{pengumuman}', [App\Http\Controllers\Siswa\PengumumanController::class, 'show'])->name('pengumuman.show');

    Route::get('profile', [App\Http\Controllers\Siswa\ProfileController::class, 'index'])->name('profile.index');
    Route::patch('profile', [App\Http\Controllers\Siswa\ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [App\Http\Controllers\Siswa\ProfileController::class, 'updatePassword'])->name('profile.password');
});


Route::get('/redirect', function () {
    $role = Auth::user()->role;
    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'guru' => redirect()->route('guru.dashboard'),
        'siswa' => redirect()->route('siswa.dashboard'),
        default => redirect('/'),
    };
})->middleware('auth')->name('redirect');
