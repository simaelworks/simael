@extends('layouts.app')

@section('content')

<div class="mt-4 p-4 md:p-6 max-w-full md:max-w-2xl mx-auto">
    <h1 class="text-2xl md:text-3xl font-bold mb-6">Buat Squad Baru</h1>

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
        Sends POST request to squads.preview
    --}}
    <form method="POST" action="{{ route('squads.preview') }}" class="space-y-4">
        @csrf

        {{-- Squad Name Field --}}
        <div>
            <label for="name" class="block text-sm font-semibold mb-2">Nama Squad (Max 20 huruf)</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name') }}" 
                required
                minlength="3"
                maxlength="20"
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                placeholder="Masukkan nama squad (3-20 huruf)"
            >
            @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Leader NISN Field --}}
        <div>
            <label for="leader_nisn" class="block text-sm font-semibold mb-2">NISN Leader</label>
            <input 
                type="text" 
                id="leader_nisn" 
                name="leader_nisn" 
                value="{{ old('leader_nisn') }}" 
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                placeholder="Masukkan NISN leader"
            >
            @error('leader_nisn')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Members NISN Field (Comma-separated) --}}
        <div>
            <label for="members_nisn" class="block text-sm font-semibold mb-2">NISN Anggota (Pisahkan dengan koma)</label>
            <textarea 
                id="members_nisn" 
                name="members_nisn" 
                rows="4"
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                placeholder="Contoh: 1234567890, 1234567891, 1234567892"
            >{{ old('members_nisn') }}</textarea>
            @error('members_nisn')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            <p class="text-gray-600 text-xs mt-1">Masukkan NISN anggota yang akan bergabung, pisahkan dengan koma</p>
        </div>

        {{-- Company Name Field --}}
        <div>
            <label for="nama_perusahaan" class="block text-sm font-semibold mb-2">Nama Perusahaan</label>
            <input 
                type="text" 
                id="nama_perusahaan" 
                name="nama_perusahaan" 
                value="{{ old('nama_perusahaan') }}" 
                maxlength="100"
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                placeholder="Masukkan nama perusahaan (opsional)"
            >
            @error('nama_perusahaan')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Company Address Field --}}
        <div>
            <label for="alamat_perusahaan" class="block text-sm font-semibold mb-2">Alamat Perusahaan</label>
            <textarea 
                id="alamat_perusahaan" 
                name="alamat_perusahaan" 
                rows="3"
                maxlength="255"
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                placeholder="Masukkan alamat perusahaan (opsional)"
            >{{ old('alamat_perusahaan') }}</textarea>
            @error('alamat_perusahaan')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
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
                <option value="pengajuan" {{ old('status') == 'pengajuan' ? 'selected' : '' }}>Pengajuan</option>
                <option value="on-progress" {{ old('status') == 'on-progress' ? 'selected' : '' }}>On Progress</option>
                <option value="diterima" {{ old('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="unknown" {{ old('status') == 'unknown' ? 'selected' : '' }}>Unknown</option>
            </select>
            @error('status')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Form Buttons --}}
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('squads.index') }}" class="px-4 py-2 text-gray-700 font-semibold border border-gray-300 rounded hover:bg-gray-100 transition">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded transition">
                Lanjut ke Preview
            </button>
        </div>
    </form>
</div>

@endsection
