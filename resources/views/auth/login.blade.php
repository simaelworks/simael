@extends('layouts.app')

@section('title', 'Login')

@section('content')
{{-- 
@if (session()->has('failed'))
<p>{{ session('failed') }}</p>
@endif

@if (session()->has('success'))
<p>{{ session('success') }}</p>
@endif

<form action="{{ route('login') }}" method="post">
    @csrf

    <input name="nisn" type="number" placeholder="NISN">
    <input name="password" type="text" placeholder="Password">
    <button type="submit">Submit</button>
</form> --}}

<div class="flex fle-col items-center justify-center p-6">

      <div class="grid lg:grid-cols-2 items-center gap-8 max-w-6xl max-lg:max-w-lg w-full">
        <form class="lg:max-w-md w-full" action="{{ route('login') }}" method="post">
            @csrf

          <h1 class="text-slate-900 text-3xl font-semibold mb-8">Login Murid</h1>
          <div class="space-y-6">
            <div>
              <label class="text-slate-900 text-sm mb-2 block">NISN</label>
                @if ($errors->any())
                    <input name="nisn" type="number" class="bg-gray-100 w-full text-slate-900 text-sm px-4 py-3 focus:bg-transparent border  border-red-500 focus:border-black outline-none transition-all" placeholder=" Masukkan NISN"  value="{{ old('nisn') }}" required/>
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm mt-1 text-red-500">{{ $error }}</p>
                        @endforeach
                    </div>
                @else
                    @if (session()->has('failed'))

                        <input name="nisn" type="number" class="bg-gray-100 w-full text-slate-900 text-sm px-4 py-3 focus:bg-transparent border  border-red-500 focus:border-black outline-none transition-all" placeholder=" Masukkan NISN"  value="{{ old('nisn') }}" required/>
                        <p class="text-sm mt-1 text-red-500">{{ session('failed') }}</p>

                    @else
                        <input name="nisn" type="number" class="bg-gray-100 w-full text-slate-900 text-sm px-4 py-3 focus:bg-transparent border  border-grey-100 focus:border-black outline-none transition-all" placeholder=" Masukkan NISN"  value="{{ old('nisn') }}" required/>
                        @if (session()->has('success'))
                        <p class="text-sm mt-1 text-green-400">{{ session('success') }}</p>
                        @endif
                    @endif
                @endif
            </div>
            <div>
              <label class="text-slate-900 text-sm mb-2 block">Password</label>
              <input name="password" type="password" class="bg-gray-100 w-full text-slate-900 text-sm px-4 py-3 focus:bg-transparent border border-gray-100 focus:border-black outline-none transition-all" placeholder="Masukkan password" required/>
            </div>
            <div class="flex items-center">
              <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 border-gray-300 rounded" required />
              <label for="remember-me" class="ml-3 block text-sm text-slate-600">
                Remember me 
              </label>
            </div>
          </div>

          <div class="mt-6">
            <button type="submit" class="py-3 px-6 text-sm text-white tracking-wide bg-blue-600 hover:bg-blue-700 focus:outline-none cursor-pointer">
              Login
            </button>
          </div>
          <p class="text-sm text-slate-600 mt-6">Belum punya akun? <a href="{{ route('registerPage') }}" class="text-blue-600 font-semibold hover:underline ml-1">Buat disini</a></p>
        </form>

        <div class="h-full">
          <img src="https://readymadeui.com/login-image.webp" class="w-full h-full object-contain aspect-628/516" alt="login img" />
        </div>
      </div>
    </div>

@endsection