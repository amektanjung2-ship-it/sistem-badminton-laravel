<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-emerald-800 leading-tight">
            {{ __('Manajemen Data Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- NOTIFIKASI SISTEM --}}
            @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm mb-6 flex items-start">
                <div class="flex-shrink-0 text-emerald-500 mt-0.5">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-emerald-800">Pemberitahuan</p>
                    <p class="text-sm font-medium text-emerald-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                <div class="p-6 md:p-8">
                    
                    {{-- HEADER TABEL --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 border-b border-gray-100 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-emerald-50 rounded-lg text-emerald-600 border border-emerald-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 tracking-tight">Daftar Pengguna Terdaftar</h3>
                                <p class="text-sm text-gray-500 mt-1">Kelola data pelanggan dan penetapan status keanggotaan (Member/VIP).</p>
                            </div>
                        </div>
                    </div>

                    {{-- TABEL DATA --}}
                    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm bg-white">
                            <thead class="bg-slate-50 text-xs uppercase font-bold text-gray-600 tracking-wider border-b border-gray-200">
                                <tr>
                                    <th class="px-5 py-4">No</th>
                                    <th class="px-5 py-4">Nama Pelanggan</th>
                                    <th class="px-5 py-4">Alamat Email</th>
                                    <th class="px-5 py-4">Nomor WhatsApp / HP</th>
                                    <th class="px-5 py-4">Tanggal Daftar</th>
                                    <th class="px-5 py-4">Status Akun</th>
                                    <th class="px-5 py-4 text-center">Aksi Keanggotaan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($pelanggans as $pelanggan)
                                <tr class="hover:bg-slate-50 transition duration-150">
                                    <td class="px-5 py-4 whitespace-nowrap text-gray-600 font-medium">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-4 whitespace-nowrap font-bold text-gray-900">{{ $pelanggan->name }}</td>
                                    <td class="px-5 py-4 whitespace-nowrap text-gray-500">{{ $pelanggan->email }}</td>
                                    
                                    {{-- Hanya Menampilkan Angka Nomor HP Biasa (Tanpa Link Chat WA) --}}
                                    <td class="px-5 py-4 whitespace-nowrap text-gray-700 font-medium">
                                        @if($pelanggan->no_hp)
                                            {{ $pelanggan->no_hp }}
                                        @else
                                            <span class="text-gray-400 italic text-xs">Belum mengisi nomor</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-5 py-4 whitespace-nowrap text-gray-600 font-medium">
                                        {{ $pelanggan->created_at->format('d M Y') }}
                                    </td>
                                    
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($pelanggan->is_member)
                                            <span class="bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-800 text-[11px] font-bold px-3 py-1 rounded-full border border-amber-200 uppercase tracking-wide">Member VIP</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-700 text-[11px] font-bold px-3 py-1 rounded-full border border-gray-200 uppercase tracking-wide">Reguler</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-5 py-4 whitespace-nowrap text-center align-middle">
                                        <form action="{{ route('admin.pelanggan.member', $pelanggan->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            
                                            @if($pelanggan->is_member)
                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mencabut status Member VIP dari pengguna ini?')" class="bg-white border border-gray-300 hover:bg-red-50 hover:text-red-600 hover:border-red-300 text-gray-700 text-xs font-bold py-1.5 px-4 rounded-lg shadow-sm transition-colors w-full sm:w-auto">
                                                    Cabut Status Member
                                                </button>
                                            @else
                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin memberikan akses Member VIP kepada pengguna ini?')" class="bg-amber-400 hover:bg-amber-500 text-white text-xs font-bold py-1.5 px-4 rounded-lg shadow-sm transition-colors w-full sm:w-auto flex items-center justify-center gap-1.5 mx-auto">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                                    </svg>
                                                    Jadikan Member
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-gray-500 font-medium">Belum ada data pengguna yang terdaftar di dalam sistem.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>