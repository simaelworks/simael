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
              <input name="nisn" type="number" class="bg-gray-100 w-full text-slate-900 text-sm px-4 py-3 focus:bg-transparent border border-gray-100 focus:border-black outline-none transition-all" placeholder="Masukkan NISN"  value="{{ old('nisn') }}" required/>
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
              <input name="password" type="password" class="bg-gray-100 w-full text-slate-900 text-sm px-4 py-3 focus:bg-transparent border border-gray-100 focus:border-black outline-none transition-all" placeholder="Masukkan password" required/>
            </div>
            <div>
              <label class="text-slate-900 text-sm mb-2 block">Konfirmasi Password</label>
              <input name="confirm-password" type="password" class="bg-gray-100 w-full text-slate-900 text-sm px-4 py-3 focus:bg-transparent border border-gray-100 focus:border-black outline-none transition-all" placeholder="Masukkan ulang password" required/>
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

@endsection