<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lapangan;
use Illuminate\Support\Facades\Storage;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangans = Lapangan::latest()->get();
        return view('admin.lapangan.index', compact('lapangans'));
    }

    public function create()
    {
        return view('admin.lapangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'harga_per_jam' => 'required|numeric|min:0',
            'status_aktif'  => 'required|boolean',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'foto.max'   => 'Ukuran gambar maksimal 2MB.',
        ]);

        $pathFoto = null;
        if ($request->hasFile('foto')) {
            // Simpan ke storage/app/public/lapangan/
            $pathFoto = $request->file('foto')->store('lapangan', 'public');
        }

        Lapangan::create([
            'nama_lapangan' => $request->nama_lapangan,
            'foto'          => $pathFoto,
            'harga_per_jam' => $request->harga_per_jam,
            'status_aktif'  => $request->status_aktif,
        ]);

        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan baru berhasil ditambahkan!');
    }

    public function edit(Lapangan $lapangan)
    {
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    public function update(Request $request, Lapangan $lapangan)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'harga_per_jam' => 'required|numeric|min:0',
            'status_aktif'  => 'required|boolean',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'foto.max'   => 'Ukuran gambar maksimal 2MB.',
        ]);

        $pathFoto = $lapangan->foto; // Pertahankan foto lama jika tidak upload baru

        if ($request->hasFile('foto')) {
            // Hapus foto lama dari storage sebelum simpan yang baru
            if ($lapangan->foto) {
                Storage::disk('public')->delete($lapangan->foto);
            }
            $pathFoto = $request->file('foto')->store('lapangan', 'public');
        }

        // Hapus foto jika admin centang "hapus foto"
        if ($request->boolean('hapus_foto') && $lapangan->foto) {
            Storage::disk('public')->delete($lapangan->foto);
            $pathFoto = null;
        }

        $lapangan->update([
            'nama_lapangan' => $request->nama_lapangan,
            'foto'          => $pathFoto,
            'harga_per_jam' => $request->harga_per_jam,
            'status_aktif'  => $request->status_aktif,
        ]);

        return redirect()->route('admin.lapangan.index')->with('success', 'Data lapangan berhasil diperbarui!');
    }

    public function destroy(Lapangan $lapangan)
    {
        // Hapus foto dari storage saat lapangan dihapus
        if ($lapangan->foto) {
            Storage::disk('public')->delete($lapangan->foto);
        }
        $lapangan->delete();
        return redirect()->route('admin.lapangan.index')->with('success', 'Data lapangan berhasil dihapus!');
    }
}