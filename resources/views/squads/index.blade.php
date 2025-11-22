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

    {{-- Button to create new squad --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('squads.create') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm bg-blue-100 bg-opacity-30 hover:bg-blue-200 text-blue-900 font-semibold rounded border-2 border-blue-500 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-300">
            Buat Squad Baru
        </a>
    </div>

    {{-- Main layout: Sidebar filters + main squad tables --}}
    <div class="flex flex-col gap-6 lg:flex-row lg:gap-4">
        
        {{-- LEFT SIDEBAR: Filters + Statistics --}}
        <div class="w-full lg:w-80 lg:shrink-0">

            {{-- Filter by status --}}
            <table class="border border-gray-300 w-full text-sm">
                <thead class="bg-blue-100">
                    <tr>
                        <th colspan="2" class="border border-gray-300 px-3 py-2 text-center font-semibold">
                            Filter Berdasarkan Status
                        </th>
                    </tr>
                </thead>

                {{-- Filter rows with clickable actions --}}
                <tbody>
                    {{-- ALL STATUSES --}}
                    <tr class="hover:bg-blue-200 cursor-pointer transition filter-row active-filter bg-blue-300" onclick="filterStatus('ALL')" data-status="ALL">
                        <td class="border border-gray-300 px-3 py-2">Semua Status</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold">
                            {{ count($allSquads) }}
                        </td>
                    </tr>

                    {{-- Individual statuses --}}
                    <tr class="hover:bg-blue-200 cursor-pointer transition filter-row" onclick="filterStatus('pengajuan')" data-status="pengajuan">
                        <td class="border border-gray-300 px-3 py-2">Pengajuan</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold">
                            {{ $allSquads->where('status', 'pengajuan')->count() }}
                        </td>
                    </tr>

                    <tr class="hover:bg-blue-200 cursor-pointer transition filter-row" onclick="filterStatus('on-progress')" data-status="on-progress">
                        <td class="border border-gray-300 px-3 py-2">On Progress</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold">
                            {{ $allSquads->where('status', 'on-progress')->count() }}
                        </td>
                    </tr>

                    <tr class="hover:bg-blue-200 cursor-pointer transition filter-row" onclick="filterStatus('diterima')" data-status="diterima">
                        <td class="border border-gray-300 px-3 py-2">Diterima</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold">
                            {{ $allSquads->where('status', 'diterima')->count() }}
                        </td>
                    </tr>

                    <tr class="hover:bg-blue-200 cursor-pointer transition filter-row" onclick="filterStatus('unknown')" data-status="unknown">
                        <td class="border border-gray-300 px-3 py-2">Unknown</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold">
                            {{ $allSquads->where('status', 'unknown')->count() }}
                        </td>
                    </tr>
                </tbody>
            </table>

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
                            {{ $allSquads->whereNotNull('nama_perusahaan')->count() }}
                        </td>
                    </tr>

                    {{-- Total squads without company --}}
                    <tr>
                        <td class="border border-gray-300 px-3 py-2 font-medium">Total Tidak Memiliki Perusahaan</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-no-company">
                            {{ $allSquads->whereNull('nama_perusahaan')->count() }}
                        </td>
                    </tr>

                    {{-- Total squads --}}
                    <tr class="bg-green-50">
                        <td class="border border-gray-300 px-3 py-2 font-medium">Jumlah Squad</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-total">
                            {{ count($allSquads) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- RIGHT SIDE: Squads cards grid --}}
        <div class="flex-1 overflow-x-auto lg:overflow-x-visible">
            {{-- Heading --}}
            <div class="bg-blue-100 border border-gray-300 px-4 py-3 rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">Daftar Squad</h2>
            </div>

            {{-- Cards Grid - responsive columns --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-b-lg min-h-96">
                {{-- Loop through squads --}}
                @foreach($allSquads as $squad)
                    <div class="squad-row card bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-lg transition hover:border-blue-400 overflow-hidden" data-status="{{ $squad->status }}">
                        {{-- Status Badge --}}
                        <div class="px-4 pt-4 pb-0">
                            <span class="inline-block px-3 py-1 rounded text-xs font-semibold
                                @if($squad->status === 'pengajuan') bg-yellow-200 text-yellow-900
                                @elseif($squad->status === 'on-progress') bg-blue-200 text-blue-900
                                @elseif($squad->status === 'diterima') bg-green-200 text-green-900
                                @else bg-gray-200 text-gray-900
                                @endif
                            ">
                                {{ $squad->status }}
                            </span>
                        </div>

                        {{-- Card Body --}}
                        <div class="px-4 py-3">
                            {{-- Squad Name --}}
                            <h3 class="text-lg font-bold text-gray-800 mb-2 truncate">{{ $squad->name }}</h3>

                            {{-- Squad Info --}}
                            <div class="space-y-2 text-sm text-gray-700 mb-4">
                                <div>
                                    <p class="font-semibold text-gray-600">Leader</p>
                                    @if($squad->leader())
                                        <p class="text-gray-800">{{ $squad->leader()->name }}</p>
                                        <p class="text-xs text-gray-500">NISN: {{ $squad->leader_nisn }}</p>
                                    @else
                                        <p class="text-red-500 text-xs">N/A</p>
                                    @endif
                                </div>

                                <div>
                                    <p class="font-semibold text-gray-600">Jumlah Anggota</p>
                                    <p class="text-gray-800 text-lg font-bold">{{ $squad->memberCount() + 1 }} orang</p>
                                </div>

                                <div>
                                    <p class="font-semibold text-gray-600">Dibuat</p>
                                    <p class="text-gray-800">{{ $squad->created_at->format('d M Y') }}</p>
                                </div>

                                <div>
                                    <p class="font-semibold text-gray-600">Perusahaan</p>
                                    <p class="text-gray-800 text-sm truncate">{{ $squad->nama_perusahaan ?? 'Tidak Ada' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Card Footer - Actions --}}
                        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 flex gap-2">
                            <a href="{{ route('squads.show', $squad) }}" class="flex-1 text-center px-2 py-2 bg-blue-200 hover:bg-blue-300 text-blue-900 text-xs font-medium rounded border border-blue-500 transition">
                                Lihat
                            </a>
                            <a href="{{ route('squads.edit', $squad) }}" class="flex-1 text-center px-2 py-2 bg-blue-200 hover:bg-blue-300 text-blue-900 text-xs font-medium rounded border border-blue-500 transition">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('squads.destroy', $squad) }}" style="display:inline;" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin untuk menghapus?');" class="w-full px-2 py-2 bg-red-200 hover:bg-red-300 text-red-900 text-xs font-medium rounded border border-red-500 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                {{-- Empty state - ALWAYS in DOM, shown/hidden by JS --}}
                <div class="col-span-3 empty-state-row flex items-center justify-center min-h-96" style="display:none;">
                    <p class="text-center text-gray-500 text-sm">Belum ada squad yang sesuai dengan filter.</p>
                </div>

                {{-- Show if no squads at all --}}
                @if(count($allSquads) === 0)
                    <div class="col-span-3 flex items-center justify-center min-h-96">
                        <p class="text-center text-gray-500 text-sm">Belum ada squad. <a href="{{ route('squads.create') }}" class="text-blue-500 font-semibold hover:underline">Buat yang pertama</a></p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- JavaScript for filtering --}}
    <script>
        function filterStatus(status) {
            const cards = document.querySelectorAll('.squad-row.card');
            const emptyRow = document.querySelector('.empty-state-row');
            const filterRows = document.querySelectorAll('.filter-row');
            let visibleCount = 0;

            // Update active filter styling
            filterRows.forEach(row => {
                if (row.getAttribute('data-status') === status) {
                    row.classList.add('active-filter', 'bg-blue-300');
                } else {
                    row.classList.remove('active-filter', 'bg-blue-300');
                }
            });

            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                if (status === 'ALL' || cardStatus === status) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            emptyRow.style.display = visibleCount === 0 ? '' : 'none';
            document.getElementById('stat-filtered').textContent = visibleCount;

            // Update major statistics
            updateMajorStats(status);
        }

        function updateMajorStats(status) {
            const majors = @json($majors);
            majors.forEach(major => {
                let count = 0;
                document.querySelectorAll('.squad-row.card').forEach(card => {
                    if (card.style.display !== 'none') {
                        // Count squads in this major
                        // For now, we'll show 0 as this is simplified
                    }
                });
                document.querySelector('.stat-major-' + major).textContent = count;
            });
        }
    </script>
</div>
@endsection
