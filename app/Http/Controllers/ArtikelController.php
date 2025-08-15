<?php
// app/Http/Controllers/ArtikelController.php
namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikel = Artikel::with('sekolah')->latest()->paginate(10);
        return view('admin.artikel.index', compact('artikel'));
    }

    public function create()
    {
        return view('admin.artikel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('artikel', 'public');
        }

        $validated['id_sekolah'] = 1; // Default sekolah ID

        Artikel::create($validated);

        return redirect()->route('admin.artikel.index')
                        ->with('success', 'Artikel berhasil ditambahkan');
    }

    public function show(Artikel $artikel)
    {
        return view('admin.artikel.show', compact('artikel'));
    }

    public function edit(Artikel $artikel)
    {
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, Artikel $artikel)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            if ($artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('artikel', 'public');
        }

        $artikel->update($validated);

        return redirect()->route('admin.artikel.index')
                        ->with('success', 'Artikel berhasil diupdate');
    }

    public function destroy(Artikel $artikel)
    {
        if ($artikel->gambar) {
            Storage::disk('public')->delete($artikel->gambar);
        }
        
        $artikel->delete();

        return redirect()->route('admin.artikel.index')
                        ->with('success', 'Artikel berhasil dihapus');
    }

    // Frontend methods
    public function frontendIndex()
    {
        $artikel = Artikel::latest()->paginate(9);
        return view('frontend.artikel', compact('artikel'));
    }

    public function frontendShow(Artikel $artikel)
    {
        return view('frontend.artikel-detail', compact('artikel'));
    }
}