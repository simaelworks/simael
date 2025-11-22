@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Squad</h1>

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
    <div class="flex gap-4">
        
        {{-- LEFT SIDEBAR: Filters + Statistics --}}
        <div class="sticky top-20 h-fit w-80 z-40">

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
                    <tr class="hover:bg-blue-200 cursor-pointer transition filter-row" onclick="filterStatus('ALL')" data-status="ALL">
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
                    {{-- Total squads --}}
                    <tr class="bg-blue-50">
                        <td class="border border-gray-300 px-3 py-2 font-medium">Total Squad</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-total">
                            {{ count($allSquads) }}
                        </td>
                    </tr>

                    {{-- Breakdown by major --}}
                    @foreach($majors as $major)
                        <tr>
                            <td class="border border-gray-300 px-3 py-2 font-medium">{{ $major }}</td>
                            <td class="border border-gray-300 px-3 py-2 text-center font-semibold stat-major-{{ $major }}">
                                0
                            </td>
                        </tr>
                    @endforeach

                    <tr class="bg-green-50">
                        <td class="border border-gray-300 px-3 py-2 font-medium">Total (Filter)</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-filtered">
                            {{ count($allSquads) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- RIGHT SIDE: Squads table --}}
        <div class="flex-1">
            <div class="flex justify-center">

                {{-- Main squads table --}}
                <table class="border border-gray-300 w-full text-xs table-fixed" id="squadsTable">
                    <colgroup>
                        <col style="width:8%">
                        <col style="width:20%">
                        <col style="width:15%">
                        <col style="width:12%">
                        <col style="width:12%">
                        <col style="width:15%">
                        <col style="width:18%">
                    </colgroup>

                    <thead class="bg-blue-100">
                        <tr>
                            <th colspan="7" class="border border-gray-300 px-2 py-2 text-center font-semibold">
                                Daftar Squad
                            </th>
                        </tr>

                        {{-- Table headings --}}
                        <tr>
                            <th class="border border-gray-300 px-2 py-1 text-center">ID</th>
                            <th class="border border-gray-300 px-2 py-1 text-center">Nama Squad</th>
                            <th class="border border-gray-300 px-2 py-1 text-center">Leader</th>
                            <th class="border border-gray-300 px-2 py-1 text-center">Jumlah Anggota</th>
                            <th class="border border-gray-300 px-2 py-1 text-center">Status</th>
                            <th class="border border-gray-300 px-2 py-1 text-center">Dibuat</th>
                            <th class="border border-gray-300 px-2 py-1 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- Loop through squads --}}
                        @foreach($allSquads as $squad)
                            <tr class="hover:bg-gray-50 squad-row" data-status="{{ $squad->status }}">
                                <td class="border border-gray-300 px-2 py-1 text-center">{{ $squad->id }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-left">{{ $squad->name }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-left">
                                    @if($squad->leader())
                                        {{ $squad->leader()->name }} ({{ $squad->leader_nisn }})
                                    @else
                                        <span class="text-red-500">N/A</span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-2 py-1 text-center">{{ $squad->memberCount() + 1 }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        @if($squad->status === 'pengajuan') bg-yellow-200 text-yellow-900
                                        @elseif($squad->status === 'on-progress') bg-blue-200 text-blue-900
                                        @elseif($squad->status === 'diterima') bg-green-200 text-green-900
                                        @else bg-gray-200 text-gray-900
                                        @endif
                                    ">
                                        {{ $squad->status }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-2 py-1 text-center">{{ $squad->created_at->format('d M Y') }}</td>

                                {{-- Actions: view/edit/delete --}}
                                <td class="border border-gray-300 px-2 py-1 text-center">
                                    <div class="flex gap-1 justify-center">
                                        <a href="{{ route('squads.show', $squad) }}" class="px-2 py-0.5 bg-blue-200 hover:bg-blue-300 text-blue-900 text-xs font-medium rounded border border-blue-500 transition">Lihat</a>
                                        <a href="{{ route('squads.edit', $squad) }}" class="px-2 py-0.5 bg-blue-200 hover:bg-blue-300 text-blue-900 text-xs font-medium rounded border border-blue-500 transition">Edit</a>

                                        {{-- Delete button --}}
                                        <form method="POST" action="{{ route('squads.destroy', $squad) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin untuk menghapus?');" class="px-2 py-0.5 bg-red-200 hover:bg-red-300 text-red-900 text-xs font-medium rounded border border-red-500 transition">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        
                        {{-- Empty state row - ALWAYS in DOM, shown/hidden by JS --}}
                        <tr class="empty-state-row" style="display:none;">
                            <td colspan="7" class="border border-gray-300 px-2 py-2 text-center text-xs">
                                Belum ada squad yang sesuai dengan filter.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- JavaScript for filtering --}}
    <script>
        function filterStatus(status) {
            const rows = document.querySelectorAll('.squad-row');
            const emptyRow = document.querySelector('.empty-state-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                if (status === 'ALL' || rowStatus === status) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
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
                document.querySelectorAll('.squad-row').forEach(row => {
                    if (row.style.display !== 'none') {
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
