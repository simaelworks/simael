@extends('layouts.app')

@section('content')

<div class="mt-4 p-4 md:p-6 max-w-full md:max-w-2xl mx-auto">
    <h1 class="text-2xl md:text-3xl font-bold mb-6">Edit Squad</h1>

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

    {{-- Edit Form --}}
    <form method="POST" action="{{ route('teacher.squads.update', $squad) }}" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Squad Name Field --}}
        <div>
            <label for="name" class="block text-sm font-semibold mb-2">Nama Squad (Maksimal 20 Karakter)</label>
            <div class="flex items-center gap-2">
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $squad->name) }}" 
                    required
                    minlength="3"
                    maxlength="20"
                    class="flex-1 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                    placeholder="Masukkan nama squad (max 20 huruf)"
                >
                <span id="name-count" class="text-gray-600 text-sm whitespace-nowrap">0/20</span>
            </div>
            @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Leader NISN Field --}}
        <div>
            <label for="leader_nisn" class="block text-sm font-semibold mb-2">NISN Leader (10 Angka)</label>
            <input 
                type="text" 
                id="leader_nisn" 
                name="leader_nisn" 
                value="{{ old('leader_nisn', $squad->leaderStudent->nisn ?? '') }}" 
                required
                inputmode="numeric"
                maxlength="10"
                pattern="[0-9]*"
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                placeholder="Masukkan 10 angka NISN leader"
            >
            @error('leader_nisn')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            @if($squad->leaderStudent)
                <p class="text-gray-600 text-xs mt-1">Leader saat ini: <strong>{{ $squad->leaderStudent->name }}</strong> (hanya angka, 10 digit)</p>
            @endif
        </div>

        {{-- Members NISN Field --}}
        <div>
            <label for="members_nisn" class="block text-sm font-semibold mb-2">NISN Anggota (Wajib Ada Minimal 1)</label>
            <textarea 
                id="members_nisn" 
                name="members_nisn" 
                rows="4"
                inputmode="numeric"
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                placeholder="Masukkan NISN anggota (hanya angka), pisahkan dengan koma&#10;Contoh: 1234567890, 0987654321, 1122334455"
            >{{ old('members_nisn', $squad->members_nisn ?? '') }}</textarea>
            @error('members_nisn')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            <p class="text-gray-600 text-xs mt-1">Pisahkan setiap NISN dengan koma (hanya angka, setiap NISN 10 digit)</p>
        </div>

        {{-- Company Name Field --}}
        <div>
            <label for="nama_perusahaan" class="block text-sm font-semibold mb-2">Nama Perusahaan</label>
            <input 
                type="text" 
                id="nama_perusahaan" 
                name="nama_perusahaan" 
                value="{{ old('nama_perusahaan', $squad->nama_perusahaan) }}" 
                maxlength="255"
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
            >{{ old('alamat_perusahaan', $squad->alamat_perusahaan) }}</textarea>
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
                <option value="pengajuan" {{ old('status', $squad->status) == 'pengajuan' ? 'selected' : '' }}>Pengajuan</option>
                <option value="on-progress" {{ old('status', $squad->status) == 'on-progress' ? 'selected' : '' }}>On Progress</option>
                <option value="diterima" {{ old('status', $squad->status) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="unknown" {{ old('status', $squad->status) == 'unknown' ? 'selected' : '' }}>Unknown</option>
            </select>
            @error('status')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Form Buttons --}}
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('teacher.squads.index') }}" class="px-4 py-2 text-gray-700 font-semibold border border-gray-300 rounded hover:bg-gray-100 transition">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    // Character counter for squad name
    const nameInput = document.getElementById('name');
    const nameCount = document.getElementById('name-count');
    
    if (nameInput) {
        nameInput.addEventListener('input', function() {
            nameCount.textContent = this.value.length + '/20';
        });
        
        // Initialize counter on page load
        nameCount.textContent = nameInput.value.length + '/20';
    }
    
    // Only allow numbers for NISN inputs
    const leaderNisn = document.getElementById('leader_nisn');
    const membersNisn = document.getElementById('members_nisn');
    
    if (leaderNisn) {
        leaderNisn.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
    
    if (membersNisn) {
        membersNisn.addEventListener('input', function(e) {
            // Allow only numbers and commas
            this.value = this.value.replace(/[^0-9,\s]/g, '');
        });
    }
</script>

@endsection

