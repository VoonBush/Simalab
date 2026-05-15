@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Pengaturan Profil')
@section('page-subtitle', 'Kelola informasi data diri, email, dan keamanan akun Anda.')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
        <div class="p-6 md:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
