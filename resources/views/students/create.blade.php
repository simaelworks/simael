@extends('layouts.app')

@section('content')

<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Tammbahkan Akun Murid</h1>

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
        Create Form 
        Sends POST request to students.store
    --}}
    <form method="POST" action="{{ route('students.store') }}" class="space-y-4">
        @csrf

        {{-- NISN Field --}}
        <div>
            <label for="nisn" class="block text-sm font-semibold mb-2">NISN</label>
            <input 
                type="number" 
                id="nisn" 
                name="nisn" 
                value="{{ old('nisn') }}" 
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
                value="{{ old('name') }}" 
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
            @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Major Selection --}}
        <div>
            <label for="major" class="block text-sm font-semibold mb-2">Jurusan</label>
            <select 
                id="major" 
                name="major" 
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
                <option value="PPLG" {{ old('major') == 'PPLG' ? 'selected' : '' }}>PPLG</option>
                <option value="TJKT" {{ old('major') == 'TJKT' ? 'selected' : '' }}>TJKT</option>
                <option value="DKV" {{ old('major') == 'DKV' ? 'selected' : '' }}>DKV</option>
                <option value="BCF" {{ old('major') == 'BCF' ? 'selected' : '' }}>BCF</option>
            </select>
            @error('major')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- 
            Custom Squad Dropdown (Alpine.js)
            Replaces a normal <select> visually while still keeping 
            a hidden <select> synced for actual form submission.
        --}}
        <div 
            x-data="{
                open: false,
                selected: '{{ old('squad_id') }}',
                label: '{{ old('squad_id') ? $squads->firstWhere("id", old("squad_id"))->name : "Select squad (Optional)" }}'
            }"
            class="relative z-50"
        >
            <label class="block text-sm font-semibold mb-2">Squad</label>

            {{-- Button that opens the dropdown --}}
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

            {{-- Dropdown List --}}
            <ul 
                x-show="open"
                @click.away="open = false"
                class="absolute mt-1 w-full bg-gray-50 border border-gray-300 rounded shadow
                       max-h-52 overflow-y-auto overflow-x-hidden z-50"
                style="display:none"
            >
                <li 
                    class="px-3 py-2 hover:bg-blue-100 cursor-pointer"
                    @click="
                        selected = '';
                        label = 'Select squad (Optional)';
                        open = false;
                        $refs.real.value = '';
                    "
                >
                    -- None --
                </li>
                @foreach($squads as $squad)
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

            {{-- Hidden select synced to Alpine state for submission --}}
            <select name="squad_id" x-ref="real" class="hidden">
                <option value="">-- None --</option>
                @foreach($squads as $squad)
                    <option 
                        value="{{ $squad->id }}" 
                        {{ old('squad_id') == $squad->id ? 'selected' : '' }}
                    >
                        {{ $squad->name }}
                    </option>
                @endforeach
            </select>

            @error('squad_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-semibold mb-2">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
            @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Password Confirmation --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold mb-2">Konfirmasi Password</label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
        </div>

        {{-- Status Selection --}}
        <div>
            <label for="status" class="block text-sm font-semibold mb-2">Status</label>
            <select 
                id="status" 
                name="status" 
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            >
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="verified" {{ old('status') == 'verified' ? 'selected' : '' }}>Verified</option>
            </select>
            @error('status')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Submit + Cancel Buttons --}}
        <div class="flex gap-3 mt-6">
            <button 
                type="submit" 
                class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-900 font-semibold rounded border-2 border-blue-500 transition"
            >
                Buat Akun Murid
            </button>

            <a 
                href="{{ route('students.index') }}" 
                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 font-semibold rounded border-2 border-gray-500 transition"
            >
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
