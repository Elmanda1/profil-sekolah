<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Jurusan::with('sekolah');

        // Filter by sekolah
        if ($request->has('sekolah_id') && $request->sekolah_id) {
            $query->where('id_sekolah', $request->sekolah_id);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_jurusan', 'like', "%{$search}%")
                  ->orWhere('kode_jurusan', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $jurusans = $query->orderBy('nama_jurusan')->paginate(10);
        $sekolahs = Sekolah::all();

        return view('admin.jurusan.index', compact('jurusans', 'sekolahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolahs = Sekolah::all();
        return view('admin.jurusan.create', compact('sekolahs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'nama_jurusan' => 'required|string|max:255',
            'kode_jurusan' => 'required|string|max:10|unique:tb_jurusan,kode_jurusan',
            'deskripsi' => 'nullable|string'
        ]);

        try {
            Jurusan::create($validated);

            return redirect()->route('jurusan.index')
                           ->with('success', 'Jurusan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan jurusan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurusan $jurusan)
    {
        $jurusan->load(['sekolah', 'kelas.siswa', 'mapel']);
        
        return view('admin.jurusan.show', compact('jurusan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan)
    {
        $sekolahs = Sekolah::all();
        return view('admin.jurusan.edit', compact('jurusan', 'sekolahs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate([
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'nama_jurusan' => 'required|string|max:255',
            'kode_jurusan' => 'required|string|max:10|unique:tb_jurusan,kode_jurusan,' . $jurusan->id_jurusan . ',id_jurusan',
            'deskripsi' => 'nullable|string'
        ]);

        try {
            $jurusan->update($validated);

            return redirect()->route('jurusan.index')
                           ->with('success', 'Jurusan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui jurusan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan)
    {
        try {
            // Check if jurusan has related kelas
            if ($jurusan->kelas()->count() > 0) {
                return redirect()->back()
                               ->with('error', 'Tidak dapat menghapus jurusan yang masih memiliki kelas.');
            }

            $jurusan->delete();

            return redirect()->route('jurusan.index')
                           ->with('success', 'Jurusan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menghapus jurusan: ' . $e->getMessage());
        }
    }

    /**
     * Get jurusan by sekolah for API/AJAX
     */
    public function getBySekolah($idSekolah)
    {
        $jurusans = Jurusan::where('id_sekolah', $idSekolah)
                          ->select('id_jurusan', 'nama_jurusan', 'kode_jurusan')
                          ->orderBy('nama_jurusan')
                          ->get();

        return response()->json($jurusans);
    }

    /**
     * Get jurusan statistics
     */
    public function getStatistics($idSekolah = null)
    {
        $query = Jurusan::query();
        
        if ($idSekolah) {
            $query->where('id_sekolah', $idSekolah);
        }

        $stats = [
            'total_jurusan' => $query->count(),
            'jurusan_with_kelas' => $query->whereHas('kelas')->count(),
            'total_kelas' => $query->withCount('kelas')->get()->sum('kelas_count'),
            'total_siswa' => $query->withCount(['kelas' => function($q) {
                $q->withCount('siswa');
            }])->get()->sum('kelas_count')
        ];

        return $stats;
    }
}