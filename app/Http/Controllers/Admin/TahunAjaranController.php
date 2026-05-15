<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjarans = TahunAjaran::withCount(['kelas', 'jadwals', 'nilais'])
            ->orderByDesc('tahun')
            ->orderByDesc('semester')
            ->get();

        $tahunAjaranAktif = TahunAjaran::active();

        return view('admin.tahun-ajaran.index', compact('tahunAjarans', 'tahunAjaranAktif'));
    }

    public function create()
    {
        $hasActive = TahunAjaran::where('status', 'aktif')->exists();

        return view('admin.tahun-ajaran.create', compact('hasActive'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|string|max:9',
            'semester' => [
                'required',
                'in:1,2',
                Rule::unique('tahun_ajarans')->where(fn ($q) => $q->where('tahun', $request->tahun)),
            ],
            'set_aktif' => 'nullable|boolean',
        ]);

        $tahunAjaran = TahunAjaran::create([
            'tahun' => $validated['tahun'],
            'semester' => $validated['semester'],
            'status' => 'nonaktif',
        ]);

        if ($request->has('set_aktif') || ! TahunAjaran::where('status', 'aktif')->exists()) {
            TahunAjaran::setAsOnlyActive($tahunAjaran);
            $message = 'Tahun ajaran berhasil ditambahkan dan dijadikan aktif.';
        } else {
            $message = 'Tahun ajaran berhasil ditambahkan.';
        }

        return redirect()->route('admin.tahun-ajaran.index')->with('success', $message);
    }

    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('admin.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $validated = $request->validate([
            'tahun' => 'required|string|max:9',
            'semester' => [
                'required',
                'in:1,2',
                Rule::unique('tahun_ajarans')
                    ->where(fn ($q) => $q->where('tahun', $request->tahun))
                    ->ignore($tahunAjaran->id),
            ],
        ]);

        $tahunAjaran->update($validated);

        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil diperbarui!');
    }

    public function activate(TahunAjaran $tahun_ajaran)
    {
        TahunAjaran::setAsOnlyActive($tahun_ajaran);

        return redirect()
            ->route('admin.tahun-ajaran.index')
            ->with('success', "Tahun ajaran {$tahun_ajaran->label} sekarang aktif. Semua tahun ajaran lain otomatis dinonaktifkan.");
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        if ($tahunAjaran->kelas()->exists() || $tahunAjaran->jadwals()->exists() || $tahunAjaran->nilais()->exists()) {
            return redirect()
                ->route('admin.tahun-ajaran.index')
                ->with('error', 'Tahun ajaran tidak dapat dihapus karena masih digunakan oleh kelas, jadwal, atau nilai.');
        }

        if ($tahunAjaran->isAktif()) {
            return redirect()
                ->route('admin.tahun-ajaran.index')
                ->with('error', 'Tahun ajaran aktif tidak dapat dihapus. Aktifkan tahun ajaran lain terlebih dahulu.');
        }

        $tahunAjaran->delete();

        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil dihapus!');
    }
}
