<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Sekolah;
use App\Models\Kelas;
use App\Models\Akun;
use App\Models\KelasSiswa;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Http\Resources\SiswaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     * Support: DataTables, API, or Blade view
     */
    public function index(Request $request)
    {
        $startTime = microtime(true);

        // Parameter pagination dan filter
        $limit = $request->input('limit', 100);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $sekolahId = $request->input('sekolah_id', '');
        $kelasId = $request->input('kelas_id', '');

        // Query dasar
        $query = Siswa::query()
            ->select(['id_siswa', 'nama_siswa', 'nisn', 'jenis_kelamin', 'tanggal_lahir', 'alamat', 'id_sekolah']);

        if ($sekolahId) {
            $query->where('id_sekolah', $sekolahId);
        }

        if ($kelasId) {
            $query->whereHas('kelasSiswa', fn($q) => $q->where('id_kelas', $kelasId));
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        // ✅ Jika request dari DataTables AJAX (admin table)
        if ($request->ajax() && !$request->expectsJson()) {
            return datatables()->of($query)->make(true);
        }

        // ✅ Jika request dari API (expects JSON)
        if ($request->expectsJson()) {
            $siswas = $query->paginate($limit);
            return response()->json([
                'data' => $siswas->items(),
                'current_page' => $siswas->currentPage(),
                'last_page' => $siswas->lastPage(),
                'total' => $siswas->total(),
            ]);
        }

        // ✅ Jika request dari Blade biasa (admin/siswa)
        $siswas = $query->paginate($limit);
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $kelass = Kelas::with('jurusan:id_jurusan,nama_jurusan', 'jenisKelas:id_jenis_kelas,nama_jenis_kelas')
                       ->select('id_kelas', 'nama_kelas', 'id_jurusan', 'id_jenis_kelas')
                       ->get();

        $executionTime = (microtime(true) - $startTime) * 1000;
        Log::info("SiswaController@index executed in {$executionTime}ms");

        return view('admin.siswa.index', compact('siswas', 'sekolahs', 'kelass', 'search'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        $siswa->load([
            'sekolah:id_sekolah,nama_sekolah',
            'akun:id_akun,username,id_siswa',
            'kelas.jurusan:id_jurusan,nama_jurusan',
            'kelas.jenisKelas:id_jenis_kelas,nama_jenis_kelas',
            'krs.mapel:id_mapel,nama_mapel'
        ]);

        if (request()->expectsJson()) {
            return new SiswaResource($siswa);
        }

        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiswaRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Handle photo upload
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . Str::slug($request->nama_siswa) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('photos'), $filename);
                $validated['foto'] = $filename;
            }

            // Create siswa
            $siswa = Siswa::create($validated);

            // Assign to class
            if ($request->id_kelas) {
                KelasSiswa::create([
                    'id_siswa' => $siswa->id_siswa,
                    'id_kelas' => $request->id_kelas,
                    'tahun_ajaran' => $request->tahun_ajaran,
                    'semester' => $request->semester
                ]);
            }

            // Create account if requested
            if ($request->create_account) {
                Akun::create([
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'role' => 'siswa',
                    'id_guru' => null,
                    'id_siswa' => $siswa->id_siswa
                ]);
            }

            DB::commit();
            Cache::tags(['siswa'])->flush();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Siswa berhasil ditambahkan.',
                    'data' => new SiswaResource($siswa)
                ], 201);
            }

            return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan siswa: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan siswa: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiswaRequest $request, Siswa $siswa)
    {
        $validated = $request->validated();

        try {
            // Handle photo upload
            if ($request->hasFile('foto')) {
                if ($siswa->foto && file_exists(public_path('photos/' . $siswa->foto))) {
                    unlink(public_path('photos/' . $siswa->foto));
                }

                $file = $request->file('foto');
                $filename = time() . '_' . Str::slug($request->nama_siswa) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('photos'), $filename);
                $validated['foto'] = $filename;
            }

            $siswa->update($validated);
            Cache::tags(['siswa'])->flush();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data siswa berhasil diperbarui.',
                    'data' => new SiswaResource($siswa)
                ]);
            }

            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui data siswa: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data siswa: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        DB::beginTransaction();

        try {
            if ($siswa->akun) {
                $siswa->akun->delete();
            }

            if ($siswa->foto && file_exists(public_path('photos/' . $siswa->foto))) {
                unlink(public_path('photos/' . $siswa->foto));
            }

            $siswa->delete();
            DB::commit();
            Cache::tags(['siswa'])->flush();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Siswa berhasil dihapus.'
                ]);
            }

            return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus siswa: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus siswa: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $kelass = Kelas::with('jurusan:id_jurusan,nama_jurusan', 'jenisKelas:id_jenis_kelas,nama_jenis_kelas')
                       ->select('id_kelas', 'nama_kelas', 'id_jurusan', 'id_jenis_kelas')
                       ->get();

        return view('admin.siswa.create', compact('sekolahs', 'kelass'));
    }

    public function edit(Siswa $siswa)
    {
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $kelass = Kelas::with('jurusan:id_jurusan,nama_jurusan', 'jenisKelas:id_jenis_kelas,nama_jenis_kelas')
                       ->select('id_kelas', 'nama_kelas', 'id_jurusan', 'id_jenis_kelas')
                       ->get();
        $siswa->load('akun:id_akun,username,id_siswa', 'kelasSiswa');

        return view('admin.siswa.edit', compact('siswa', 'sekolahs', 'kelass'));
    }
}
