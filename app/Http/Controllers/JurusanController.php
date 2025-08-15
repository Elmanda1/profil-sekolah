<?php
// app/Http/Controllers/JurusanController.php
namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::with('sekolah')->latest()->paginate(10);
        return view('admin.jurusan.index', compact('jurusan'));
    }

    public function create()
    {
        $sekolah = Sekolah::all();
        return view('admin.jurusan.create', compact('sekolah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'id_sekolah' => 'nullable|exists:tb_sekolah,id_sekolah'
        ]);

        $validated['id_sekolah'] = $validated['id_sekolah'] ?? 1; // Default sekolah ID

        Jurusan::create($validated);

        return redirect()->route('admin.jurusan.index')
                        ->with('success', 'Data jurusan berhasil ditambahkan');
    }

    public function show(Jurusan $jurusan)
    {
        $jurusan->load(['kelas']);
        return view('admin.jurusan.show', compact('jurusan'));
    }

    public function edit(Jurusan $jurusan)
    {
        $sekolah = Sekolah::all();
        return view('admin.jurusan.edit', compact('jurusan', 'sekolah'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'id_sekolah' => 'nullable|exists:tb_sekolah,id_sekolah'
        ]);

        $jurusan->update($validated);

        return redirect()->route('admin.jurusan.index')
                        ->with('success', 'Data jurusan berhasil diupdate');
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')
                        ->with('success', 'Data jurusan berhasil dihapus');
    }
}