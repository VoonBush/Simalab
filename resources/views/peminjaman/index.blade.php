<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 font-medium text-sm text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route('peminjaman.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Ajukan Peminjaman
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @if(in_array(auth()->user()->role, ['admin', 'koor_lab', 'asisten']))
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                                    @endif
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batas Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    @if(in_array(auth()->user()->role, ['admin', 'koor_lab', 'asisten']))
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($peminjamans as $peminjaman)
                                    @foreach($peminjaman->details as $detail)
                                    <tr>
                                        @if(in_array(auth()->user()->role, ['admin', 'koor_lab', 'asisten']))
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $peminjaman->user->nama ?? 'Unknown' }}</td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->barang->nama_barang ?? 'Barang Dihapus' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->jumlah }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($peminjaman->batas_peminjaman)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusColor = [
                                                    'diajukan' => 'bg-yellow-100 text-yellow-800',
                                                    'disetujui' => 'bg-blue-100 text-blue-800',
                                                    'ditolak' => 'bg-red-100 text-red-800',
                                                    'dikembalikan' => 'bg-green-100 text-green-800'
                                                ];
                                                $color = $statusColor[$peminjaman->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                                {{ ucfirst($peminjaman->status) }}
                                            </span>
                                        </td>
                                        @if(in_array(auth()->user()->role, ['admin', 'koor_lab', 'asisten']))
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($peminjaman->status == 'diajukan')
                                                <form action="{{ route('peminjaman.updateStatus', $peminjaman->id_peminjaman) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="disetujui">
                                                    <button type="submit" class="text-blue-600 hover:text-blue-900 mr-2" onclick="return confirm('Setujui peminjaman?')">Setujui</button>
                                                </form>
                                                <form action="{{ route('peminjaman.updateStatus', $peminjaman->id_peminjaman) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="ditolak">
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tolak peminjaman?')">Tolak</button>
                                                </form>
                                            @elseif($peminjaman->status == 'disetujui')
                                                <form action="{{ route('peminjaman.updateStatus', $peminjaman->id_peminjaman) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="dikembalikan">
                                                    <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Konfirmasi pengembalian barang?')">Selesai (Kembali)</button>
                                                </form>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($peminjamans->isEmpty())
                        <div class="text-center py-8 text-gray-500">Tidak ada riwayat peminjaman.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
