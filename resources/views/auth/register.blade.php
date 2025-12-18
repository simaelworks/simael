@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-blue-700 to-blue-400 flex items-center justify-center p-4">
    <div class="w-full max-w-5xl">
        <!-- Combined Card Container -->
        <div class="grid lg:grid-cols-2 gap-0 bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Left Side - Register Form -->
            <form class="p-6 lg:p-8" action="{{ route('register') }}" method="post" id="registerForm">
                @csrf
                <input type="hidden" name="recaptcha_token" id="recaptchaToken">

                <h1 class="text-2xl font-bold text-gray-900 mb-1">Daftar</h1>
                <p class="text-gray-600 text-xs mb-5">Buat akun untuk memulai perjalanan anda</p>
                
                <div class="space-y-3">
                    <div>
                        <label for="name" class="block text-gray-700 text-xs font-semibold mb-1">Nama Lengkap</label>
                        @if ($errors->any())
                            <input id="name" name="name" type="text" autocomplete="name" class="w-full px-3 py-2 text-sm border-2 border-red-500 rounded-lg focus:outline-none focus:border-blue-600 transition-colors" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required/>
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p class="text-sm mt-1 text-red-500">{{ $error }}</p>
                                @endforeach
                            </div>
                        @else
                            @if (session()->has('failed'))
                                <input id="name" name="name" type="text" autocomplete="name" class="w-full px-3 py-2 text-sm border-2 border-red-500 rounded-lg focus:outline-none focus:border-blue-600 transition-colors" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required/>
                                <p class="text-sm mt-1 text-red-500">{{ session('failed') }}</p>
                            @else
                                <input id="name" name="name" type="text" autocomplete="name" class="w-full px-3 py-2 text-sm border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 transition-colors" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required/>
                            @endif
                        @endif
                    </div>

                    <div>
                        <label for="nisn" class="block text-gray-700 text-xs font-semibold mb-1">NISN</label>
                        <input id="nisn" name="nisn" type="text" inputmode="numeric" autocomplete="off" class="w-full px-3 py-2 text-sm border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 transition-colors" placeholder="Masukkan NISN (10 digit)" value="{{ old('nisn') }}" required/>
                    </div>

                    <div>
                        <label for="major" class="block text-gray-700 text-xs font-semibold mb-1">Jurusan</label>
                        <select id="major" name="major" autocomplete="off" class="w-full px-3 py-2 text-sm border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 transition-colors">
                            <option value="PPLG">PPLG</option>
                            <option value="TJKT">TJKT</option>
                            <option value="DKV">DKV</option>
                            <option value="BCF">BCF</option>
                        </select>
                    </div>

                    <div>
                        <label for="password" class="block text-gray-700 text-xs font-semibold mb-1">Password</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" autocomplete="new-password" class="w-full px-3 py-2 text-sm border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 transition-colors" placeholder="Masukkan password" required/>
                            <button type="button" onclick="togglePassword('password', 'eye-open-1', 'eye-closed-1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <svg id="eye-open-1" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eye-closed-1" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="confirm-password" class="block text-gray-700 text-xs font-semibold mb-1">Konfirmasi Password</label>
                        <div class="relative">
                            <input id="confirm-password" name="confirm-password" type="password" autocomplete="new-password" class="w-full px-3 py-2 text-sm border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 transition-colors" placeholder="Masukkan ulang password" required/>
                            <button type="button" onclick="togglePassword('confirm-password', 'eye-open-2', 'eye-closed-2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <svg id="eye-open-2" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eye-closed-2" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <input id="remember-me" name="remember-me" type="checkbox" class="w-3 h-3 rounded border-gray-300 mt-0.5" required/>
                        <label for="remember-me" class="ml-2 text-xs text-gray-600">
                            Saya menerima <a href="javascript:void(0);" class="text-blue-600 font-semibold hover:underline">Terms and Conditions</a>
                        </label>
                    </div>
                </div>

                <button type="submit" class="w-full mt-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-2 text-sm rounded-lg transition-colors">
                    Daftar
                </button>

                <p class="text-center text-xs text-gray-600 mt-4">
                    Sudah punya akun? <a href="{{ route('loginPage') }}" class="text-blue-600 font-semibold hover:underline">Login disini</a>
                </p>
            </form>

            <!-- Right Side - Welcome Message -->
            <div class="hidden lg:flex items-center justify-center bg-gradient-to-br from-yellow-300 to-orange-400 p-8">
                <div class="text-center text-white">
                    <div class="mb-6">
                        <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold mb-4">Halo Teman!</h2>
                    <p class="text-lg font-semibold mb-2">Mari Bergabung dengan Kami</p>
                    <p class="text-sm opacity-90">
                        Masukkan detail pribadi anda dan mulai perjalanan bersama SIMAEL - Platform PKL yang lebih mudah
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Google reCAPTCHA v3 Script -->
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>

<script>
function togglePassword(inputId, eyeOpenId, eyeClosedId) {
    const passwordInput = document.getElementById(inputId);
    const eyeOpen = document.getElementById(eyeOpenId);
    const eyeClosed = document.getElementById(eyeClosedId);
    
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

// Handle reCAPTCHA
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    grecaptcha.ready(function() {
        grecaptcha.execute('{{ env("RECAPTCHA_SITE_KEY") }}', {action: 'register'}).then(function(token) {
            document.getElementById('recaptchaToken').value = token;
            document.getElementById('registerForm').submit();
        });
    });
});
</script>

@endsection
