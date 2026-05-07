@extends('layouts.admin')
@section('title', 'Kelola Pengguna — InventarisLab')
@section('page-title', 'Kelola Pengguna')
@section('page-subtitle', 'Manajemen hak akses dan role pengguna')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Nama & Identitas</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Email</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Role Saat Ini</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Ubah Role</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $user)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-900">{{ $user->nama }}</p>
                        <p class="text-xs text-slate-500">{{ $user->npm ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                            @if($user->role == 'admin') bg-indigo-100 text-indigo-700
                            @elseif($user->role == 'koordinator_lab') bg-purple-100 text-purple-700
                            @elseif($user->role == 'asisten') bg-emerald-100 text-emerald-700
                            @else bg-slate-100 text-slate-700
                            @endif">
                            {{ str_replace('_', ' ', $user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.users.updateRole', $user->id_user) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="role" onchange="this.form.submit()" class="text-xs bg-slate-50 border border-slate-200 rounded-lg px-2 py-1.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
                                <option value="mahasiswa" {{ $user->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="asisten" {{ $user->role == 'asisten' ? 'selected' : '' }}>Asisten</option>
                                <option value="koordinator_lab" {{ $user->role == 'koordinator_lab' ? 'selected' : '' }}>Koor Lab</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
