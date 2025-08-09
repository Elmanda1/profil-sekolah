<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestasi = Prestasi::with('siswa')->latest()->paginate(10);
        return view('admin.prestasi.index', compact('prestasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = Siswa::all();
        return view('admin.prestasi.create', compact('siswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required|exists:tb_siswa,id_siswa',
            'nama_prestasi' => 'required|string|max:100',
            'tahun' => 'nullable|integer|min:2000|max:' . (date('Y') + 1)
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Prestasi::create($request->all());

        return redirect()->route('prestasi.index')
            ->with('success', 'Prestasi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $prestasi = Prestasi::with('siswa')->findOrFail($id);
        return view('admin.prestasi.show', compact('prestasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $siswa = Siswa::all();
        return view('admin.prestasi.edit', compact('prestasi', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required|exists:tb_siswa,id_siswa',
            'nama_prestasi' => 'required|string|max:100',
            'tahun' => 'nullable|integer|min:2000|max:' . (date('Y') + 1)
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $prestasi = Prestasi::findOrFail($id);
        $prestasi->update($request->all());

        return redirect()->route('prestasi.index')
            ->with('success', 'Prestasi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $prestasi->delete();

        return redirect()->route('prestasi.index')
            ->with('success', 'Prestasi berhasil dihapus');
    }

    /**
     * Display prestasi for frontend
     */
    public function frontend()
    {
        $prestasi = Prestasi::with('siswa')->latest()->paginate(9);
        return view('frontend.prestasi', compact('prestasi'));
    }

    /**
     * Filter prestasi by year
     */
    public function byYear($year)
    {
        $prestasi = Prestasi::with('siswa')->byYear($year)->latest()->paginate(9);
        return view('frontend.prestasi', compact('prestasi'));
    }
}