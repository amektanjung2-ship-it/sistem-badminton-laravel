<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;

class AlatController extends Controller
{
    public function index()
    {
        $alats = Alat::latest()->get();
        return view('admin.alat.index', compact('alats'));
    }

    public function create()
    {
        return view('admin.alat.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga_sewa' => 'required|numeric|min:0',
            'jenis_transaksi' => 'required|in:Sewa,Beli'
        ]);

        // 2. Simpan ke database (Ini yang bikin error kalau $fillable salah)
        Alat::create($validated);

        // 3. Kembali ke halaman tabel dengan pesan sukses
        return redirect()->route('admin.alat.index')->with('success', 'Data alat/perlengkapan berhasil ditambahkan!');
    }

    public function edit(Alat $alat)
    {
        return view('admin.alat.edit', compact('alat'));
    }

    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'harga_sewa' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $alat->update($request->all());

        return redirect()->route('admin.alat.index')->with('success', 'Data perlengkapan berhasil diperbarui!');
    }

    public function destroy(Alat $alat)
    {
        $alat->delete();
        return redirect()->route('admin.alat.index')->with('success', 'Perlengkapan berhasil dihapus!');
    }
}
