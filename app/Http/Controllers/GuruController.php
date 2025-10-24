<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Sekolah;
use App\Models\Akun;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Http\Resources\GuruResource;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Guru::with(['sekolah', 'akun', 'mapel']);

        // Filter by sekolah
        if ($request->filled('sekolah_id')) {
            $query->bySekolah($request->sekolah_id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('no_telp', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'nama_guru');
        $sortDirection = $request->get('sort_direction', 'asc');
        
        $allowedSorts = ['nama_guru', 'email', 'created_at', 'nip'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $gurus = $query->paginate(15)->withQueryString();
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $search = $request->search;

        return view('admin.guru.index', compact('gurus', 'sekolahs', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $mapels = Mapel::all();
        return view('admin.guru.create', compact('sekolahs', 'mapels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'nama_guru' => 'required|string|max:255',
            'nip' => 'nullable|string|max:20|unique:tb_guru,nip',
            'email' => 'required|email|max:255|unique:tb_guru,email',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'create_account' => 'boolean',
            'username' => 'required_if:create_account,true|string|min:3|max:50|unique:tb_akun,username',
            'password' => 'required_if:create_account,true|string|min:8|confirmed',
            'mapel' => 'nullable|array',
            'mapel.*' => 'exists:tb_mapel,id_mapel'
        ]);

        DB::beginTransaction();

        try {
            // Handle photo upload
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . Str::slug($request->nama_guru) . '.' . $file->getClientOriginalExtension();
                
                // Store in storage/app/public/photos
                $file->storeAs('photos', $filename, 'public');
                $validated['foto'] = $filename;
            }

            // Create guru
            $guru = Guru::create($validated);

            // Attach mapel
            if ($request->has('mapel')) {
                $guru->mapel()->attach($request->mapel);
            }

            // Create account if requested
            if ($request->boolean('create_account')) {
                Akun::create([
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'role' => 'guru',
                    'id_guru' => $guru->id_guru,
                    'id_siswa' => null
                ]);
            }

            DB::commit();

            return redirect()->route('guru.index')
                           ->with('success', 'Guru berhasil ditambahkan.');
                           
        } catch (\Exception $e) {
            DB::rollback();
            
            // Delete uploaded file if exists
            if (isset($validated['foto'])) {
                Storage::disk('public')->delete('photos/' . $validated['foto']);
            }

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan guru: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        $guru->load(['sekolah', 'akun', 'mapel', 'kelasWali.siswa']);
        
        return view('admin.guru.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        $sekolahs = Sekolah::select('id_sekolah', 'nama_sekolah')->get();
        $mapels = Mapel::all();
        $guru->load('akun', 'mapel');
        
        return view('admin.guru.edit', compact('guru', 'sekolahs', 'mapels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'nama_guru' => 'required|string|max:255',
            'nip' => ['nullable', 'string', 'max:20', Rule::unique('tb_guru', 'nip')->ignore($guru->id_guru, 'id_guru')],
            'email' => ['required', 'email', 'max:255', Rule::unique('tb_guru', 'email')->ignore($guru->id_guru, 'id_guru')],
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'mapel' => 'nullable|array',
            'mapel.*' => 'exists:tb_mapel,id_mapel'
        ]);

        DB::beginTransaction();

        try {
            $oldFoto = $guru->foto;

            // Handle photo upload
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . Str::slug($request->nama_guru) . '.' . $file->getClientOriginalExtension();
                
                // Store new photo
                $file->storeAs('photos', $filename, 'public');
                $validated['foto'] = $filename;
                
                // Delete old photo
                if ($oldFoto) {
                    Storage::disk('public')->delete('photos/' . $oldFoto);
                }
            }

            $guru->update($validated);

            // Sync mapel
            if ($request->has('mapel')) {
                $guru->mapel()->sync($request->mapel);
            } else {
                $guru->mapel()->detach();
            }
            DB::commit();

            return redirect()->route('guru.index')
                           ->with('success', 'Data guru berhasil diperbarui.');
                           
        } catch (\Exception $e) {
            DB::rollback();
            
            // Delete new uploaded file if exists
            if (isset($validated['foto'])) {
                Storage::disk('public')->delete('photos/' . $validated['foto']);
            }

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui data guru: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        DB::beginTransaction();

        try {
            // Store foto name before deletion
            $fotoName = $guru->foto;

            // Delete associated account
            if ($guru->akun) {
                $guru->akun->delete();
            }

            // Delete guru record
            $guru->delete();

            // Delete photo file if exists
            if ($fotoName) {
                Storage::disk('public')->delete('photos/' . $fotoName);
            }

            DB::commit();

            return redirect()->route('guru.index')
                           ->with('success', 'Guru berhasil dihapus.');
                           
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                           ->with('error', 'Gagal menghapus guru: ' . $e->getMessage());
        }
    }

    /**
     * Create account for existing guru
     */
    public function createAccount(Request $request, Guru $guru)
    {
        // Check if account already exists
        if ($guru->akun) {
            return redirect()->back()
                           ->with('error', 'Guru sudah memiliki akun.');
        }

        $validated = $request->validate([
            'username' => 'required|string|min:3|max:50|unique:tb_akun,username',
            'password' => 'required|string|min:8|confirmed'
        ]);

        try {
            Akun::create([
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'role' => 'guru',
                'id_guru' => $guru->id_guru,
                'id_siswa' => null
            ]);

            return redirect()->route('guru.show', $guru)
                           ->with('success', 'Akun guru berhasil dibuat.');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal membuat akun: ' . $e->getMessage());
        }
    }

    /**
     * Update account credentials
     */
    public function updateAccount(Request $request, Guru $guru)
    {
        if (!$guru->akun) {
            return redirect()->back()
                           ->with('error', 'Guru tidak memiliki akun.');
        }

        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:50', Rule::unique('tb_akun', 'username')->ignore($guru->akun->id_akun, 'id_akun')],
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        try {
            $updateData = ['username' => $validated['username']];
            
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            $guru->akun->update($updateData);

            return redirect()->route('guru.show', $guru)
                           ->with('success', 'Akun guru berhasil diperbarui.');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui akun: ' . $e->getMessage());
        }
    }

    /**
     * Delete account for guru
     */
    public function deleteAccount(Guru $guru)
    {
        if (!$guru->akun) {
            return redirect()->back()
                           ->with('error', 'Guru tidak memiliki akun.');
        }

        try {
            $guru->akun->delete();

            return redirect()->route('guru.show', $guru)
                           ->with('success', 'Akun guru berhasil dihapus.');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menghapus akun: ' . $e->getMessage());
        }
    }

    /**
     * Frontend - Display guru profiles
     */
    public function profilPengajar(Request $request)
    {
        $query = Guru::with(['sekolah', 'mapel']);

        // Filter by sekolah
        if ($request->filled('sekolah_id')) {
            $query->bySekolah($request->sekolah_id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhereHas('mapel', function($mapelQuery) use ($search) {
                      $mapelQuery->where('nama_mapel', 'like', "%{$search}%");
                  });
            });
        }

        $gurus = $query->orderBy('nama_guru')
                      ->paginate(12);
        return view('frontend.profilPengajar', compact('gurus'));
    }

    /**
     * Get guru by sekolah for API/AJAX
     */
    public function getBySekolah($idSekolah)
    {
        try {
            // Validate sekolah exists
            if (!Sekolah::where('id_sekolah', $idSekolah)->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sekolah tidak ditemukan'
                ], 404);
            }

            $gurus = Guru::bySekolah($idSekolah)
                         ->select('id_guru', 'nama_guru', 'email', 'no_telp')
                         ->orderBy('nama_guru')
                         ->get();

            return GuruResource::collection($gurus);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data guru'
            ], 500);
        }
    }

    /**
     * Search guru for API/AJAX
     */
    public function search(Request $request)
    {
        $query = Guru::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $gurus = $query->orderBy('nama_guru')
                       ->paginate(10); // Paginate for API

        return GuruResource::collection($gurus);
    }

    /**
     * Bulk actions for multiple gurus
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'guru_ids' => 'required|array',
            'guru_ids.*' => 'exists:tb_guru,id_guru'
        ]);

        DB::beginTransaction();

        try {
            $count = 0;
            
            switch ($validated['action']) {
                case 'delete':
                    $gurus = Guru::whereIn('id_guru', $validated['guru_ids'])->get();
                    foreach ($gurus as $guru) {
                        // Delete associated account and photo
                        if ($guru->akun) {
                            $guru->akun->delete();
                        }
                        if ($guru->foto) {
                            Storage::disk('public')->delete('photos/' . $guru->foto);
                        }
                        $guru->delete();
                        $count++;
                    }
                    $message = "{$count} guru berhasil dihapus.";
                    break;
                    
                default:
                    return redirect()->back()
                                   ->with('error', 'Aksi tidak valid.');
            }

            DB::commit();

            return redirect()->route('guru.index')
                           ->with('success', $message);
                           
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                           ->with('error', 'Gagal melakukan aksi: ' . $e->getMessage());
        }
    }
}