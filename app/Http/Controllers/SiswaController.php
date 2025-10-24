<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Sekolah;
use App\Models\Kelas;
use App\Models\Akun;
use App\Models\KelasSiswa;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\SiswaResource; // ADDED

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Siswa::with(['sekolah:id_sekolah,nama_sekolah', 'akun:id_akun,username,id_siswa']);

        // Filter by sekolah
        if ($request->has('sekolah_id') && $request->sekolah_id) {
            $query->bySekolah($request->sekolah_id);
        }

        // Filter by kelas
        if ($request->has('kelas_id') && $request->kelas_id) {
            $query->byKelas($request->kelas_id);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_telp', 'like', "%{$search}%");
            });
        }

        $siswas = $query->select('id_siswa', 'nama_siswa', 'nisn', 'email', 'no_telp', 'id_sekolah')
                       ->orderBy('nama_siswa')
                       ->paginate(10);

        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $kelass = Kelas::with('jurusan:id_jurusan,nama_jurusan', 'jenisKelas:id_jenis_kelas,nama_jenis_kelas')
                       ->select('id_kelas', 'nama_kelas', 'id_jurusan', 'id_jenis_kelas')
                       ->get();
        $search = $request->search;

        return view('admin.siswa.index', compact('siswas', 'sekolahs', 'kelass', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $kelass = Kelas::with('jurusan:id_jurusan,nama_jurusan', 'jenisKelas:id_jenis_kelas,nama_jenis_kelas')
                       ->select('id_kelas', 'nama_kelas', 'id_jurusan', 'id_jenis_kelas')
                       ->get();

        return view('admin.siswa.create', compact('sekolahs', 'kelass'));
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
            KelasSiswa::create([
                'id_siswa' => $siswa->id_siswa,
                'id_kelas' => $request->id_kelas,
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester' => $request->semester
            ]);

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

            return redirect()->route('siswa.index')
                           ->with('success', 'Siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan siswa: ' . $e->getMessage());
        }
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

        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $kelass = Kelas::with('jurusan:id_jurusan,nama_jurusan', 'jenisKelas:id_jenis_kelas,nama_jenis_kelas')
                       ->select('id_kelas', 'nama_kelas', 'id_jurusan', 'id_jenis_kelas')
                       ->get();
        $siswa->load('akun:id_akun,username,id_siswa', 'kelasSiswa');

        return view('admin.siswa.edit', compact('siswa', 'sekolahs', 'kelass'));
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
                // Delete old photo if exists
                if ($siswa->foto && file_exists(public_path('photos/' . $siswa->foto))) {
                    unlink(public_path('photos/' . $siswa->foto));
                }

                $file = $request->file('foto');
                $filename = time() . '_' . Str::slug($request->nama_siswa) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('photos'), $filename);
                $validated['foto'] = $filename;
            }

            $siswa->update($validated);

            return redirect()->route('siswa.index')
                           ->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui data siswa: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        DB::beginTransaction();

        try {
            // Delete associated account
            if ($siswa->akun) {
                $siswa->akun->delete();
            }

            // Delete photo file if exists
            if ($siswa->foto && file_exists(public_path('photos/' . $siswa->foto))) {
                unlink(public_path('photos/' . $siswa->foto));
            }

            $siswa->delete();

            DB::commit();

            return redirect()->route('siswa.index')
                           ->with('success', 'Siswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                           ->with('error', 'Gagal menghapus siswa: ' . $e->getMessage());
        }
    }

    /**
     * Assign siswa to class
     */
    public function assignToClass(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'id_kelas' => 'required|exists:tb_kelas,id_kelas',
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:1,2'
        ]);

        try {
            // Check if assignment already exists
            $exists = KelasSiswa::where('id_siswa', $siswa->id_siswa)
                               ->where('id_kelas', $request->id_kelas)
                               ->where('tahun_ajaran', $request->tahun_ajaran)
                               ->where('semester', $request->semester)
                               ->exists();

            if ($exists) {
                return redirect()->back()
                               ->with('error', 'Siswa sudah terdaftar di kelas ini untuk tahun ajaran dan semester yang sama.');
            }

            KelasSiswa::create([
                'id_siswa' => $siswa->id_siswa,
                'id_kelas' => $request->id_kelas,
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester' => $request->semester
            ]);

            return redirect()->route('siswa.show', $siswa)
                           ->with('success', 'Siswa berhasil didaftarkan ke kelas.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal mendaftarkan siswa ke kelas: ' . $e->getMessage());
        }
    }

    /**
     * Remove siswa from class
     */
    public function removeFromClass(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'id_kelas_siswa' => 'required|exists:tb_kelas_siswa,id_kelas_siswa'
        ]);

        try {
            $kelasSiswa = KelasSiswa::findOrFail($request->id_kelas_siswa);

            // Verify that this kelas_siswa belongs to the current siswa
            if ($kelasSiswa->id_siswa != $siswa->id_siswa) {
                return redirect()->back()
                               ->with('error', 'Data tidak valid.');
            }

            $kelasSiswa->delete();

            return redirect()->route('siswa.show', $siswa)
                           ->with('success', 'Siswa berhasil dikeluarkan dari kelas.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal mengeluarkan siswa dari kelas: ' . $e->getMessage());
        }
    }

    /**
     * Create account for existing siswa
     */
    public function createAccount(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:tb_akun,username',
            'password' => 'required|string|min:8'
        ]);

        try {
            // Check if account already exists
            if ($siswa->akun) {
                return redirect()->back()
                               ->with('error', 'Siswa sudah memiliki akun.');
            }

            Akun::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'siswa',
                'id_guru' => null,
                'id_siswa' => $siswa->id_siswa
            ]);

            return redirect()->route('siswa.show', $siswa)
                           ->with('success', 'Akun siswa berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal membuat akun: ' . $e->getMessage());
        }
    }

    /**
     * Update account credentials
     */
    public function updateAccount(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:tb_akun,username,' . $siswa->akun->id_akun . ',id_akun',
            'password' => 'nullable|string|min:8'
        ]);

        try {
            $akun = $siswa->akun;

            if (!$akun) {
                return redirect()->back()
                               ->with('error', 'Siswa tidak memiliki akun.');
            }

            $updateData = ['username' => $request->username];

            if ($request->password) {
                $updateData['password'] = Hash::make($request->password);
            }

            $akun->update($updateData);

            return redirect()->route('siswa.show', $siswa)
                           ->with('success', 'Akun siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal memperbarui akun: ' . $e->getMessage());
        }
    }

    /**
     * Frontend - Display siswa profiles
     */
    public function profilSiswa(Request $request)
    {
        $query = Siswa::query();

        // Filter by sekolah
        if ($request->has('sekolah_id') && $request->sekolah_id) {
            $query->bySekolah($request->sekolah_id);
        }

        // Filter by kelas
        if ($request->has('kelas_id') && $request->kelas_id) {
            $query->byKelas($request->kelas_id);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $siswas = $query->select('id_siswa', 'nama_siswa', 'nisn', 'foto', 'id_sekolah')
                       ->orderBy('nama_siswa')
                       ->paginate(12);
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $kelass = Kelas::with('jurusan:id_jurusan,nama_jurusan', 'jenisKelas:id_jenis_kelas,nama_jenis_kelas')
                       ->select('id_kelas', 'nama_kelas', 'id_jurusan', 'id_jenis_kelas')
                       ->get();

        return view('frontend.profilSiswa', compact('siswas', 'sekolahs', 'kelass'));
    }

    /**
     * Get siswa by sekolah for API/AJAX
     */
    public function getBySekolah($idSekolah)
    {
        $siswas = Siswa::bySekolah($idSekolah)
                      ->select('id_siswa', 'nama_siswa', 'nisn')
                      ->orderBy('nama_siswa')
                      ->get();

        return response()->json($siswas);
    }

    /**
     * Get siswa by kelas for API/AJAX
     */
    public function getByKelas($idKelas)
    {
        $siswas = Siswa::byKelas($idKelas)
                      ->select('id_siswa', 'nama_siswa', 'nisn')
                      ->orderBy('nama_siswa')
                      ->get();

        return response()->json($siswas);
    }

    /**
     * Import siswa from Excel/CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'id_kelas' => 'required|exists:tb_kelas,id_kelas',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:1,2'
        ]);

        try {
            // Implementation would depend on your preferred Excel/CSV library
            // This is a placeholder for the import logic

            return redirect()->route('siswa.index')
                           ->with('success', 'Data siswa berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal mengimport data siswa: ' . $e->getMessage());
        }
    }

    /**
     * Export siswa to Excel/CSV
     */
    public function export(Request $request)
    {
        try {
            // Implementation would depend on your preferred Excel/CSV library
            // This is a placeholder for the export logic

            return response()->download(storage_path('app/exports/siswa.xlsx'));
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal mengexport data siswa: ' . $e->getMessage());
        }
    }
}