@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <h2 class="text-3xl font-bold text-foreground mb-2">Halo, {{ auth('teacher')->user()->name }} 👋</h2>
    <p class="text-muted-foreground">Selamat datang di dashboard guru. Anda dapat mengelola siswa dan squad di sini.</p>
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        <a href="{{ route('teacher.students.index') }}" class="block p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-xl font-semibold mb-2">Kelola Siswa</h3>
            <p class="text-gray-600">Lihat, tambah, dan edit data siswa.</p>
        </a>
        <a href="{{ route('teacher.squads.index') }}" class="block p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-xl font-semibold mb-2">Kelola Squad</h3>
            <p class="text-gray-600">Lihat, buat, dan edit squad PKL.</p>
        </a>
    </div>
</div>
@endsection
