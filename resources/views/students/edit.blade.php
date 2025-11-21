@extends('layouts.app')

@section('content')

<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Edit Akun Murid</h1>

    {{-- Success message --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation errors --}}
    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 
        Update Form
        Sends PUT request to students.update route.
    --}}
    <form method="POST" action="{{ route('students.update', $student) }}" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- NISN Field --}}
        <div>
            <label for="nisn" class="block text-sm font-semibold mb-2">NISN</label>
            <input 
                type="number" 
                id="nisn" 
                name="nisn" 
                value="{{ old('nisn', $student->nisn) }}" 
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
            @error('nisn')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Name Field --}}
        <div>
            <label for="name" class="block text-sm font-semibold mb-2">Nama</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name', $student->name) }}" 
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
            @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Major Dropdown --}}
        <div>
            <label for="major" class="block text-sm font-semibold mb-2">Jurusan</label>
            <select 
                id="major" 
                name="major" 
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
                <option value="PPLG" {{ old('major', $student->major) == 'PPLG' ? 'selected' : '' }}>PPLG</option>
                <option value="TJKT" {{ old('major', $student->major) == 'TJKT' ? 'selected' : '' }}>TJKT</option>
                <option value="DKV" {{ old('major', $student->major) == 'DKV' ? 'selected' : '' }}>DKV</option>
                <option value="BCF" {{ old('major', $student->major) == 'BCF' ? 'selected' : '' }}>BCF</option>
            </select>
            @error('major')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- 
            Custom Squad Dropdown
            Uses Alpine.js to simulate a searchable dropdown while keeping
            the real <select> hidden for form submission.
        --}}
        <div 
            x-data="{
                open: false,
                selected: '{{ old('squad_id', $student->squad_id) }}',
                label: '{{ $squads->firstWhere("id", old("squad_id", $student->squad_id))->name }}'
            }" 
            class="relative z-50"
        >
            <label class="block text-sm font-semibold mb-2">Squad</label>

            {{-- Dropdown Button --}}
            <button 
                type="button"
                @click="open = !open"
                class="w-full px-3 py-2 border border-gray-300 bg-gray-50 rounded 
                       focus:outline-none text-left flex justify-between items-center"
            >
                <span x-text="label"></span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- Dropdown Items --}}
            <ul 
                x-show="open"
                @click.away="open = false"
                class="absolute mt-1 w-full bg-gray-50 border border-gray-300 rounded shadow 
                       max-h-52 overflow-y-auto overflow-x-hidden z-50"
                style="display:none"
            >
                @foreach ($squads as $squad)
                <li 
                    class="px-3 py-2 hover:bg-blue-100 cursor-pointer"
                    @click="
                        selected = '{{ $squad->id }}';
                        label = '{{ $squad->name }}';
                        open = false;
                        $refs.real.value = '{{ $squad->id }}';
                    "
                >
                    {{ $squad->name }}
                </li>
                @endforeach
            </ul>

            {{-- Hidden submit-friendly select --}}
            <select name="squad_id" x-ref="real" class="hidden">
                @foreach($squads as $squad)
                    <option 
                        value="{{ $squad->id }}" 
                        {{ old('squad_id', $student->squad_id) == $squad->id ? 'selected' : '' }}
                    >
                        {{ $squad->name }}
                    </option>
                @endforeach
            </select>

            @error('squad_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Optional Password Update --}}
        <div>
            <label for="password" class="block text-sm font-semibold mb-2">
                Password (Biarkan kosong jika tidak ingin mengubah)
            </label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
            @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Password Confirmation --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold mb-2">
                Konfirmmasi Password
            </label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
        </div>

        {{-- Status Dropdown --}}
        <div>
            <label for="status" class="block text-sm font-semibold mb-2">Status</label>
            <select 
                id="status" 
                name="status" 
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
                <option value="pending" {{ old('status', $student->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="verified" {{ old('status', $student->status) == 'verified' ? 'selected' : '' }}>Verified</option>
            </select>
            @error('status')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Buttons --}}
        <div class="flex gap-3 mt-6">
            <button type="submit" class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-900 font-semibold rounded border-2 border-blue-500 transition">
                Perbarui Akun Murid
            </button>

            <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 font-semibold rounded border-2 border-gray-500 transition">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
