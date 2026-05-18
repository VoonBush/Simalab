@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen Pengguna')
@section('page-subtitle', 'Kelola hak akses dan peran pengguna SIMALAB.')

@section('content')
<div class="space-y-6">
    {{-- Search --}}
    <div class="flex-1 max-w-md">
        <form action="{{ route('admin.users') }}" method="GET" class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama, email, atau NPM..."
                   class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
        </form>
    </div>

    {{-- Users Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold text-gray-700">Pengguna</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Kontak</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Role Saat Ini</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-right">Ubah Role</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->avatar_url }}" alt="" class="w-10 h-10 rounded-full border border-gray-100">
                                <div>
                                    <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono">{{ $user->npm ?? 'NPM N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $roleClass = match($user->getRoleNames()->first()) {
                                    'koordinator' => 'badge-blue',
                                    'plp' => 'badge-success',
                                    'asisten_lab' => 'badge-warning',
                                    default => 'badge-gray',
                                };
                            @endphp
                            <span class="badge {{ $roleClass }}">
                                {{ $user->role_display }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="flex items-center justify-end gap-2">
                                @csrf @method('PATCH')
                                <select name="role" class="text-xs border-gray-200 rounded-lg py-1 px-8 bg-white focus:ring-blue-500">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="text-blue-600 hover:text-blue-700 font-bold text-xs uppercase tracking-tighter">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($users->hasPages())
    <div class="px-6 py-4">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
