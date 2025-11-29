@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="min-h-screen flex fle-col items-center justify-center p-6">

      <div class="grid lg:grid-cols-2 items-center gap-8 max-w-6xl max-lg:max-w-lg w-full">
        <form class="lg:max-w-md w-full" action="{{ route('register') }}" method="post">
            @csrf

          <h1 class="text-slate-900 text-3xl font-semibold mb-8">Buat akun Murid</h1>
          <div class="space-y-6">
            <div>
              <label class="text-slate-900 text-sm mb-2 block">Nama</label>
                @if ($errors->any())
                    <input name="name" type="text" class="bg-gray-100 w-full text-slate-900 text-sm px-4 py-3 focus:bg-transparent border  border-red-500 focus:border-black outline-none transition-all" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required/>
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm mt-1 text-red-500">{{ $error }}</p>
                        @endforeach
                    </div>
                @else
                    @if (session()->has('failed'))

                        <input name="name" type="text" class="bg-gray-100 w-full text-slate-900 text-sm px-4 py-3 focus:bg-transparent border  border-red-500 focus:border-black outline-none transition-all" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required/>
                        <p class="text-sm mt-1 text-red-500">{{ session('failed') }}</p>

                    @else
                        <input name="name" type="text" class="bg-gray-100 w-full text-slate-900 text-sm px-4 py-3 focus:bg-transparent border border-gray-100 focus:border-black outline-none transition-all" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required/>
                    @endif
                @endif
            </div>
            <div>
              <label class="text-slate-900 text-sm mb-2 block">NISN</label>
              <input name="nisn" type="text" inputmode="numeric" class="bg-gray-100 w-full text-slate-900 text-sm px-4 py-3 focus:bg-transparent border border-gray-100 focus:border-black outline-none transition-all" placeholder="Masukkan NISN (10 digit)"  value="{{ old('nisn') }}" required/>
            </div>
            <div>
              <label class="text-slate-900 text-sm mb-2 block">Jurusan</label>
              <select name="major" id="" class="bg-gray-100 w-full text-slate-900 text-sm px-4 py-3 focus:bg-transparent border border-gray-100 focus:border-black outline-none transition-all">
                    <option value="PPLG">PPLG</option>
                    <option value="TJKT">TJKT</option>
                    <option value="DKV">DKV</option>
                    <option value="BCF">BCF</option>
              </select>
            </div>
            <div>
              <label class="text-slate-900 text-sm mb-2 block">Password</label>
              <div class="relative">
                <input id="password" name="password" type="password" class="bg-gray-100 w-full text-slate-900 text-sm px-4 py-3 pr-12 focus:bg-transparent border border-gray-100 focus:border-black outline-none transition-all" placeholder="Masukkan password" required/>
                <button type="button" onclick="togglePassword('password', 'eye-open-1', 'eye-closed-1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                  <svg id="eye-open-1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                  <svg id="eye-closed-1" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                  </svg>
                </button>
              </div>
            </div>
            <div>
              <label class="text-slate-900 text-sm mb-2 block">Konfirmasi Password</label>
              <div class="relative">
                <input id="confirm-password" name="confirm-password" type="password" class="bg-gray-100 w-full text-slate-900 text-sm px-4 py-3 pr-12 focus:bg-transparent border border-gray-100 focus:border-black outline-none transition-all" placeholder="Masukkan ulang password" required/>
                <button type="button" onclick="togglePassword('confirm-password', 'eye-open-2', 'eye-closed-2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                  <svg id="eye-open-2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                  <svg id="eye-closed-2" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                  </svg>
                </button>
            </div>
            <div class="flex items-center">
              <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 border-gray-300 rounded" required />
              <label for="remember-me" class="ml-3 block text-sm text-slate-600">
                Saya menerima <a href="javascript:void(0);" class="text-blue-600 font-semibold hover:underline ml-1">Terms and Conditions</a>
              </label>
            </div>
          </div>

          <div class="mt-6">
            <button type="submit" class="py-3 px-6 text-sm text-white tracking-wide bg-blue-600 hover:bg-blue-700 focus:outline-none cursor-pointer">
              Buat
            </button>
          </div>
          <p class="text-sm text-slate-600 mt-6">Sudah punya akun? <a href="{{ route('loginPage') }}" class="text-blue-600 font-semibold hover:underline ml-1">Login disini</a></p>
        </form>

        <div class="h-full">
          <img src="https://readymadeui.com/login-image.webp" class="w-full h-full object-contain aspect-628/516" alt="login img" />
        </div>
      </div>
    </div>

<<script>
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
</script>

@endsection