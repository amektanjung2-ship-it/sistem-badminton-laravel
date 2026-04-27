<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-emerald-800 leading-tight flex items-center gap-2">
            <span class="text-3xl">👥</span> Daftar Pelanggan E-Badminton
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left border-collapse">
                            <thead class="bg-slate-50 text-gray-600 text-sm">
                                <tr>
                                    <th class="py-3 px-4 border-b font-semibold">Nama Pelanggan</th>
                                    <th class="py-3 px-4 border-b font-semibold">Email</th>
                                    <th class="py-3 px-4 border-b font-semibold">Tanggal Daftar</th>
                                    <th class="py-3 px-4 border-b font-semibold">Status</th>
                                    <th class="py-3 px-4 border-b font-semibold text-center">Aksi Member</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 font-bold text-gray-800">{{ $user->name }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $user->email }}</td>
                                    <td class="py-3 px-4 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="py-3 px-4">
                                        @if($user->is_member)
                                            <span class="bg-yellow-100 text-yellow-700 font-bold px-2 py-1 rounded-full text-xs">VIP Member</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-600 font-bold px-2 py-1 rounded-full text-xs">Reguler</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        {{-- Tombol Sakti On/Off Member --}}
                                        <form action="{{ route('admin.pelanggan.member', $user->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            
                                            @if($user->is_member)
                                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 text-xs font-bold px-3 py-1.5 rounded-lg border border-red-300 transition" onclick="return confirm('Yakin ingin mencabut status Member dari {{ $user->name }}?')">
                                                    ❌ Cabut VIP
                                                </button>
                                            @else
                                                <button type="submit" class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white hover:from-yellow-500 hover:to-yellow-600 text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm transition" onclick="return confirm('Jadikan {{ $user->name }} sebagai Member VIP?')">
                                                    👑 Jadikan VIP
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>