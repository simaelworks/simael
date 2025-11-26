@extends('layouts.app')

@section('title', 'Pending')

@section('content')

<div class="min-h-screen flex items-center justify-center p-6">
    <div class="text-center max-w-md">
        <div class="mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock mx-auto text-yellow-500 dark:text-white">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-foreground dark:text-white mb-2">Akun Dalam Proses Verifikasi</h1>
        <p class="text-muted-foreground dark:text-gray-300 mb-6">Akun kamu sedang pending dulu menunggu verifikasi dari admin. Silakan tunggu beberapa saat.</p>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">Logout</button>
        </form>
    </div>
</div>

@endsection