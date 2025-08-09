<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get("search");
        $guru = GUru::when($search, function ($query, $search){
                return $query->search($search);
            })
            ->orderBy('nama_guru', 'asc')
            ->paginate(10);

        return view('admin.guru.index', compact('guru', 'search'));
    }

    public function create ()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nip' => 'required|string|max:20|unique:tb_guru,nip',
            'nama_guru' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'mata_pelajaran' => 'required|string|max:100',
            'alamat' => 'nullable|string'
        ], [
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah terdaftar',
            'nama_guru.required' => 'Nama Guru wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'mata_pelajaran.required' => 'Mata Pelajaran wajib diisi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Guru::create($request->all());

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data Guru berhasil ditambahkan');
    }

    public function show(Guru $guru)
    {
        return view('admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|max:20|unique:tb_guru,nip,' . $guru->id_guru . ',id_guru',
            'nama_siswa' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'mata_pelajaran' => 'required|string|max:100',
            'alamat' => 'nullable|string'
        ], [
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah terdaftar',
            'nama_siswa.required' => 'Nama Guru wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'mata_pelajaran.required' => 'Mata Pelajaran wajib diisi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $guru->update($request->all());

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data Guru berhasil diperbarui');
    }

    public function destroy(guru $guru)
    {
        $guru->delete();

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data Guru dihapus');
    }    
}