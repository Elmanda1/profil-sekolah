<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Artikel::with('sekolah');

        // Filter by sekolah if provided
        if ($request->has('sekolah_id') && $request->sekolah_id) {
            $query->bySekolah($request->sekolah_id);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->has('dari_tanggal') && $request->dari_tanggal) {
            $query->where('tanggal', '>=', $request->dari_tanggal);
        }
        if ($request->has('sampai_tanggal') && $request->sampai_tanggal) {
            $query->where('tanggal', '<=', $request->sampai_tanggal);
        }

        $artikels = $query->orderBy('tanggal', 'desc')->paginate(10);
        $sekolahs = Sekolah::all();

        return view('admin.artikel.index', compact('artikels', 'sekolahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolahs = Sekolah::all();
        return view('admin.artikel.create', compact('sekolahs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('photos'), $filename);
                $validated['gambar'] = $filename;
            }

            Artikel::create($validated);

            return redirect()->route('artikel.index')
                           ->with('success', 'Artikel berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan artikel: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Artikel $artikel)
    {
        $artikel->load('sekolah');
        return view('admin.artikel.show', compact('artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artikel $artikel)
    {
        $sekolahs = Sekolah::all();
        return view('admin.artikel.edit', compact('artikel', 'sekolahs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artikel $artikel)
    {
        $validated = $request->validate([
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($artikel->gambar && file_exists(public_path('photos/' . $artikel->gambar))) {
                    unlink(public_path('photos/' . $artikel->gambar));
                }

                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('photos'), $filename);
                $validated['gambar'] = $filename;
            }

            $artikel->update($validated);

            return redirect()->route('artikel.index')
                           ->with('success', 'Artikel berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui artikel: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $artikel)
    {
        try {
            // Delete image file if exists
            if ($artikel->gambar && file_exists(public_path('photos/' . $artikel->gambar))) {
                unlink(public_path('photos/' . $artikel->gambar));
            }

            $artikel->delete();

            return redirect()->route('artikel.index')
                           ->with('success', 'Artikel berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menghapus artikel: ' . $e->getMessage());
        }
    }

    /**
     * Get published articles for frontend
     */
    public function getPublished(Request $request)
    {
        $query = Artikel::published()->with('sekolah');

        if ($request->has('sekolah_id') && $request->sekolah_id) {
            $query->bySekolah($request->sekolah_id);
        }

        if ($request->has('limit')) {
            $query->recent($request->limit);
        }

        return $query->get();
    }

    /**
     * Get recent articles
     */
    public function getRecent($limit = 5)
    {
        return Artikel::published()
                     ->with('sekolah')
                     ->recent($limit)
                     ->get();
    }

    /**
     * Frontend article detail
     */
    public function detail($id)
    {
        $artikel = Artikel::with('sekolah')->findOrFail($id);
        
        // Get related articles
        $relatedArticles = Artikel::published()
                                 ->where('id_artikel', '!=', $id)
                                 ->bySekolah($artikel->id_sekolah)
                                 ->recent(3)
                                 ->get();

        return view('frontend.berita-detail', compact('artikel', 'relatedArticles'));
    }

    /**
     * Frontend articles listing
     */
    public function berita(Request $request)
    {
        $query = Artikel::published()->with('sekolah');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
            });
        }

        // Filter by sekolah
        if ($request->has('sekolah_id') && $request->sekolah_id) {
            $query->bySekolah($request->sekolah_id);
        }

        $artikels = $query->orderBy('tanggal', 'desc')->paginate(9);
        $sekolahs = Sekolah::all();

        return view('frontend.berita', compact('artikels', 'sekolahs'));
    }
}