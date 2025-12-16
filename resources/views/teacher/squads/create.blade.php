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

    {{-- Create Form --}}
    <form method="POST" action="{{ route('teacher.squads.preview') }}" class="space-y-4">
        @csrf

        {{-- Squad Name Field --}}
        <div>
            <label for="name" class="block text-sm font-semibold mb-2">Nama Squad</label>
            <div class="flex items-center gap-2">
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') ?? session('squad_form_data.name') }}" 
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
            <label for="leader_nisn" class="block text-sm font-semibold mb-2">Leader</label>
            <button type="button" id="openLeaderSearch" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition">
                🔍 Cari Leader
            </button>
            {{-- Display selected leader --}}
            <div id="leader_selected" class="mt-2">
                @if(old('leader_nisn') || session('squad_form_data.leader_nisn'))
                    <div class="bg-green-100 text-green-800 px-3 py-2 rounded flex items-center gap-2 inline-block">
                        <span>{{ old('leader_nisn') ?? session('squad_form_data.leader_nisn') }}</span>
                        <button type="button" onclick="clearLeaderSelection()" class="text-red-600 hover:text-red-800">×</button>
                    </div>
                @endif
            </div>
            {{-- Hidden field for actual leader NISN --}}
            <input type="hidden" id="leader_nisn" name="leader_nisn" value="{{ old('leader_nisn') ?? session('squad_form_data.leader_nisn') ?? '' }}">
            @error('leader_nisn')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Leader Search Modal --}}
        <div id="leaderSearchModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[80vh] overflow-hidden flex flex-col">
                <div class="flex justify-between items-center p-6 border-b flex-shrink-0">
                    <h2 class="text-xl font-semibold">Cari Leader</h2>
                    <button id="closeLeaderSearch" type="button" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex-1 overflow-hidden flex flex-col p-6 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari berdasarkan Nama, NISN, Jurusan, atau ID</label>
                        <input type="text" id="leaderSearchInput" placeholder="Ketik nama, NISN, jurusan, atau ID leader..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div id="leaderSearchResults" class="space-y-2 overflow-y-auto flex-1 min-h-0">
                        <p class="text-gray-500 text-sm">Mulai mengetik untuk mencari leader...</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Members NISN Field (Search Only) --}}
        <div>
            <label for="members_nisn" class="block text-sm font-semibold mb-2">Anggota Squad (Wajib Ada Minimal 1)</label>
            <button type="button" id="openMemberSearch" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition">
                🔍 Cari Anggota
            </button>
            {{-- Hidden field for actual member NISNs --}}
            <input type="hidden" id="members_nisn" name="members_nisn" value="{{ old('members_nisn') ?? session('squad_form_data.members_nisn') ?? '' }}">
            {{-- Display selected members as chips --}}
            <div id="members_display" class="mt-2 flex flex-wrap gap-2">
                @if(old('members_nisn') || session('squad_form_data.members_nisn'))
                    @php
                        $membersList = old('members_nisn') ? explode(',', old('members_nisn')) : (session('squad_form_data.members_nisn') ? explode(',', session('squad_form_data.members_nisn')) : []);
                    @endphp
                    @foreach($membersList as $nisn)
                        @if(trim($nisn))
                            <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded flex items-center gap-2">
                                <span>{{ trim($nisn) }}</span>
                                <button type="button" onclick="removeMember('{{ trim($nisn) }}')" class="text-red-600 hover:text-red-800">×</button>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
            <p id="members_count" class="text-sm text-gray-600 mt-2">Anggota terpilih: <span id="count">0</span></p>
            @error('members_nisn')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Member Search Modal --}}
        <div id="memberSearchModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[80vh] overflow-hidden flex flex-col">
                <div class="flex justify-between items-center p-6 border-b flex-shrink-0">
                    <h2 class="text-xl font-semibold">Cari Anggota Squad</h2>
                    <button id="closeMemberSearch" type="button" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex-1 overflow-hidden flex flex-col p-6 gap-4">
                    <input type="text" id="memberSearchInput" placeholder="Cari berdasarkan nama, NISN, jurusan, atau ID..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 flex-shrink-0">
                    <div id="memberSearchResults" class="space-y-2 overflow-y-auto flex-1 min-h-0">
                        <p class="text-gray-500 text-sm">Mulai mengetik untuk mencari anggota...</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Company Name Field --}}
        <div>
            <label for="company_name" class="block text-sm font-semibold mb-2">Nama Perusahaan</label>
            <input 
                type="text" 
                id="company_name" 
                name="company_name" 
                value="{{ old('company_name') ?? session('squad_form_data.company_name') }}" 
                maxlength="255"
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                placeholder="Masukkan nama perusahaan (opsional)"
            >
            @error('company_name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Company Address Field --}}
        <div>
            <label for="company_address" class="block text-sm font-semibold mb-2">Alamat Perusahaan</label>
            <textarea 
                id="company_address" 
                name="company_address" 
                rows="3"
                maxlength="255"
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                placeholder="Masukkan alamat perusahaan (opsional)"
            >{{ old('company_address') ?? session('squad_form_data.company_address') }}</textarea>
            @error('company_address')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
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
                <option value="pengajuan" {{ (old('status') ?? session('squad_form_data.status')) == 'pengajuan' ? 'selected' : '' }}>Pengajuan</option>
                <option value="on-progress" {{ (old('status') ?? session('squad_form_data.status')) == 'on-progress' ? 'selected' : '' }}>On Progress</option>
                <option value="diterima" {{ (old('status') ?? session('squad_form_data.status')) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="unknown" {{ (old('status') ?? session('squad_form_data.status')) == 'unknown' ? 'selected' : '' }}>Unknown</option>
            </select>
            @error('status')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Form Buttons --}}
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('teacher.squads.index') }}" class="px-4 py-2 text-gray-700 font-semibold border border-gray-300 rounded hover:bg-gray-100 transition">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded transition">
                Lanjut ke Preview
            </button>
        </div>
    </form>
</div>

<script>
    // Get all needed DOM elements
    const leaderNisn = document.getElementById('leader_nisn');
    const membersNisn = document.getElementById('members_nisn');
    
    // Debounce function utility
    function debounce(func, delay) {
        let timeoutId;
        return function (...args) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => func(...args), delay);
        };
    }
    
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

    // Leader Search Functionality
    const openLeaderSearchBtn = document.getElementById('openLeaderSearch');
    const closeLeaderSearchBtn = document.getElementById('closeLeaderSearch');
    const leaderSearchModal = document.getElementById('leaderSearchModal');
    const leaderSearchInput = document.getElementById('leaderSearchInput');
    const leaderSearchResults = document.getElementById('leaderSearchResults');

    openLeaderSearchBtn.addEventListener('click', () => {
        leaderSearchModal.classList.remove('hidden');
        leaderSearchInput.focus();
        // Load all students when modal opens
        loadLeaderResults('');
    });

    closeLeaderSearchBtn.addEventListener('click', () => {
        leaderSearchModal.classList.add('hidden');
        leaderSearchInput.value = '';
    });

    leaderSearchModal.addEventListener('click', (e) => {
        if (e.target === leaderSearchModal) {
            leaderSearchModal.classList.add('hidden');
        }
    });

    async function loadLeaderResults(query) {
        try {
            const response = await fetch(`{{ route('teacher.api.search-students') }}?search=${encodeURIComponent(query)}`);
            const students = await response.json();

            if (students.length === 0) {
                leaderSearchResults.innerHTML = '<p class="text-gray-500 text-sm">Tidak ada siswa yang ditemukan.</p>';
                return;
            }

            leaderSearchResults.innerHTML = students.map(student => {
                const badgeHtml = student.in_squad ? `<span class="ml-2 inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">In Squad</span>` : '';
                const disabledClass = student.unavailable ? 'opacity-50' : '';
                const onclick = student.unavailable ? '' : `onclick="selectLeader('${student.nisn}', '${student.name}')"`;
                
                return `
                    <div class="p-4 border border-gray-200 rounded-lg ${disabledClass} transition ${student.unavailable ? 'cursor-not-allowed' : 'hover:bg-gray-50 cursor-pointer'}" ${onclick}>
                        <p class="font-semibold text-gray-800">${student.name}${badgeHtml}</p>
                        <p class="text-sm text-gray-600">ID: ${student.id} | NISN: ${student.nisn}</p>
                        <p class="text-sm text-gray-600">Jurusan: ${student.major}</p>
                        ${student.squad_name ? `<p class="text-sm text-gray-500">Squad: ${student.squad_name}</p>` : ''}
                    </div>
                `;
            }).join('');
        } catch (error) {
            console.error('Search error:', error);
            leaderSearchResults.innerHTML = '<p class="text-red-500 text-sm">Terjadi kesalahan saat mencari.</p>';
        }
    }

    // Leader search dengan debounce 500ms
    const debouncedLoadLeaderResults = debounce(async (query) => {
        await loadLeaderResults(query);
    }, 500);

    leaderSearchInput.addEventListener('input', async (e) => {
        const query = e.target.value.trim();
        debouncedLoadLeaderResults(query);
    });

    function selectLeader(nisn, name) {
        leaderNisn.value = nisn;
        leaderSearchModal.classList.add('hidden');
        leaderSearchInput.value = '';
        
        // Update selected display
        const leaderSelected = document.getElementById('leader_selected');
        leaderSelected.innerHTML = `<div class="bg-green-100 text-green-800 px-3 py-2 rounded flex items-center gap-2 inline-block">
            <span>${nisn} - ${name}</span>
            <button type="button" onclick="clearLeaderSelection()" class="text-red-600 hover:text-red-800">×</button>
        </div>`;
    }

    function clearLeaderSelection() {
        leaderNisn.value = '';
        const leaderSelected = document.getElementById('leader_selected');
        leaderSelected.innerHTML = '';
    }

    // Member Search Functionality
    const openMemberSearchBtn = document.getElementById('openMemberSearch');
    const closeMemberSearchBtn = document.getElementById('closeMemberSearch');
    const memberSearchModal = document.getElementById('memberSearchModal');
    const memberSearchInput = document.getElementById('memberSearchInput');
    const memberSearchResults = document.getElementById('memberSearchResults');

    openMemberSearchBtn.addEventListener('click', () => {
        memberSearchModal.classList.remove('hidden');
        memberSearchInput.focus();
        // Load all students when modal opens
        loadMemberResults('');
    });

    closeMemberSearchBtn.addEventListener('click', () => {
        memberSearchModal.classList.add('hidden');
        memberSearchInput.value = '';
    });

    memberSearchModal.addEventListener('click', (e) => {
        if (e.target === memberSearchModal) {
            memberSearchModal.classList.add('hidden');
        }
    });

    async function loadMemberResults(query) {
        try {
            const response = await fetch(`{{ route('teacher.api.search-students') }}?search=${encodeURIComponent(query)}`);
            const students = await response.json();

            if (students.length === 0) {
                memberSearchResults.innerHTML = '<p class="text-gray-500 text-sm">Tidak ada siswa yang ditemukan.</p>';
                return;
            }

            memberSearchResults.innerHTML = students.map(student => {
                const badgeHtml = student.in_squad ? `<span class="ml-2 inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">In Squad</span>` : '';
                const disabledClass = student.unavailable ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50';
                const onclick = student.unavailable ? '' : `onclick="selectMember('${student.nisn}')"`;
                
                return `
                    <div class="p-4 border border-gray-200 rounded-lg transition cursor-pointer ${disabledClass}" ${onclick}>
                        <p class="font-semibold text-gray-800">${student.name}${badgeHtml}</p>
                        <p class="text-sm text-gray-600">NISN: ${student.nisn} | ID: ${student.id}</p>
                        <p class="text-sm text-gray-600">Jurusan: ${student.major}</p>
                        ${student.squad_name ? `<p class="text-sm text-gray-500">Squad: ${student.squad_name}</p>` : ''}
                    </div>
                `;
            }).join('');
        } catch (error) {
            console.error('Search error:', error);
            memberSearchResults.innerHTML = '<p class="text-red-500 text-sm">Terjadi kesalahan saat mencari.</p>';
        }
    }

    // Member search dengan debounce 500ms
    const debouncedLoadMemberResults = debounce(async (query) => {
        await loadMemberResults(query);
    }, 500);

    memberSearchInput.addEventListener('input', async (e) => {
        const query = e.target.value.trim();
        debouncedLoadMemberResults(query);
    });

    function selectMember(nisn) {
        const membersNisn = document.getElementById('members_nisn');
        const membersDisplay = document.getElementById('members_display');
        
        // Get current members array
        const currentMembers = membersNisn.value.trim();
        const membersList = currentMembers ? currentMembers.split(',').map(n => n.trim()).filter(n => n) : [];

        // Check if member already exists
        if (membersList.includes(nisn)) {
            alert('Anggota ini sudah ditambahkan');
            return;
        }

        // Add new member
        membersList.push(nisn);
        membersNisn.value = membersList.join(', ');
        
        // Update display chips
        const chip = document.createElement('div');
        chip.className = 'bg-blue-100 text-blue-800 px-3 py-1 rounded flex items-center gap-2';
        chip.innerHTML = `<span>${nisn}</span><button type="button" onclick="removeMember('${nisn}')" class="text-red-600 hover:text-red-800">×</button>`;
        membersDisplay.appendChild(chip);
        
        // Update count
        updateMemberCount();
        
        // Close modal
        memberSearchModal.classList.add('hidden');
        memberSearchInput.value = '';
    }

    function removeMember(nisn) {
        const membersNisn = document.getElementById('members_nisn');
        const membersDisplay = document.getElementById('members_display');
        
        // Get current members array
        const currentMembers = membersNisn.value.trim();
        const membersList = currentMembers ? currentMembers.split(',').map(n => n.trim()).filter(n => n) : [];

        // Remove member
        const index = membersList.indexOf(nisn);
        if (index > -1) {
            membersList.splice(index, 1);
            membersNisn.value = membersList.join(', ');
        }

        // Update display
        const chips = membersDisplay.querySelectorAll('div');
        chips.forEach(chip => {
            if (chip.textContent.includes(nisn)) {
                chip.remove();
            }
        });
        
        // Update count
        updateMemberCount();
    }

    function updateMemberCount() {
        const membersNisn = document.getElementById('members_nisn');
        const currentMembers = membersNisn.value.trim();
        const membersList = currentMembers ? currentMembers.split(',').map(n => n.trim()).filter(n => n) : [];
        document.getElementById('count').textContent = membersList.length;
    }

    // Initialize member count on page load
    updateMemberCount();
</script>

@endsection

