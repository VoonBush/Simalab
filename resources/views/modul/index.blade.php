<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Modul Praktikum') }}
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

                    @if(in_array(auth()->user()->role, ['admin', 'koor_lab', 'asisten']))
                        <div class="mb-4">
                            <a href="{{ route('modul.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Tambah Modul Baru
                            </a>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($moduls as $modul)
                        <div class="bg-white border rounded-lg shadow-md p-4 flex flex-col">
                            <h3 class="text-lg font-semibold mb-2">{{ $modul->judul }}</h3>
                            <p class="text-gray-600 text-sm mb-4 flex-grow">{{ $modul->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                            
                            <div class="flex justify-between items-center mt-auto border-t pt-4">
                                @if($modul->file_path)
                                    <a href="{{ $modul->file_path }}" target="_blank" class="text-blue-500 hover:text-blue-700 font-medium text-sm">Lihat Modul</a>
                                @else
                                    <span class="text-gray-400 text-sm">Tidak ada link</span>
                                @endif

                                @if(in_array(auth()->user()->role, ['admin', 'koor_lab', 'asisten']))
                                    <div class="flex space-x-2">
                                        <a href="{{ route('modul.edit', $modul) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                        <form action="{{ route('modul.destroy', $modul) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    @if($moduls->isEmpty())
                        <div class="text-center py-8 text-gray-500">Belum ada modul praktikum yang tersedia.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
