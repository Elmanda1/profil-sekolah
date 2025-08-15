<?php
// app/Http/Controllers/KelasController.php
namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\JenisKelas;
use App\Models\Guru;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['sekolah', 'jurusan', 'jenisKelas', 'waliKelas'])->latest()->paginate(10);
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        $jenisKelas = JenisKelas::all();
        $guru = Guru::all();
        return view('admin.kelas.create', compact('jurusan', 'jenisKelas', 'guru'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'id_jurusan' => 'nullable|exists:tb_jurusan,id_jurusan',
            'id_jenis_kelas' => 'nullable|exists:tb_jenis_kelas,id_jenis_kelas',
            'wali_kelas' => 'nullable|exists:tb_guru,id_guru'
        ]);

        $validated['id_sekolah'] = 1; // Default sekolah ID

        Kelas::create($validated);

        return redirect()->route('admin.kelas.index')
                        ->with('success', 'Data kelas berhasil ditambahkan');
    }

    public function show(Kelas $kelas)
    {
        $kelas->load(['siswa', 'jurusan', 'jenisKelas', 'waliKelas']);
        return view('admin.kelas.show', compact('kelas'));
    }

    public function edit(Kelas $kelas)
    {
        $jurusan = Jurusan::all();
        $jenisKelas = JenisKelas::all();
        $guru = Guru::all();
        return view('admin.kelas.edit', compact('kelas', 'jurusan', 'jenisKelas', 'guru'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'id_jurusan' => 'nullable|exists:tb_jurusan,id_jurusan',
            'id_jenis_kelas' => 'nullable|exists:tb_jenis_kelas,id_jenis_kelas',
            'wali_kelas' => 'nullable|exists:tb_guru,id_guru'
        ]);

        $kelas->update($validated);

        return redirect()->route('admin.kelas.index')
                        ->with('success', 'Data kelas berhasil diupdate');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return redirect()->route('admin.kelas.index')
                        ->with('success', 'Data kelas berhasil dihapus');
    }

    // Method untuk assign siswa ke kelas
    public function assignSiswa(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'siswa_ids' => 'required|array',
            'siswa_ids.*' => 'exists:tb_siswa,id_siswa'
        ]);

        $kelas->siswa()->sync($validated['siswa_ids']);

        return redirect()->back()->with('success', 'Siswa berhasil diassign ke kelas');
    }
}