<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Sekolah;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Guru::with(['sekolah', 'akun', 'mapel']);

        // Filter by sekolah
        if ($request->has('sekolah_id') && $request->sekolah_id) {
            $query->bySekolah($request->sekolah_id);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_telp', 'like', "%{$search}%");
            });
        }

        $gurus = $query->orderBy('nama_guru')->paginate(10);
        $sekolahs = Sekolah::all();

        return view('admin.guru.index', compact('gurus', 'sekolahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolahs = Sekolah::all();
        return view('admin.guru.create', compact('sekolahs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'nama_guru' => 'required|string|max:255',
            'email' => 'required|email|unique:tb_guru,email',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'create_account' => 'boolean',
            'username' => 'required_if:create_account,1|string|unique:tb_akun,username',
            'password' => 'required_if:create_account,1|string|min:8'
        ]);

        try {
            // Handle photo upload
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . Str::slug($request->nama_guru) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('photos'), $filename);
                $validated['foto'] = $filename;
            }

            // Create guru
            $guru = Guru::create($validated);

            // Create account if requested
            if ($request->create_account) {
                Akun::create([
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'role' => 'guru',
                    'id_guru' => $guru->id_guru,
                    'id_siswa' => null
                ]);
            }

            return redirect()->route('guru.index')
                           ->with('success', 'Guru berhasil ditambahkan.');
        } catch (\Exception $e) {
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
        $sekolahs = Sekolah::all();
        $guru->load('akun');
        
        return view('admin.guru.edit', compact('guru', 'sekolahs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'nama_guru' => 'required|string|max:255',
            'email' => 'required|email|unique:tb_guru,email,' . $guru->id_guru . ',id_guru',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            // Handle photo upload
            if ($request->hasFile('foto')) {
                // Delete old photo if exists
                if ($guru->foto && file_exists(public_path('photos/' . $guru->foto))) {
                    unlink(public_path('photos/' . $guru->foto));
                }

                $file = $request->file('foto');
                $filename = time() . '_' . Str::slug($request->nama_guru) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('photos'), $filename);
                $validated['foto'] = $filename;
            }

            $guru->update($validated);

            return redirect()->route('guru.index')
                           ->with('success', 'Data guru berhasil diperbarui.');
        } catch (\Exception $e) {
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
        try {
            // Delete associated account
            if ($guru->akun) {
                $guru->akun->delete();
            }

            // Delete photo file if exists
            if ($guru->foto && file_exists(public_path('photos/' . $guru->foto))) {
                unlink(public_path('photos/' . $guru->foto));
            }

            $guru->delete();

            return redirect()->route('guru.index')
                           ->with('success', 'Guru berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menghapus guru: ' . $e->getMessage());
        }
    }

    /**
     * Create account for existing guru
     */
    public function createAccount(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:tb_akun,username',
            'password' => 'required|string|min:8'
        ]);

        try {
            // Check if account already exists
            if ($guru->akun) {
                return redirect()->back()
                               ->with('error', 'Guru sudah memiliki akun.');
            }

            Akun::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'guru',
                'id_guru' => $guru->id_guru,
                'id_siswa' => null
            ]);

            return redirect()->route('guru.show', $guru)
                           ->with('success', 'Akun guru berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal membuat akun: ' . $e->getMessage());
        }
    }

    /**
     * Update account credentials
     */
    public function updateAccount(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:tb_akun,username,' . $guru->akun->id_akun . ',id_akun',
            'password' => 'nullable|string|min:8'
        ]);

        try {
            $akun = $guru->akun;
            
            if (!$akun) {
                return redirect()->back()
                               ->with('error', 'Guru tidak memiliki akun.');
            }

            $updateData = ['username' => $request->username];
            
            if ($request->password) {
                $updateData['password'] = Hash::make($request->password);
            }

            $akun->update($updateData);

            return redirect()->route('guru.show', $guru)
                           ->with('success', 'Akun guru berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal memperbarui akun: ' . $e->getMessage());
        }
    }

    /**
     * Frontend - Display guru profiles
     */
    public function profilPengajar(Request $request)
    {
        $query = Guru::withMapel()->with('sekolah');

        // Filter by sekolah
        if ($request->has('sekolah_id') && $request->sekolah_id) {
            $query->bySekolah($request->sekolah_id);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhereHas('mapel', function($mapelQuery) use ($search) {
                      $mapelQuery->where('nama_mapel', 'like', "%{$search}%");
                  });
            });
        }

        $gurus = $query->orderBy('nama_guru')->paginate(12);
        $sekolahs = Sekolah::all();

        return view('frontend.profilPengajar', compact('gurus', 'sekolahs'));
    }

    /**
     * Get guru by sekolah for API/AJAX
     */
    public function getBySekolah($idSekolah)
    {
        $gurus = Guru::bySekolah($idSekolah)
                     ->select('id_guru', 'nama_guru')
                     ->orderBy('nama_guru')
                     ->get();

        return response()->json($gurus);
    }
}