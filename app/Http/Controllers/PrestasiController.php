<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Http\Requests\StorePrestasiRequest;
use App\Http\Requests\UpdatePrestasiRequest;
use App\Http\Resources\PrestasiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startTime = microtime(true);

        // Parameter pagination dan filter
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $sekolahId = $request->input('sekolah_id', '');

        // Query dasar
        $query = Prestasi::query()
            ->with(['sekolah:id_sekolah,nama_sekolah'])
            ->select(['id_prestasi', 'judul', 'tanggal', 'id_sekolah']);

        if ($sekolahId) {
            $query->where('id_sekolah', $sekolahId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // ✅ Jika request dari DataTables AJAX (admin table)
        if ($request->ajax() && !$request->expectsJson()) {
            return datatables()->of($query)->make(true);
        }

        // ✅ Jika request dari API (expects JSON)
        if ($request->expectsJson() || $request->ajax()) {
            $prestasis = $query->paginate($limit);
            
            return response()->json([
                'data' => $prestasis->items(),
                'meta' => [
                    'current_page' => $prestasis->currentPage(),
                    'last_page' => $prestasis->lastPage(),
                    'total' => $prestasis->total(),
                    'from' => $prestasis->firstItem(),
                    'to' => $prestasis->lastItem(),
                    'per_page' => $prestasis->perPage(),
                    'links' => $prestasis->linkCollection()->toArray(),
                ]
            ]);
        }

        // ✅ Jika request dari Blade biasa (admin/prestasi)
        $prestasis = $query->paginate($limit);
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();

        $executionTime = (microtime(true) - $startTime) * 1000;
        Log::info("PrestasiController@index executed in {$executionTime}ms");

        return view('admin.prestasi.index', compact('prestasis', 'sekolahs', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $tingkats = ['Sekolah', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'];
        $peringkats = ['Juara 1', 'Juara 2', 'Juara 3', 'Harapan 1', 'Harapan 2', 'Harapan 3', 'Finalis', 'Peserta'];

        return view('admin.prestasi.create', compact('sekolahs', 'tingkats', 'peringkats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrestasiRequest $request)
    {
        $validated = $request->validated();

        try {
            // Handle image upload
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
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
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $tingkats = ['Sekolah', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'];
        $peringkats = ['Juara 1', 'Juara 2', 'Juara 3', 'Harapan 1', 'Harapan 2', 'Harapan 3', 'Finalis', 'Peserta'];

        return view('admin.prestasi.edit', compact('prestasi', 'sekolahs', 'tingkats', 'peringkats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrestasiRequest $request, Prestasi $prestasi)
    {
        $validated = $request->validated();

        try {
            // Handle image upload
            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($prestasi->gambar && file_exists(public_path('photos/' . $prestasi->gambar))) {
                    unlink(public_path('photos/' . $prestasi->gambar));
                }

                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
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
        $query = Prestasi::with(['sekolah:id_sekolah,nama_sekolah']);

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

        $prestasis = $query->select('id_prestasi', 'judul', 'tanggal', 'id_sekolah')
                         ->orderBy('tanggal', 'desc')->paginate(12);
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();

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
        return Prestasi::with(['sekolah:id_sekolah,nama_sekolah'])
                      ->orderBy('tanggal', 'desc')
                      ->limit($limit)
                      ->select('id_prestasi', 'judul', 'tanggal', 'id_sekolah')
                      ->get();
    }

    /**
     * Get highlighted prestasi (high level achievements)
     */
    public function getHighlighted($limit = 3)
    {
        return Prestasi::with(['sekolah:id_sekolah,nama_sekolah'])
                      ->whereIn('tingkat', ['Nasional', 'Internasional'])
                      ->whereIn('peringkat', ['Juara 1', 'Juara 2', 'Juara 3'])
                      ->orderBy('tanggal', 'desc')
                      ->limit($limit)
                      ->select('id_prestasi', 'judul', 'tanggal', 'id_sekolah')
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
                            ->select('id_prestasi', 'judul', 'tanggal')
                            ->get();

        return response()->json($prestasis);
    }

    public function home()
    {
        $highlightPrestasis = Prestasi::orderBy('tanggal', 'desc')->take(3)->select('id_prestasi', 'judul', 'tanggal')->get();
        return view('frontend.home', compact('highlightPrestasis'));
    }

}