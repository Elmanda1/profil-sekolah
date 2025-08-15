<?php
// app/Http/Controllers/SiswaController.php
namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('sekolah')->latest()->paginate(10);
        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|string|max:50|unique:tb_siswa,nisn',
            'nama_siswa' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'email' => 'nullable|email|unique:tb_siswa,email',
            'no_telp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $validated['id_sekolah'] = 1; // Default sekolah ID

        Siswa::create($validated);

        return redirect()->route('admin.siswa.index')
                        ->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function show(Siswa $siswa)
    {
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nisn' => 'required|string|max:50|unique:tb_siswa,nisn,' . $siswa->id_siswa . ',id_siswa',
            'nama_siswa' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'email' => 'nullable|email|unique:tb_siswa,email,' . $siswa->id_siswa . ',id_siswa',
            'no_telp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $validated['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update($validated);

        return redirect()->route('admin.siswa.index')
                        ->with('success', 'Data siswa berhasil diupdate');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }
        
        $siswa->delete();

        return redirect()->route('admin.siswa.index')
                        ->with('success', 'Data siswa berhasil dihapus');
    }

    // Frontend method
    public function frontendIndex()
    {
        $siswa = Siswa::latest()->paginate(12);
        return view('frontend.profilSiswa', compact('siswa'));
    }
}