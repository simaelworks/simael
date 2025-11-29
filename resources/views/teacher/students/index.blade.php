@extends('layouts.app')

@section('content')
<div class="mt-4 p-4 md:p-6">
    <h1 class="text-2xl md:text-3xl font-bold mb-6">Siswa/Siswi</h1>

    {{-- Success message after CRUD actions --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- {{-- Top bar: Entries selector and create button --}}
    <div class="flex flex-row items-center justify-between mb-4">
        <div class="flex items-center">
            <form method="GET" class="flex items-center gap-2">
                <select name="per_page" id="per_page" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm focus:ring focus:ring-blue-200">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                </select>
            </form>
        </div>
            <a href="{{ route('teacher.students.create') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm bg-blue-100 bg-opacity-30 hover:bg-blue-200 text-blue-900 font-semibold rounded border-2 border-blue-500 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-300">
            Tambahkan Akun Murid
        </a>
    </div> -->

    {{-- Main layout: Sidebar filters + main student tables --}}
    <div class="flex flex-col gap-6 lg:flex-row lg:gap-4">
            @php $perPage = isset($perPage) ? $perPage : 10; @endphp
        
        {{-- LEFT SIDEBAR: Filters + Statistics --}}
        <div class="w-full lg:w-80 lg:shrink-0 lg:sticky lg:top-20 lg:h-fit">
            <div class="space-y-1 bg-white border rounded p-3 text-sm mb-4">
                <p class="font-semibold text-center mb-2">Filter Jurusan</p>
                <form method="GET" action="" class="space-y-1">
                    <input type="hidden" name="per_page" value="{{ request('per_page', $perPage) }}">
                    <input type="hidden" name="withSquadPage" value="1">
                    <input type="hidden" name="withoutSquadPage" value="1">
                    <button type="submit" name="major" value="ALL" class="w-full flex justify-between px-3 py-2 filter-row transition-colors duration-150
                        {{ $major == 'ALL' ? 'bg-blue-500 text-white font-bold ring-2 ring-blue-300' : 'hover:bg-blue-100 hover:text-blue-900' }}">
                        <span>Semua Jurusan</span>
                        <span class="font-semibold">{{ $jurusanCounts['ALL'] ?? 0 }}</span>
                    </button>
                    <button type="submit" name="major" value="PPLG" class="w-full flex justify-between px-3 py-2 filter-row transition-colors duration-150
                        {{ $major == 'PPLG' ? 'bg-blue-500 text-white font-bold ring-2 ring-blue-300' : 'hover:bg-blue-100 hover:text-blue-900' }}">
                        <span>PPLG</span>
                        <span class="font-semibold">{{ $jurusanCounts['PPLG'] ?? 0 }}</span>
                    </button>
                    <button type="submit" name="major" value="TJKT" class="w-full flex justify-between px-3 py-2 filter-row transition-colors duration-150
                        {{ $major == 'TJKT' ? 'bg-blue-500 text-white font-bold ring-2 ring-blue-300' : 'hover:bg-blue-100 hover:text-blue-900' }}">
                        <span>TJKT</span>
                        <span class="font-semibold">{{ $jurusanCounts['TJKT'] ?? 0 }}</span>
                    </button>
                    <button type="submit" name="major" value="BCF" class="w-full flex justify-between px-3 py-2 filter-row transition-colors duration-150
                        {{ $major == 'BCF' ? 'bg-blue-500 text-white font-bold ring-2 ring-blue-300' : 'hover:bg-blue-100 hover:text-blue-900' }}">
                        <span>BCF</span>
                        <span class="font-semibold">{{ $jurusanCounts['BCF'] ?? 0 }}</span>
                    </button>
                    <button type="submit" name="major" value="DKV" class="w-full flex justify-between px-3 py-2 filter-row transition-colors duration-150
                        {{ $major == 'DKV' ? 'bg-blue-500 text-white font-bold ring-2 ring-blue-300' : 'hover:bg-blue-100 hover:text-blue-900' }}">
                        <span>DKV</span>
                        <span class="font-semibold">{{ $jurusanCounts['DKV'] ?? 0 }}</span>
                    </button>
                </form>
            </div>

            {{-- Statistics summary (auto updates with filter) --}}
            <table class="border border-gray-300 w-full text-sm mt-4">
                <thead class="bg-green-100">
                    <tr>
                        <th colspan="2" class="border border-gray-300 px-3 py-2 text-center font-semibold">
                            Statistik
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 px-3 py-2 font-medium">Akun Verified (dengan squad)</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-approved-with-squad"></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-3 py-2 font-medium">Akun Verified (tanpa squad)</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-approved-without-squad"></td>
                    </tr>
                    <tr class="bg-green-200">
                        <td class="border border-gray-300 px-3 py-2 font-medium">Murid Yang Sudahh Memiliki Squad</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-with-squad"></td>
                    </tr>
                    <tr class="bg-red-200">
                        <td class="border border-gray-300 px-3 py-2 font-medium">Murid Yang Belum Memiliki Squad</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-without-squad"></td>
                    </tr>
                    <tr class="bg-orange-200">
                        <td class="border border-gray-300 px-3 py-2 font-medium">Menunggu konfirmasi akun</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-pending-without-squad"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- RIGHT SIDE: Students tables --}}
        <div class="flex-1 w-full">
            {{-- Entries selector and create button above murid table --}}
            <div class="flex flex-row items-center justify-between mb-4">
                <div class="flex items-center">
                    <form method="GET" class="flex items-center gap-2">
                        <label for="per_page" class="text-sm font-medium mr-2">Entries per page:</label>
                        <select name="per_page" id="per_page" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm focus:ring focus:ring-blue-200">
                            <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </form>
                </div>
                    <a href="{{ route('teacher.students.create') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm bg-blue-100 bg-opacity-30 hover:bg-blue-200 text-blue-900 font-semibold rounded border-2 border-blue-500 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Tambahkan Akun Murid
                </a>
            </div>
            
            {{-- Section 1: students with squad --}}
            <div class="mb-8">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800 bg-green-300 border border-gray-300 px-4 py-2 mb-0">Murid yang sudah memiliki squad</h2>
                
                <div id="tableWithSquadWrapper" class="overflow-x-auto border border-gray-300 border-t-0 rounded-b">
                    <div class="min-w-max">
                        {{-- Main students-with-squad table --}}
                        <table id="tableWithSquad" class="border-collapse w-full text-xs">

                        <thead class="bg-blue-100">
                            <tr>
                                <th class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">ID</th>
                                <th class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">NISN</th>
                                <th class="border border-gray-300 px-2 py-2 text-left whitespace-nowrap">Nama</th>
                                <th class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">Jurusan</th>
                                <th class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">Squad</th>
                                <th class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">Status</th>
                                <th class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">Dibuat</th>
                                <th class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- Loop through paginated students with squads --}}
                            @foreach($studentsWithSquad as $student)
                                <tr class="hover:bg-gray-50 student-row" data-major="{{ $student->major }}" data-has-squad="true">
                                    <td class="border border-gray-300 px-2 py-1 text-center text-xs">{{ $student->id }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center text-xs">{{ $student->nisn }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-left pl-4 min-w-max">{{ $student->name }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center text-xs">{{ $student->major }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center text-xs">
                                        @if($student->squad_id && $student->squad)
                                            <span class="px-2 py-0.5 bg-blue-100 text-blue-800 font-semibold rounded truncate inline-block max-w-xs" title="{{ $student->squad->name }}">{{ $student->squad->name }}</span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1 text-center">
                                        @if($student->status === 'verified')
                                            <span class="px-2 py-0.5 bg-green-100 text-green-800 text-xs font-semibold rounded transition-colors duration-150 hover:bg-green-200">Verified</span>
                                        @else
                                            <form method="POST" action="{{ route('teacher.students.update', $student) }}" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="nisn" value="{{ $student->nisn }}">
                                                <input type="hidden" name="name" value="{{ $student->name }}">
                                                <input type="hidden" name="major" value="{{ $student->major }}">
                                                <input type="hidden" name="status" value="verified">
                                                <button type="submit" class="relative group px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs transition-colors duration-150 hover:bg-yellow-200">
                                                    <span class="group-hover:hidden">pending</span>
                                                    <span class="hidden group-hover:inline text-blue-700">approve?</span>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1 text-center text-xs">{{ $student->created_at->format('d/m/Y') }}</td>
                                    {{-- Actions: view/edit/delete --}}
                                    <td class="border border-gray-300 px-2 py-1 text-center">
                                        <div class="flex gap-1 justify-center">
                                            <a href="{{ route('teacher.students.show', $student) }}" class="px-2 py-0.5 bg-blue-200 hover:bg-blue-300 text-blue-900 text-xs font-medium rounded border border-blue-500 transition">Lihat</a>
                                            <a href="{{ route('teacher.students.edit', $student) }}" class="px-2 py-0.5 bg-blue-200 hover:bg-blue-300 text-blue-900 text-xs font-medium rounded border border-blue-500 transition">Edit</a>
                                            <form method="POST" action="{{ route('teacher.students.destroy', $student) }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin untuk menghapus?');" class="px-2 py-0.5 bg-red-200 hover:bg-red-300 text-red-900 text-xs font-medium rounded border border-red-500 transition">Hapus</button>
                                            </form>
                                        </div>
                                </tr>
                            @endforeach
                            
                            {{-- Empty state row - ALWAYS in DOM, shown/hidden by JS --}}
                            <tr class="empty-state-row" style="display:none;">
                                <td colspan="8" class="border border-gray-300 px-2 py-2 text-center text-xs">
                                    Belum ada murid yang memiliki squad.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-end mt-2">
                        {{ $studentsWithSquad->onEachSide(1)->appends([
                            'per_page' => $perPage,
                            'major' => request('major', 'ALL'),
                            'withoutSquadPage' => request('withoutSquadPage', 1)
                        ])->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>

            {{-- Section 2: students without squad --}}
            <div class="mb-8 mt-8">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800 bg-red-200 border border-gray-300 px-4 py-2 mb-0">Murid yang belum memiliki squad</h2>
                
                <div id="tableWithoutSquadWrapper" class="overflow-x-auto border border-gray-300 border-t-0 rounded-b">
                    <div class="min-w-max">
                        {{-- Main table for students without squads --}}
                        <table id="tableWithoutSquad" class="border-collapse w-full text-xs">
                        <thead class="bg-blue-100">
                            <tr>
                                <th class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">ID</th>
                                <th class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">NISN</th>
                                <th class="border border-gray-300 px-2 py-2 text-left whitespace-nowrap">Nama</th>
                                <th class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">Jurusan</th>
                                <th class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">Squad</th>
                                <th class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">Status</th>
                                <th class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">Dibuat</th>
                                <th class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- Loop through paginated students without squads --}}
                            @foreach($studentsWithoutSquad as $student)
                                <tr class="hover:bg-gray-50 student-row" data-major="{{ $student->major }}" data-has-squad="false">
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->id }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->nisn }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-left pl-4">{{ $student->name }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->major }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center text-xs">
                                        <span class="text-gray-500">-</span>
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1 text-center">
                                        @if($student->status === 'verified')
                                            <span class="px-2 py-0.5 bg-green-100 text-green-800 text-xs font-semibold rounded transition-colors duration-150 hover:bg-green-200">Verified</span>
                                        @else
                                            <form method="POST" action="{{ route('teacher.students.update', $student) }}" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="nisn" value="{{ $student->nisn }}">
                                                <input type="hidden" name="name" value="{{ $student->name }}">
                                                <input type="hidden" name="major" value="{{ $student->major }}">
                                                <input type="hidden" name="status" value="verified">
                                                <button type="submit" class="relative group px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs transition-colors duration-150 hover:bg-yellow-200">
                                                    <span class="group-hover:hidden">pending</span>
                                                    <span class="hidden group-hover:inline text-blue-700">approve?</span>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1 text-center text-xs">{{ $student->created_at->format('d/m/Y') }}</td>

                                    {{-- Action buttons --}}
                                    <td class="border border-gray-300 px-2 py-1 text-center">
                                        <div class="flex gap-1 justify-center">
                                            <a href="{{ route('teacher.students.show', $student) }}" class="px-2 py-0.5 bg-blue-200 hover:bg-blue-300 text-blue-900 text-xs font-medium rounded border border-blue-500 transition">Lihat</a>
                                            <a href="{{ route('teacher.students.edit', $student) }}" class="px-2 py-0.5 bg-blue-200 hover:bg-blue-300 text-blue-900 text-xs font-medium rounded border border-blue-500 transition">Edit</a>

                                            <form method="POST" action="{{ route('teacher.students.destroy', $student) }}" style="display:inline;">
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
                                <td colspan="8" class="border border-gray-300 px-2 py-2 text-center text-xs">
                                    Tidak menemukan murid tanpa squad.
                                </td>
                            </tr>
                        </tbody>

                    </table>
                    <div class="flex justify-end mt-2">
                        {{ $studentsWithoutSquad->onEachSide(1)->appends([
                            'per_page' => $perPage,
                            'major' => request('major', 'ALL'),
                            'withSquadPage' => request('withSquadPage', 1)
                        ])->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- JS for filtering and updating statistics --}}
<script>
    let currentFilter = 'ALL';

    // Called when user selects a major from filter table
    function filterMajor(major) {
        currentFilter = major;

        // Visual highlight on selected filter row
        const filterRows = document.querySelectorAll('.filter-row');
        filterRows.forEach(row => {
            if (row.getAttribute('data-major') === major) {
                row.classList.add('bg-blue-400', 'text-white', 'font-bold');
                row.classList.remove('hover:bg-blue-200', 'text-gray-900');
            } else {
                row.classList.remove('bg-blue-400', 'text-white', 'font-bold');
                row.classList.add('hover:bg-blue-200', 'text-gray-900');
            }
        });

        // Show only students matching the selected major
        const allRows = document.querySelectorAll('.student-row');
        let majorHasWithSquad = false;
        let majorHasWithoutSquad = false;
        allRows.forEach(row => {
            const rowMajor = row.getAttribute('data-major');
            const hasSquad = row.getAttribute('data-has-squad') === 'true';
            const shouldShow = (major === 'ALL' || rowMajor === major);
            row.style.display = shouldShow ? '' : 'none';
            if (shouldShow && hasSquad) majorHasWithSquad = true;
            if (shouldShow && !hasSquad) majorHasWithoutSquad = true;
        });

        // Always show the table wrapper
        document.getElementById('tableWithSquadWrapper').style.display = '';
        document.getElementById('tableWithoutSquadWrapper').style.display = '';

        // Empty state rows
        const withSquadEmpty = document.querySelector('#tableWithSquad tbody tr.empty-state-row');
        if (withSquadEmpty) {
            withSquadEmpty.style.display = majorHasWithSquad ? 'none' : 'table-row';
        }
        const withoutSquadEmpty = document.querySelector('#tableWithoutSquad tbody tr.empty-state-row');
        if (withoutSquadEmpty) {
            withoutSquadEmpty.style.display = majorHasWithoutSquad ? 'none' : 'table-row';
        }

        // Hide pagination if filtered data does not require it
        const perPage = parseInt(document.getElementById('per_page')?.value || '10');
        // With Squad
        const withSquadRows = Array.from(document.querySelectorAll('#tableWithSquad tbody tr.student-row')).filter(row => row.style.display !== 'none');
        const withSquadPagination = document.querySelector('#tableWithSquadWrapper .pagination, #tableWithSquadWrapper nav');
        if (withSquadPagination) {
            if (major !== 'ALL' && withSquadRows.length <= perPage) {
                withSquadPagination.style.display = 'none';
            } else {
                withSquadPagination.style.display = '';
            }
        }
        // Without Squad
        const withoutSquadRows = Array.from(document.querySelectorAll('#tableWithoutSquad tbody tr.student-row')).filter(row => row.style.display !== 'none');
        const withoutSquadPagination = document.querySelector('#tableWithoutSquadWrapper .pagination, #tableWithoutSquadWrapper nav');
        if (withoutSquadPagination) {
            if (major !== 'ALL' && withoutSquadRows.length <= perPage) {
                withoutSquadPagination.style.display = 'none';
            } else {
                withoutSquadPagination.style.display = '';
            }
        }

        // Refresh statistics
        updateStatistics(major);
    }

    // Recalculate statistics using only visible rows (pagination-aware)
    function updateStatistics(major) {
        // Get visible rows for each table
        const withSquadRows = Array.from(document.querySelectorAll('#tableWithSquad tbody tr.student-row')).filter(row => row.style.display !== 'none');
        const withoutSquadRows = Array.from(document.querySelectorAll('#tableWithoutSquad tbody tr.student-row')).filter(row => row.style.display !== 'none');

        // Helper to count status
        function countStatus(rows, status) {
            return rows.filter(row => {
                const cell = row.querySelector('td:nth-child(6) span');
                return cell && cell.textContent.trim().toLowerCase() === status;
            }).length;
        }

        // Statistics for with squad
        const approvedWithSquad = countStatus(withSquadRows, 'verified');
        document.getElementById('stat-approved-with-squad').textContent = approvedWithSquad;
        document.getElementById('stat-with-squad').textContent = withSquadRows.length;

        // Statistics for without squad
        const approvedWithoutSquad = countStatus(withoutSquadRows, 'verified');
        const pendingWithoutSquad = countStatus(withoutSquadRows, 'pending');
        document.getElementById('stat-approved-without-squad').textContent = approvedWithoutSquad;
        document.getElementById('stat-pending-without-squad').textContent = pendingWithoutSquad;
        document.getElementById('stat-without-squad').textContent = withoutSquadRows.length;
    }

    // Load with ALL filter active
    document.addEventListener('DOMContentLoaded', function() {
        filterMajor('ALL');
    });
</script>
@endsection
