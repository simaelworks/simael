@extends('layouts.app')

@section('content')
<div class="mt-4 p-4 md:p-6">
    <h1 class="text-2xl md:text-3xl font-bold mb-6">Squad</h1>

    {{-- Success message after CRUD actions --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Main layout: Sidebar filters + main squad tables --}}
    <div class="flex flex-col gap-6 lg:flex-row lg:gap-4">
        
        {{-- LEFT SIDEBAR: Filters + Statistics --}}
        <div class="w-full lg:w-80 lg:shrink-0 lg:sticky lg:top-20 lg:h-fit">
            {{-- Filter by status --}}
            <div class="space-y-1 bg-white border rounded p-3 text-sm mb-4">
                <p class="font-semibold text-center mb-2">Filter Berdasarkan Status</p>
                <form method="GET" action="" class="space-y-1">
                    <button type="submit" name="status" value="ALL" class="w-full flex justify-between px-3 py-2 filter-row transition-colors duration-150
                        {{ request('status', 'ALL') == 'ALL' ? 'bg-blue-500 text-white font-bold ring-2 ring-blue-300' : 'hover:bg-blue-100 hover:text-blue-900' }}">
                        <span>Semua Status</span>
                        <span class="font-semibold">{{ count($allSquads) }}</span>
                    </button>
                    <button type="submit" name="status" value="pengajuan" class="w-full flex justify-between px-3 py-2 filter-row transition-colors duration-150
                        {{ request('status', 'ALL') == 'pengajuan' ? 'bg-blue-500 text-white font-bold ring-2 ring-blue-300' : 'hover:bg-blue-100 hover:text-blue-900' }}">
                        <span>Pengajuan</span>
                        <span class="font-semibold">{{ $allSquads->where('status', 'pengajuan')->count() }}</span>
                    </button>
                    <button type="submit" name="status" value="on-progress" class="w-full flex justify-between px-3 py-2 filter-row transition-colors duration-150
                        {{ request('status', 'ALL') == 'on-progress' ? 'bg-blue-500 text-white font-bold ring-2 ring-blue-300' : 'hover:bg-blue-100 hover:text-blue-900' }}">
                        <span>On Progress</span>
                        <span class="font-semibold">{{ $allSquads->where('status', 'on-progress')->count() }}</span>
                    </button>
                    <button type="submit" name="status" value="diterima" class="w-full flex justify-between px-3 py-2 filter-row transition-colors duration-150
                        {{ request('status', 'ALL') == 'diterima' ? 'bg-blue-500 text-white font-bold ring-2 ring-blue-300' : 'hover:bg-blue-100 hover:text-blue-900' }}">
                        <span>Diterima</span>
                        <span class="font-semibold">{{ $allSquads->where('status', 'diterima')->count() }}</span>
                    </button>
                </form>
            </div>
            {{-- Statistics summary (auto updates with filter) --}}
            <table class="border border-gray-300 w-full text-sm mt-4">
                <thead class="bg-green-100">
                    <tr>
                        <th colspan="2" class="border border-gray-300 px-3 py-2 text-center font-semibold">
                            Statistik Squad
                        </th>
                    </tr>
                </thead>

                <tbody>
                    {{-- Total squads with company --}}
                    <tr class="bg-blue-50">
                        <td class="border border-gray-300 px-3 py-2 font-medium">Total Memiliki Perusahaan</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-has-company">
                            {{ $allSquads->whereNotNull('company_name')->count() }}
                        </td>
                    </tr>

                    {{-- Total squads without company --}}
                    <tr class="bg-red-50">
                        <td class="border border-gray-300 px-3 py-2 font-medium">Total Tanpa Perusahaan</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-no-company">
                            {{ $allSquads->whereNull('company_name')->count() }}
                        </td>
                    </tr>
                    <!-- {{-- Total squads --}}
                    <tr class="bg-green-50">
                        <td class="border border-gray-300 px-3 py-2 font-medium">Jumlah Squad</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-total">
                            {{ count($allSquads) }}
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>

        {{-- RIGHT SIDE: Squads cards grouped by status --}}
        <div class="flex-1 w-full overflow-hidden">
            {{-- Top bar: Create button --}}
            <div class="flex flex-row items-center justify-end mb-4">
                <a href="{{ route('teacher.squads.create') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm bg-blue-100 bg-opacity-30 hover:bg-blue-200 text-blue-900 font-semibold rounded border-2 border-blue-500 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Buat Squad Baru
                </a>
            </div>
            
            {{-- Status Container: Pengajuan --}}
            <div class="status-container mb-6" data-status="pengajuan">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800 bg-yellow-200 border border-gray-300 px-4 py-2 mb-0 rounded-t-lg cursor-pointer hover:bg-yellow-300 transition select-none container-header" onclick="toggleContainer(this)">
                    Pengajuan <span class="collapse-icon float-right">▲</span>
                </h2>
                <div class="bg-white border border-gray-300 border-t-0 rounded-b-lg p-4 container-content">
                    <div class="flex gap-4 overflow-x-auto pb-2 squad-grid">
                        <!-- Cards will be populated here by JS -->
                    </div>
                    <div class="empty-state-msg text-center text-gray-500 text-sm py-8" style="display:none;">
                        Belum ada squad dengan status ini.
                    </div>
                </div>
            </div>

            {{-- Status Container: On Progress --}}
            <div class="status-container mb-6" data-status="on-progress">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800 bg-blue-200 border border-gray-300 px-4 py-2 mb-0 rounded-t-lg cursor-pointer hover:bg-blue-300 transition select-none container-header" onclick="toggleContainer(this)">
                    On Progress <span class="collapse-icon float-right">▲</span>
                </h2>
                <div class="bg-white border border-gray-300 border-t-0 rounded-b-lg p-4 container-content">
                    <div class="flex gap-4 overflow-x-auto pb-2 squad-grid">
                        <!-- Cards will be populated here by JS -->
                    </div>
                    <div class="empty-state-msg text-center text-gray-500 text-sm py-8" style="display:none;">
                        Belum ada squad dengan status ini.
                    </div>
                </div>
            </div>

            {{-- Status Container: Diterima --}}
            <div class="status-container mb-6" data-status="diterima">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800 bg-green-200 border border-gray-300 px-4 py-2 mb-0 rounded-t-lg cursor-pointer hover:bg-green-300 transition select-none container-header" onclick="toggleContainer(this)">
                    Diterima <span class="collapse-icon float-right">▲</span>
                </h2>
                <div class="bg-white border border-gray-300 border-t-0 rounded-b-lg p-4 container-content">
                    <div class="flex gap-4 overflow-x-auto pb-2 squad-grid">
                        <!-- Cards will be populated here by JS -->
                    </div>
                    <div class="empty-state-msg text-center text-gray-500 text-sm py-8" style="display:none;">
                        Belum ada squad dengan status ini.
                    </div>
                </div>
            </div>

            {{-- Status Container: Others --}}
            <div class="status-container mb-6" data-status="other">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800 bg-gray-200 border border-gray-300 px-4 py-2 mb-0 rounded-t-lg cursor-pointer hover:bg-gray-300 transition select-none container-header" onclick="toggleContainer(this)">
                    Lainnya <span class="collapse-icon float-right">▲</span>
                </h2>
                <div class="bg-white border border-gray-300 border-t-0 rounded-b-lg p-4 container-content">
                    <div class="flex gap-4 overflow-x-auto pb-2 squad-grid">
                        <!-- Cards will be populated here by JS -->
                    </div>
                    <div class="empty-state-msg text-center text-gray-500 text-sm py-8" style="display:none;">
                        Belum ada squad dengan status ini.
                    </div>
                </div>
            </div>

            {{-- Major Containers (shown when specific status is filtered) --}}
            <div id="major-containers-wrapper" style="display:none;">
                {{-- PPLG Container --}}
                <div class="major-container mb-6" data-major="pplg">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800 bg-blue-200 border border-gray-300 px-4 py-2 mb-0 rounded-t-lg cursor-pointer hover:bg-blue-300 transition select-none container-header" onclick="toggleContainer(this)">
                        PPLG <span class="collapse-icon float-right">▲</span>
                    </h2>
                    <div class="bg-white border border-gray-300 border-t-0 rounded-b-lg p-4 container-content">
                        <div class="flex gap-4 overflow-x-auto pb-2 squad-grid">
                            <!-- Cards will be populated here by JS -->
                        </div>
                        <div class="empty-state-msg text-center text-gray-500 text-sm py-8" style="display:none;">
                            Belum ada squad untuk jurusan ini.
                        </div>
                    </div>
                </div>

                {{-- TJKT Container --}}
                <div class="major-container mb-6" data-major="tjkt">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800 bg-green-200 border border-gray-300 px-4 py-2 mb-0 rounded-t-lg cursor-pointer hover:bg-green-300 transition select-none container-header" onclick="toggleContainer(this)">
                        TJKT <span class="collapse-icon float-right">▲</span>
                    </h2>
                    <div class="bg-white border border-gray-300 border-t-0 rounded-b-lg p-4 container-content">
                        <div class="flex gap-4 overflow-x-auto pb-2 squad-grid">
                            <!-- Cards will be populated here by JS -->
                        </div>
                        <div class="empty-state-msg text-center text-gray-500 text-sm py-8" style="display:none;">
                            Belum ada squad untuk jurusan ini.
                        </div>
                    </div>
                </div>

                {{-- DKV Container --}}
                <div class="major-container mb-6" data-major="dkv">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800 bg-purple-200 border border-gray-300 px-4 py-2 mb-0 rounded-t-lg cursor-pointer hover:bg-purple-300 transition select-none container-header" onclick="toggleContainer(this)">
                        DKV <span class="collapse-icon float-right">▲</span>
                    </h2>
                    <div class="bg-white border border-gray-300 border-t-0 rounded-b-lg p-4 container-content">
                        <div class="flex gap-4 overflow-x-auto pb-2 squad-grid">
                            <!-- Cards will be populated here by JS -->
                        </div>
                        <div class="empty-state-msg text-center text-gray-500 text-sm py-8" style="display:none;">
                            Belum ada squad untuk jurusan ini.
                        </div>
                    </div>
                </div>

                {{-- BCF Container --}}
                <div class="major-container mb-6" data-major="bcf">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800 bg-pink-200 border border-gray-300 px-4 py-2 mb-0 rounded-t-lg cursor-pointer hover:bg-pink-300 transition select-none container-header" onclick="toggleContainer(this)">
                        BCF <span class="collapse-icon float-right">▲</span>
                    </h2>
                    <div class="bg-white border border-gray-300 border-t-0 rounded-b-lg p-4 container-content">
                        <div class="flex gap-4 overflow-x-auto pb-2 squad-grid">
                            <!-- Cards will be populated here by JS -->
                        </div>
                        <div class="empty-state-msg text-center text-gray-500 text-sm py-8" style="display:none;">
                            Belum ada squad untuk jurusan ini.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hidden template for squad cards --}}
        <template id="squadCardTemplate">
            <div class="squad-row card bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-lg transition hover:border-blue-400 overflow-hidden flex-shrink-0 w-80" data-status="">
                {{-- Status Badge --}}
                <div class="px-4 pt-4 pb-0">
                    <span class="inline-block px-3 py-1 rounded text-xs font-semibold status-badge">
                    </span>
                </div>

                {{-- Card Body --}}
                <div class="px-4 py-3">
                    {{-- Squad Name --}}
                    <h3 class="text-lg font-bold text-gray-800 mb-2 truncate squad-name"></h3>

                    {{-- Squad Info --}}
                    <div class="space-y-2 text-sm text-gray-700 mb-4">
                        <div>
                            <p class="font-semibold text-gray-600">Leader</p>
                            <p class="text-gray-800 squad-leader"></p>
                            <p class="text-xs text-gray-500 squad-leader-nisn"></p>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-600">Jumlah Anggota</p>
                            <p class="text-gray-800 text-lg font-bold squad-members"></p>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-600">Perusahaan</p>
                            <p class="text-gray-800 text-sm truncate squad-company"></p>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-600">Dibuat</p>
                            <p class="text-gray-800 squad-date"></p>
                        </div>
                    </div>
                </div>

                {{-- Card Footer - Actions --}}
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 flex gap-2 action-buttons">
                </div>
            </div>
        </template>
    </div>

{{-- JS for filtering and updating statistics --}}
<script>
    let currentFilter = '{{ request("status", "ALL") }}';
    const allSquadsData = @json($allSquads);

    console.log('All squads data:', allSquadsData);

    // Toggle container collapse/expand
    function toggleContainer(headerElement) {
        // Find either status-container or major-container
        const container = headerElement.closest('.status-container') || headerElement.closest('.major-container');
        const content = container.querySelector('.container-content');
        const icon = headerElement.querySelector('.collapse-icon');
        
        container.classList.toggle('collapsed');
        
        if (container.classList.contains('collapsed')) {
            content.style.display = 'none';
            icon.textContent = '▼';
        } else {
            content.style.display = 'block';
            icon.textContent = '▲';
        }
    }

    // Populate cards into status containers on page load
    function populateCards() {
        console.log('populateCards called');
        const template = document.getElementById('squadCardTemplate');
        
        allSquadsData.forEach((squad, index) => {
            const cardClone = template.content.cloneNode(true);
            const cardElement = cardClone.querySelector('.squad-row');
            
            // Set status
            cardElement.setAttribute('data-status', squad.status);
            cardElement.setAttribute('data-squad-id', squad.id);
            
            // Set status badge with appropriate color (do this immediately, not lazy)
            const statusBadge = cardElement.querySelector('.status-badge');
            statusBadge.textContent = squad.status.charAt(0).toUpperCase() + squad.status.slice(1);
            
            if (squad.status === 'pengajuan') {
                statusBadge.className = 'inline-block px-3 py-1 rounded text-xs font-semibold bg-yellow-200 text-yellow-900';
            } else if (squad.status === 'on-progress') {
                statusBadge.className = 'inline-block px-3 py-1 rounded text-xs font-semibold bg-blue-200 text-blue-900';
            } else if (squad.status === 'diterima') {
                statusBadge.className = 'inline-block px-3 py-1 rounded text-xs font-semibold bg-green-200 text-green-900';
            } else {
                statusBadge.className = 'inline-block px-3 py-1 rounded text-xs font-semibold bg-gray-200 text-gray-900';
            }
            
            // Set squad info immediately (not lazy)
            cardElement.querySelector('.squad-name').textContent = squad.name;
            cardElement.querySelector('.squad-leader').textContent = squad.leader ? squad.leader.name : 'N/A';
            cardElement.querySelector('.squad-leader-nisn').textContent = squad.leader ? 'NISN: ' + squad.leader.nisn : '';
            cardElement.querySelector('.squad-members').textContent = squad.users.length + ' orang';
            cardElement.querySelector('.squad-company').textContent = squad.company_name ? squad.company_name : 'Tidak Ada';
            cardElement.querySelector('.squad-date').textContent = new Date(squad.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' });
            
            // Set action buttons (lazy load this part)
            const actionButtons = cardElement.querySelector('.action-buttons');
            actionButtons.innerHTML = `<div class="text-xs text-gray-500">Loading...</div>`;
            cardElement.setAttribute('data-needs-action-render', 'true');
            
            // Determine target container
            let targetStatus = squad.status;
            if (squad.status !== 'pengajuan' && squad.status !== 'on-progress' && squad.status !== 'diterima') {
                targetStatus = 'other';
            }
            
            const targetContainer = document.querySelector(`.status-container[data-status="${targetStatus}"] .squad-grid`);
            if (targetContainer) {
                targetContainer.appendChild(cardClone);
            }
        });

        // Update visibility and statistics
        filterStatus(currentFilter);
        
        // Now set up lazy loading for action buttons
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && entry.target.hasAttribute('data-needs-action-render')) {
                    renderActionButtons(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { rootMargin: '50px' });
        
        document.querySelectorAll('[data-needs-action-render]').forEach(card => {
            observer.observe(card);
        });
    }

    // Render action buttons (lazy loaded)
    function renderActionButtons(cardElement) {
        const squadId = cardElement.getAttribute('data-squad-id');
        const squad = allSquadsData.find(s => s.id == squadId);
        
        if (!squad) return;
        
        const actionButtons = cardElement.querySelector('.action-buttons');
        const showUrl = "{{ route('teacher.squads.show', ['squad' => ':squadId']) }}".replace(':squadId', squad.id);
        const editUrl = "{{ route('teacher.squads.edit', ['squad' => ':squadId']) }}".replace(':squadId', squad.id);
        const destroyUrl = "{{ route('teacher.squads.destroy', ['squad' => ':squadId']) }}".replace(':squadId', squad.id);
        
        actionButtons.innerHTML = `
            <a href="${showUrl}" class="flex-1 text-center px-2 py-2 bg-blue-200 hover:bg-blue-300 text-blue-900 text-xs font-medium rounded border border-blue-500 transition">
                Lihat
            </a>
            <a href="${editUrl}" class="flex-1 text-center px-2 py-2 bg-blue-200 hover:bg-blue-300 text-blue-900 text-xs font-medium rounded border border-blue-500 transition">
                Edit
            </a>
            <form method="POST" action="${destroyUrl}" style="display:inline;" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Yakin untuk menghapus?');" class="w-full px-2 py-2 bg-red-200 hover:bg-red-300 text-red-900 text-xs font-medium rounded border border-red-500 transition">
                    Hapus
                </button>
            </form>
        `;
        
        cardElement.removeAttribute('data-needs-action-render');
    }

    // Called when user selects a status from filter table
    function filterStatus(status) {
        currentFilter = status;

        const statusContainers = document.querySelectorAll('.status-container');
        const majorContainersWrapper = document.getElementById('major-containers-wrapper');

        if (status === 'ALL') {
            // Show status containers, hide major containers
            majorContainersWrapper.style.display = 'none';
            
            const allCards = [];
            statusContainers.forEach(container => {
                const cards = container.querySelectorAll('.squad-row.card');
                const emptyMsg = container.querySelector('.empty-state-msg');
                
                let visibleCards = 0;
                cards.forEach(card => {
                    card.style.display = '';
                    visibleCards++;
                    allCards.push(card);
                });
                
                if (visibleCards === 0) {
                    container.style.display = 'none';
                    if (emptyMsg) emptyMsg.style.display = 'block';
                } else {
                    container.style.display = 'block';
                    if (emptyMsg) emptyMsg.style.display = 'none';
                }
            });
            
            // Re-observe cards for lazy loading
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && entry.target.hasAttribute('data-needs-action-render')) {
                        renderActionButtons(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { rootMargin: '50px' });
            
            allCards.forEach(card => {
                if (card.hasAttribute('data-needs-action-render')) {
                    observer.observe(card);
                }
            });
        } else {
            // Show major containers, hide status containers
            majorContainersWrapper.style.display = 'block';
            statusContainers.forEach(c => c.style.display = 'none');
            
            // Clear major containers
            const majorContainers = majorContainersWrapper.querySelectorAll('.major-container');
            majorContainers.forEach(mc => {
                const grid = mc.querySelector('.squad-grid');
                grid.innerHTML = '';
            });
            
            // Collect all cards with matching status from all status containers
            const matchingCards = [];
            statusContainers.forEach(container => {
                const cards = container.querySelectorAll('.squad-row.card');
                cards.forEach(card => {
                    if (card.getAttribute('data-status') === status) {
                        matchingCards.push(card);
                    }
                });
            });
            
            console.log(`Found ${matchingCards.length} cards with status ${status}`);
            
            // Group matching cards by major and add to major containers
            const groupedByMajor = {
                pplg: [],
                tjkt: [],
                dkv: [],
                bcf: []
            };
            
            matchingCards.forEach(card => {
                const leaderName = card.querySelector('.squad-leader').textContent.trim();
                const squad = allSquadsData.find(s => s.leader && s.leader.name === leaderName);
                
                if (squad && squad.leader) {
                    const major = squad.leader.major.toLowerCase();
                    if (groupedByMajor[major]) {
                        groupedByMajor[major].push(card);
                    }
                }
            });
            
            // Add grouped cards to major containers
            const clonedCards = [];
            Object.keys(groupedByMajor).forEach(major => {
                const majorContainer = majorContainersWrapper.querySelector(`.major-container[data-major="${major}"]`);
                const grid = majorContainer.querySelector('.squad-grid');
                const emptyMsg = majorContainer.querySelector('.empty-state-msg');
                
                if (groupedByMajor[major].length > 0) {
                    groupedByMajor[major].forEach(card => {
                        const clonedCard = card.cloneNode(true);
                        grid.appendChild(clonedCard);
                        clonedCards.push(clonedCard);
                    });
                    majorContainer.style.display = 'block';
                    if (emptyMsg) emptyMsg.style.display = 'none';
                    console.log(`Added ${groupedByMajor[major].length} cards to ${major}`);
                } else {
                    majorContainer.style.display = 'none';
                    if (emptyMsg) emptyMsg.style.display = 'block';
                }
            });
            
            // Re-observe cloned cards for lazy loading
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && entry.target.hasAttribute('data-needs-action-render')) {
                        renderActionButtons(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { rootMargin: '50px' });
            
            clonedCards.forEach(card => {
                if (card.hasAttribute('data-needs-action-render')) {
                    observer.observe(card);
                }
            });
        }

        // Refresh statistics
        updateStatistics(status);
    }

    // Recalculate statistics using only visible cards
    function updateStatistics(status) {
        let totalCards = 0;
        let hasCompany = 0;
        let noCompany = 0;

        const allCards = document.querySelectorAll('.squad-row.card');
        allCards.forEach(card => {
            // Only count cards from status containers (not cloned from major containers)
            const isInStatusContainer = card.closest('.status-container') !== null;
            const isInMajorContainer = card.closest('.major-container') !== null;
            
            // Only count from status containers, not from major containers
            if (!isInMajorContainer) {
                const shouldCount = (status === 'ALL' || card.getAttribute('data-status') === status) && card.style.display !== 'none';
                
                if (shouldCount) {
                    totalCards++;
                    const companyText = card.querySelector('.squad-company').textContent.trim();
                    if (companyText !== 'Tidak Ada') {
                        hasCompany++;
                    } else {
                        noCompany++;
                    }
                }
            }
        });

        // Update DOM
        document.getElementById('stat-has-company').textContent = hasCompany;
        document.getElementById('stat-no-company').textContent = noCompany;
        document.getElementById('stat-total').textContent = totalCards;
    }

    // Load with current filter active
    document.addEventListener('DOMContentLoaded', function() {
        populateCards();
    });
</script>
</div>
@endsection