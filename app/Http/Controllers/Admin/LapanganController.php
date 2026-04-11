<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lapangan;

class LapanganController extends Controller
{
    // Menampilkan daftar lapangan
    public function index()
    {
        $lapangans = Lapangan::latest()->get();
        return view('admin.lapangan.index', compact('lapangans'));
    }

    // Menampilkan form tambah lapangan
    public function create()
    {
        return view('admin.lapangan.create');
    }

    // Menyimpan data lapangan baru ke database
    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'harga_per_jam' => 'required|numeric|min:0',
            'status_aktif' => 'required|boolean',
        ]);

        // Simpan ke database
        Lapangan::create([
            'nama_lapangan' => $request->nama_lapangan,
            'harga_per_jam' => $request->harga_per_jam,
            'status_aktif' => $request->status_aktif,
        ]);

        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan baru berhasil ditambahkan!');
    }

    public function edit(Lapangan $lapangan)
    {
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    // Menyimpan perubahan data lapangan ke database
    public function update(Request $request, Lapangan $lapangan)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'harga_per_jam' => 'required|numeric|min:0',
            'status_aktif' => 'required|boolean',
        ]);

        $lapangan->update([
            'nama_lapangan' => $request->nama_lapangan,
            'harga_per_jam' => $request->harga_per_jam,
            'status_aktif' => $request->status_aktif,
        ]);

        return redirect()->route('admin.lapangan.index')->with('success', 'Data lapangan berhasil diperbarui!');
    }

    // Menghapus data lapangan dari database
    public function destroy(Lapangan $lapangan)
    {
        $lapangan->delete();
        return redirect()->route('admin.lapangan.index')->with('success', 'Data lapangan berhasil dihapus secara permanen!');
    }
}
