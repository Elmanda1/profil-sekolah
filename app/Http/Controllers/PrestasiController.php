<?php
// app/Http/Controllers/PrestasiController.php
namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasi = Prestasi::with('sekolah')->latest()->paginate(10);
        return view('admin.prestasi.index', compact('prestasi'));
    }

    public function create()
    {
        return view('admin.prestasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('prestasi', 'public');
        }

        $validated['id_sekolah'] = 1; // Default sekolah ID

        Prestasi::create($validated);

        return redirect()->route('admin.prestasi.index')
                        ->with('success', 'Data prestasi berhasil ditambahkan');
    }

    public function show(Prestasi $prestasi)
    {
        return view('admin.prestasi.show', compact('prestasi'));
    }

    public function edit(Prestasi $prestasi)
    {
        return view('admin.prestasi.edit', compact('prestasi'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            if ($prestasi->gambar) {
                Storage::disk('public')->delete($prestasi->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('prestasi', 'public');
        }

        $prestasi->update($validated);

        return redirect()->route('admin.prestasi.index')
                        ->with('success', 'Data prestasi berhasil diupdate');
    }

    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->gambar) {
            Storage::disk('public')->delete($prestasi->gambar);
        }
        
        $prestasi->delete();

        return redirect()->route('admin.prestasi.index')
                        ->with('success', 'Data prestasi berhasil dihapus');
    }

    // Frontend methods
    public function frontendIndex()
    {
        $prestasi = Prestasi::latest()->paginate(9);
        return view('frontend.prestasi', compact('prestasi'));
    }

    public function frontendShow(Prestasi $prestasi)
    {
        return view('frontend.prestasi-detail', compact('prestasi'));
    }
}