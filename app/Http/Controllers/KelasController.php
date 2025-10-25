<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Jurusan;
use App\Models\JenisKelas;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\KelasSiswa;
use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\UpdateKelasRequest;
use App\Http\Requests\AddSiswaToKelasRequest;
use App\Http\Requests\RemoveSiswaFromKelasRequest;
use App\Http\Requests\MassAssignSiswaToKelasRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\KelasResource;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kelas::with(['sekolah:id_sekolah,nama_sekolah', 'jurusan:id_jurusan,nama_jurusan', 'jenisKelas:id_jenis_kelas,nama_jenis_kelas', 'waliKelas:id_guru,nama_guru'])
                     ->withSiswaCount();

        // Filter by sekolah
        if ($request->has('sekolah_id') && $request->sekolah_id) {
            $query->bySekolah($request->sekolah_id);
        }

        // Filter by jurusan
        if ($request->has('jurusan_id') && $request->jurusan_id) {
            $query->byJurusan($request->jurusan_id);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kelas', 'like', "%{$search}%")
                  ->orWhereHas('jurusan', function($jurusanQuery) use ($search) {
                      $jurusanQuery->where('nama_jurusan', 'like', "%{$search}%");
                  })
                  ->orWhereHas('waliKelas', function($guruQuery) use ($search) {
                      $guruQuery->where('nama_guru', 'like', "%{$search}%");
                  });
            });
        }

        $kelass = $query->select('id_kelas', 'nama_kelas', 'id_sekolah', 'id_jurusan', 'id_jenis_kelas', 'wali_kelas')
                       ->orderBy('nama_kelas')->paginate(10);
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $jurusans = Jurusan::select('id_jurusan', 'nama_jurusan')->get();

        return KelasResource::collection($kelass);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $jurusans = Jurusan::select('id_jurusan', 'nama_jurusan')->get();
        $jenisKelass = JenisKelas::select('id_jenis_kelas', 'nama_jenis_kelas')->get();
        $gurus = Guru::select('id_guru', 'nama_guru')->get();

        return view('admin.kelas.create', compact('sekolahs', 'jurusans', 'jenisKelass', 'gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKelasRequest $request)
    {
        $validated = $request->validated();

        try {
            // Check if nama_kelas is unique within the same sekolah and jurusan
            $exists = Kelas::where('id_sekolah', $request->id_sekolah)
                          ->where('id_jurusan', $request->id_jurusan)
                          ->where('nama_kelas', $request->nama_kelas)
                          ->exists();

            if ($exists) {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Nama kelas sudah ada di jurusan yang sama.');
            }

            // Check if wali kelas is already assigned to another class
            if ($request->wali_kelas) {
                $waliExists = Kelas::where('wali_kelas', $request->wali_kelas)->exists();
                if ($waliExists) {
                    return redirect()->back()
                                   ->withInput()
                                   ->with('error', 'Guru sudah menjadi wali kelas di kelas lain.');
                }
            }

            Kelas::create($validated);

            return redirect()->route('kelas.index')
                           ->with('success', 'Kelas berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan kelas: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        $kelas->load([
            'sekolah:id_sekolah,nama_sekolah',
            'jurusan:id_jurusan,nama_jurusan',
            'jenisKelas:id_jenis_kelas,nama_jenis_kelas',
            'waliKelas:id_guru,nama_guru',
            'siswa:id_siswa,nama_siswa,nisn',
            'kelasSiswa'
        ]);
        
        return new KelasResource($kelas);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $jurusans = Jurusan::select('id_jurusan', 'nama_jurusan')->get();
        $jenisKelass = JenisKelas::select('id_jenis_kelas', 'nama_jenis_kelas')->get();
        $gurus = Guru::select('id_guru', 'nama_guru')->get();

        return view('admin.kelas.edit', compact('kelas', 'sekolahs', 'jurusans', 'jenisKelass', 'gurus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKelasRequest $request, Kelas $kelas)
    {
        $validated = $request->validated();

        try {
            // Check if nama_kelas is unique within the same sekolah and jurusan (except current kelas)
            $exists = Kelas::where('id_sekolah', $request->id_sekolah)
                          ->where('id_jurusan', $request->id_jurusan)
                          ->where('nama_kelas', $request->nama_kelas)
                          ->where('id_kelas', '!=', $kelas->id_kelas)
                          ->exists();

            if ($exists) {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Nama kelas sudah ada di jurusan yang sama.');
            }

            // Check if wali kelas is already assigned to another class (except current kelas)
            if ($request->wali_kelas && $request->wali_kelas != $kelas->wali_kelas) {
                $waliExists = Kelas::where('wali_kelas', $request->wali_kelas)
                                  ->where('id_kelas', '!=', $kelas->id_kelas)
                                  ->exists();
                if ($waliExists) {
                    return redirect()->back()
                                   ->withInput()
                                   ->with('error', 'Guru sudah menjadi wali kelas di kelas lain.');
                }
            }

            $kelas->update($validated);

            return redirect()->route('kelas.index')
                           ->with('success', 'Kelas berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui kelas: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        try {
            // Check if kelas has students
            if ($kelas->siswa()->count() > 0) {
                return redirect()->back()
                               ->with('error', 'Tidak dapat menghapus kelas yang masih memiliki siswa.');
            }

            $kelas->delete();

            return redirect()->route('kelas.index')
                           ->with('success', 'Kelas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menghapus kelas: ' . $e->getMessage());
        }
    }

    /**
     * Add siswa to kelas
     */
    public function addSiswa(AddSiswaToKelasRequest $request, Kelas $kelas)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            foreach ($request->siswa_ids as $siswaId) {
                // Check if assignment already exists
                $exists = KelasSiswa::where('id_siswa', $siswaId)
                                   ->where('id_kelas', $kelas->id_kelas)
                                   ->where('tahun_ajaran', $request->tahun_ajaran)
                                   ->where('semester', $request->semester)
                                   ->exists();

                if (!$exists) {
                    KelasSiswa::create([
                        'id_siswa' => $siswaId,
                        'id_kelas' => $kelas->id_kelas,
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'semester' => $request->semester
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('kelas.show', $kelas)
                           ->with('success', 'Siswa berhasil ditambahkan ke kelas.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                           ->with('error', 'Gagal menambahkan siswa ke kelas: ' . $e->getMessage());
        }
    }

    /**
     * Remove siswa from kelas
     */
    public function removeSiswa(RemoveSiswaFromKelasRequest $request, Kelas $kelas)
    {
        $validated = $request->validated();

        try {
            KelasSiswa::whereIn('id_kelas_siswa', $request->kelas_siswa_ids)
                      ->where('id_kelas', $kelas->id_kelas)
                      ->delete();

            return redirect()->route('kelas.show', $kelas)
                           ->with('success', 'Siswa berhasil dikeluarkan dari kelas.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal mengeluarkan siswa dari kelas: ' . $e->getMessage());
        }
    }

    /**
     * Get kelas by sekolah for API/AJAX
     */
    public function getBySekolah($idSekolah)
    {
        $kelass = Kelas::bySekolah($idSekolah)
                      ->with('jurusan:id_jurusan,nama_jurusan', 'jenisKelas:id_jenis_kelas,nama_jenis_kelas')
                      ->select('id_kelas', 'nama_kelas', 'id_jurusan', 'id_jenis_kelas')
                      ->orderBy('nama_kelas')
                      ->get();

        return KelasResource::collection($kelass);
    }

    /**
     * Get kelas by jurusan for API/AJAX
     */
    public function getByJurusan($idJurusan)
    {
        $kelass = Kelas::byJurusan($idJurusan)
                      ->with('jenisKelas:id_jenis_kelas,nama_jenis_kelas')
                      ->select('id_kelas', 'nama_kelas', 'id_jenis_kelas')
                      ->orderBy('nama_kelas')
                      ->get();

        return KelasResource::collection($kelass);
    }

    /**
     * Get available siswa for kelas assignment
     */
    public function getAvailableSiswa(Request $request, Kelas $kelas)
    {
        $query = Siswa::bySekolah($kelas->id_sekolah);

        // Exclude siswa already in this kelas for the specified period
        if ($request->has('tahun_ajaran') && $request->has('semester')) {
            $query->whereDoesntHave('kelasSiswa', function($q) use ($kelas, $request) {
                $q->where('id_kelas', $kelas->id_kelas)
                  ->where('tahun_ajaran', $request->tahun_ajaran)
                  ->where('semester', $request->semester);
            });
        }

        $siswas = $query->select('id_siswa', 'nama_siswa', 'nisn')
                       ->orderBy('nama_siswa')
                       ->get();

        return response()->json($siswas);
    }

    /**
     * Get kelas statistics
     */
    public function getStatistics($idSekolah = null)
    {
        $query = Kelas::query();
        
        if ($idSekolah) {
            $query->bySekolah($idSekolah);
        }

        $stats = [
            'total_kelas' => $query->count(),
            'kelas_with_wali' => $query->whereNotNull('wali_kelas')->count(),
            'total_siswa' => $query->withCount('siswa')->get()->sum('siswa_count'),
            'by_jurusan' => $query->with('jurusan:id_jurusan,nama_jurusan')
                                 ->get()
                                 ->groupBy('jurusan.nama_jurusan')
                                 ->map->count(),
            'avg_siswa_per_kelas' => $query->withCount('siswa')->get()->avg('siswa_count')
        ];

        return $stats;
    }

    /**
     * Mass assign siswa to multiple kelas
     */
    public function massAssign(MassAssignSiswaToKelasRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            foreach ($request->assignments as $assignment) {
                // Check if assignment already exists
                $exists = KelasSiswa::where('id_siswa', $assignment['id_siswa'])
                                   ->where('id_kelas', $assignment['id_kelas'])
                                   ->where('tahun_ajaran', $request->tahun_ajaran)
                                   ->where('semester', $request->semester)
                                   ->exists();

                if (!$exists) {
                    KelasSiswa::create([
                        'id_siswa' => $assignment['id_siswa'],
                        'id_kelas' => $assignment['id_kelas'],
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'semester' => $request->semester
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()
                           ->with('success', 'Penugasan siswa ke kelas berhasil.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                           ->with('error', 'Gagal melakukan penugasan massal: ' . $e->getMessage());
        }
    }
}