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
    <form method="POST" action="{{ route('teacher.students.update', $student) }}" class="space-y-4">
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

            {{-- Squad Selection --}}
        <div>
            <label for="squad_id" class="block text-sm font-semibold mb-2">Squad (Opsional)</label>
            <div class="flex gap-2">
                <input 
                    type="text" 
                    id="squad_display" 
                    readonly
                    value="{{ $student->squad ? $student->squad->name : 'Pilih Squad' }}" 
                    class="flex-1 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 bg-gray-50"
                >
                <input type="hidden" id="squad_id" name="squad_id" value="{{ old('squad_id', $student->squad_id) }}">
                <button type="button" id="openSquadSearch" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition">
                    🔍 Cari
                </button>
                @if($student->squad)
                    <button type="button" id="clearSquad" class="px-4 py-2 bg-red-500 text-white font-semibold rounded hover:bg-red-600 transition">
                        Hapus
                    </button>
                @endif
            </div>
            @error('squad_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Squad Search Modal --}}
        <div id="squadSearchModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[80vh] overflow-hidden flex flex-col">
                <div class="flex justify-between items-center p-6 border-b flex-shrink-0">
                    <h2 class="text-xl font-semibold">Cari Squad</h2>
                    <button id="closeSquadSearch" type="button" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex-1 overflow-hidden flex flex-col p-6 gap-4">
                    <input type="text" id="squadSearchInput" placeholder="Ketik nama squad..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 flex-shrink-0">
                    <div id="squadSearchResults" class="space-y-2 overflow-y-auto flex-1 min-h-0">
                        <p class="text-gray-500 text-sm">Mulai mengetik untuk mencari squad...</p>
                    </div>
                </div>
            </div>
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

            <a href="{{ route('teacher.students.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 font-semibold rounded border-2 border-gray-500 transition">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    // Debounce function utility
    function debounce(func, delay) {
        let timeoutId;
        return function (...args) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => func(...args), delay);
        };
    }

    const openSquadSearchBtn = document.getElementById('openSquadSearch');
    const closeSquadSearchBtn = document.getElementById('closeSquadSearch');
    const squadSearchModal = document.getElementById('squadSearchModal');
    const squadSearchInput = document.getElementById('squadSearchInput');
    const squadSearchResults = document.getElementById('squadSearchResults');
    const squadIdInput = document.getElementById('squad_id');
    const squadDisplayInput = document.getElementById('squad_display');
    const clearSquadBtn = document.getElementById('clearSquad');

    // Load squad results
    async function loadSquadResults(query) {
        try {
            const response = await fetch(`{{ route('teacher.api.search-squads') }}?search=${encodeURIComponent(query)}`);
            const squads = await response.json();

            if (squads.length === 0) {
                squadSearchResults.innerHTML = '<p class="text-gray-500 text-sm">Tidak ada squad yang ditemukan.</p>';
                return;
            }

            squadSearchResults.innerHTML = squads.map(squad => `
                <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer" onclick="selectSquad(${squad.id}, '${squad.name.replace(/'/g, "\\'")}')" style="cursor: pointer;">
                    <p class="font-semibold text-gray-800">${squad.name}</p>
                    <p class="text-sm text-gray-600">Leader: ${squad.leader ? squad.leader.name : 'N/A'}</p>
                    <p class="text-sm text-gray-600">Anggota: ${squad.users ? squad.users.length : 0} orang</p>
                    <p class="text-sm text-gray-600">Perusahaan: ${squad.company_name ? squad.company_name : 'Belum Ada'}</p>
                </div>
            `).join('');
        } catch (error) {
            console.error('Search error:', error);
            squadSearchResults.innerHTML = '<p class="text-red-500 text-sm">Terjadi kesalahan saat mencari.</p>';
        }
    }

    openSquadSearchBtn.addEventListener('click', () => {
        squadSearchModal.classList.remove('hidden');
        squadSearchInput.focus();
        loadSquadResults('');
    });

    closeSquadSearchBtn.addEventListener('click', () => {
        squadSearchModal.classList.add('hidden');
        squadSearchInput.value = '';
        squadSearchResults.innerHTML = '<p class="text-gray-500 text-sm">Mulai mengetik untuk mencari squad...</p>';
    });

    squadSearchModal.addEventListener('click', (e) => {
        if (e.target === squadSearchModal) {
            squadSearchModal.classList.add('hidden');
        }
    });

    // Search functionality dengan debounce 500ms
    const debouncedLoadSquadResults = debounce(async (query) => {
        await loadSquadResults(query);
    }, 500);

    squadSearchInput.addEventListener('input', async (e) => {
        const query = e.target.value.trim();
        debouncedLoadSquadResults(query);
    });

    function selectSquad(squadId, squadName) {
        squadIdInput.value = squadId;
        squadDisplayInput.value = squadName;
        squadSearchModal.classList.add('hidden');
        squadSearchInput.value = '';
        squadSearchResults.innerHTML = '<p class="text-gray-500 text-sm">Mulai mengetik untuk mencari squad...</p>';
        
        if (!clearSquadBtn) {
            const clearBtn = document.createElement('button');
            clearBtn.type = 'button';
            clearBtn.id = 'clearSquad';
            clearBtn.className = 'px-4 py-2 bg-red-500 text-white font-semibold rounded hover:bg-red-600 transition';
            clearBtn.textContent = 'Hapus';
            clearBtn.onclick = clearSquadSelection;
            squadDisplayInput.parentElement.appendChild(clearBtn);
        }
    }

    function clearSquadSelection(e) {
        e.preventDefault();
        squadIdInput.value = '';
        squadDisplayInput.value = 'Pilih Squad';
        if (clearSquadBtn) clearSquadBtn.remove();
    }

    if (clearSquadBtn) {
        clearSquadBtn.addEventListener('click', clearSquadSelection);
    }
</script>
@endsection
