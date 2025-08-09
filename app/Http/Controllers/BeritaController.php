<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita = Berita::orderBy('id_berita', 'desc')->paginate(10);
        return view('admin.berita.index', compact('berita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_berita' => 'required|string|max:200',
            'isi_berita' => 'required|string',
            'tanggal_berita' => 'required|date',
            'penulis' => 'nullable|string|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Berita::create($request->all());

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul_berita' => 'required|string|max:200',
            'isi_berita' => 'required|string',
            'tanggal_berita' => 'required|date',
            'penulis' => 'nullable|string|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $berita = Berita::findOrFail($id);
        $berita->update($request->all());

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus');
    }

    /**
     * Display berita for frontend
     */
    public function frontend()
    {
        $berita = Berita::orderBy('tanggal_berita', 'desc')->paginate(6);
        return view('frontend.berita', compact('berita'));
    }

    /**
     * Display single berita for frontend
     */
    public function detail($id)
    {
        $berita = Berita::findOrFail($id);
        return view('frontend.berita-detail', compact('berita'));
    }
}