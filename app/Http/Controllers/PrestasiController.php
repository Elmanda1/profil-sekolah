<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Prestasi::with([ 'sekolah']);

        // Filter by sekolah
        if ($request->has('sekolah_id') && $request->sekolah_id) {
            $query->where('id_sekolah', $request->sekolah_id);
        }

        // Filter by tingkat
        if ($request->has('tingkat') && $request->tingkat) {
            $query->where('tingkat', $request->tingkat);
        }

        // Filter by peringkat
        if ($request->has('peringkat') && $request->peringkat) {
            $query->where('peringkat', $request->peringkat);
        }

        // Filter by date range
        if ($request->has('dari_tanggal') && $request->dari_tanggal) {
            $query->where('tanggal', '>=', $request->dari_tanggal);
        }
        if ($request->has('sampai_tanggal') && $request->sampai_tanggal) {
            $query->where('tanggal', '<=', $request->sampai_tanggal);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lomba', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $prestasis = $query->orderBy('tanggal', 'desc')->paginate(10);
        $sekolahs = Sekolah::all();

        // Data for filters
        $tingkats = ['Sekolah', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'];
        $peringkats = ['Juara 1', 'Juara 2', 'Juara 3', 'Harapan 1', 'Harapan 2', 'Harapan 3', 'Finalis', 'Peserta'];

        return view('admin.prestasi.index', compact('prestasis', 'sekolahs', 'tingkats', 'peringkats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolahs = Sekolah::all();
        $tingkats = ['Sekolah', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'];
        $peringkats = ['Juara 1', 'Juara 2', 'Juara 3', 'Harapan 1', 'Harapan 2', 'Harapan 3', 'Finalis', 'Peserta'];

        return view('admin.prestasi.create', compact('sekolahs', 'tingkats', 'peringkats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'nama_lomba' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'tingkat' => 'required|in:Sekolah,Kabupaten/Kota,Provinsi,Nasional,Internasional',
            'peringkat' => 'required|in:Juara 1,Juara 2,Juara 3,Harapan 1,Harapan 2,Harapan 3,Finalis,Peserta',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($request->nama_lomba) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('photos'), $filename);
                $validated['gambar'] = $filename;
            }

            Prestasi::create($validated);

            return redirect()->route('prestasi.index')
                           ->with('success', 'Prestasi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan prestasi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestasi $prestasi)
    {
        $prestasi->load(['sekolah']);
        return view('admin.prestasi.show', compact('prestasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestasi $prestasi)
    {
        $sekolahs = Sekolah::all();
        $tingkats = ['Sekolah', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'];
        $peringkats = ['Juara 1', 'Juara 2', 'Juara 3', 'Harapan 1', 'Harapan 2', 'Harapan 3', 'Finalis', 'Peserta'];

        return view('admin.prestasi.edit', compact('prestasi', 'sekolahs', 'tingkats', 'peringkats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prestasi $prestasi)
    {
        $validated = $request->validate([
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'nama_lomba' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'tingkat' => 'required|in:Sekolah,Kabupaten/Kota,Provinsi,Nasional,Internasional',
            'peringkat' => 'required|in:Juara 1,Juara 2,Juara 3,Harapan 1,Harapan 2,Harapan 3,Finalis,Peserta',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($prestasi->gambar && file_exists(public_path('photos/' . $prestasi->gambar))) {
                    unlink(public_path('photos/' . $prestasi->gambar));
                }

                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($request->nama_lomba) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('photos'), $filename);
                $validated['gambar'] = $filename;
            }

            $prestasi->update($validated);

            return redirect()->route('prestasi.index')
                           ->with('success', 'Prestasi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui prestasi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestasi $prestasi)
    {
        try {
            // Delete image file if exists
            if ($prestasi->gambar && file_exists(public_path('photos/' . $prestasi->gambar))) {
                unlink(public_path('photos/' . $prestasi->gambar));
            }

            $prestasi->delete();

            return redirect()->route('prestasi.index')
                           ->with('success', 'Prestasi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menghapus prestasi: ' . $e->getMessage());
        }
    }

    /**
     * Frontend - Display prestasi list
     */
    public function prestasi(Request $request)
    {
        $query = Prestasi::with(['sekolah']);

        // Filter by sekolah
        if ($request->has('sekolah_id') && $request->sekolah_id) {
            $query->where('id_sekolah', $request->sekolah_id);
        }

        // Filter by tingkat
        if ($request->has('tingkat') && $request->tingkat) {
            $query->where('tingkat', $request->tingkat);
        }

        // Filter by peringkat
        if ($request->has('peringkat') && $request->peringkat) {
            $query->where('peringkat', $request->peringkat);
        }

        // Filter by year
        if ($request->has('tahun') && $request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lomba', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ;
            });
        }

        $prestasis = $query->orderBy('tanggal', 'desc')->paginate(12);
        $sekolahs = Sekolah::all();

        // Data for filters
        $tingkats = ['Sekolah', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'];
        $peringkats = ['Juara 1', 'Juara 2', 'Juara 3', 'Harapan 1', 'Harapan 2', 'Harapan 3', 'Finalis', 'Peserta'];
        
        // Get available years
        $tahuns = Prestasi::selectRaw('YEAR(tanggal) as tahun')
                         ->distinct()
                         ->orderBy('tahun', 'desc')
                         ->pluck('tahun');

        return view('frontend.prestasi', compact('prestasis', 'sekolahs', 'tingkats', 'peringkats', 'tahuns'));
    }

    /**
     * Get recent prestasi for homepage
     */
    public function getRecent($limit = 6)
    {
        return Prestasi::with(['sekolah'])
                      ->orderBy('tanggal', 'desc')
                      ->limit($limit)
                      ->get();
    }

    /**
     * Get highlighted prestasi (high level achievements)
     */
    public function getHighlighted($limit = 3)
    {
        return Prestasi::with(['sekolah'])
                      ->whereIn('tingkat', ['Nasional', 'Internasional'])
                      ->whereIn('peringkat', ['Juara 1', 'Juara 2', 'Juara 3'])
                      ->orderBy('tanggal', 'desc')
                      ->limit($limit)
                      ->get();
    }

    /**
     * Get prestasi statistics
     */
    public function getStatistics($idSekolah = null)
    {
        $query = Prestasi::query();
        
        if ($idSekolah) {
            $query->where('id_sekolah', $idSekolah);
        }

        $stats = [
            'total' => $query->count(),
            'by_tingkat' => $query->groupBy('tingkat')
                                 ->selectRaw('tingkat, count(*) as jumlah')
                                 ->pluck('jumlah', 'tingkat'),
            'by_peringkat' => $query->groupBy('peringkat')
                                   ->selectRaw('peringkat, count(*) as jumlah')
                                   ->pluck('jumlah', 'peringkat'),
            'this_year' => $query->whereYear('tanggal', date('Y'))->count(),
            'last_month' => $query->where('tanggal', '>=', now()->subMonth())->count()
        ];

        return $stats;
    }

    /**
     * Get prestasi by sekolah for API/AJAX
     */
    public function getBySekolah($idSekolah)
    {
        $prestasis = Prestasi::where('id_sekolah', $idSekolah)
                            ->orderBy('tanggal', 'desc')
                            ->get();

        return response()->json($prestasis);
    }
}