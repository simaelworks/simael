@extends('layouts.app')

@section('title', 'Login Guru')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-blue-700 to-blue-400 flex items-center justify-center p-4">
    <div class="w-full max-w-5xl">
        <!-- Combined Card Container -->
        <div class="grid lg:grid-cols-2 gap-0 bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Left Side - Login Form -->
            <form class="p-6 lg:p-8" action="{{ route('teacher.login') }}" method="post">
                @csrf
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Log In Guru</h1>
                <p class="text-gray-600 text-xs mb-5">Masukkan detail anda untuk melanjutkan</p>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-gray-700 text-xs font-semibold mb-1">NIK</label>
                        @if ($errors->any())
                            <input name="nik" type="number" maxlength="16" class="w-full px-3 py-2 border-2 border-red-500 rounded-lg focus:outline-none focus:border-blue-600 transition-colors text-sm" placeholder="Masukkan NIK" value="{{ old('nik') }}" required/>
                            <div class="mt-2">
                                @foreach ($errors->all() as $error)
                                    <p class="text-sm text-red-500">{{ $error }}</p>
                                @endforeach
                            </div>
                        @else
                            @if (session()->has('failed'))
                                <input name="nik" type="number" maxlength="16" class="w-full px-3 py-2 border-2 border-red-500 rounded-lg focus:outline-none focus:border-blue-600 transition-colors text-sm" placeholder="Masukkan NIK" value="{{ old('nik') }}" required/>
                                <p class="text-sm text-red-500 mt-2">{{ session('failed') }}</p>
                            @else
                                <input name="nik" type="number" maxlength="16" class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 transition-colors text-sm" placeholder="Masukkan NIK" value="{{ old('nik') }}" required/>
                                @if (session()->has('success'))
                                    <p class="text-sm text-green-500 mt-2">{{ session('success') }}</p>
                                @endif
                            @endif
                        @endif
                    </div>

                    <div>
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Password</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 transition-colors text-sm" placeholder="Masukkan password" required/>
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <svg id="eye-open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eye-closed" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="w-3 h-3 rounded border-gray-300"/>
                        <label for="remember-me" class="ml-2 text-xs text-gray-600">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="w-full mt-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-2 text-sm rounded-lg transition-colors">
                    Login Untuk Guru
                </button>
            </form>

            <!-- Right Side - Welcome Message -->
            <div class="hidden lg:flex items-center justify-center bg-gradient-to-br from-yellow-300 to-orange-400 p-8">
                <div class="text-center text-white">
                    <div class="mb-6">
                        <svg class="w-20 h-20 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold mb-4">Selamat Datang!</h2>
                    <p class="text-lg font-semibold mb-2">Portal Guru SIMAEL</p>
                    <p class="text-sm opacity-90">
                        Kelola data PKL siswa, pantau progres, dan kelola penilaian dengan mudah
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
    } else {
        passwordInput.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
    }
}
</script>
@endsection
