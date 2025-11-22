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

    {{-- Button to create new student --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('students.create') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm bg-blue-100 bg-opacity-30 hover:bg-blue-200 text-blue-900 font-semibold rounded border-2 border-blue-500 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-300">
            Tambahkan Akun Murid
        </a>
    </div>

    {{-- Main layout: Sidebar filters + main student tables --}}
    <div class="flex flex-col gap-6 lg:flex-row lg:gap-4">
        
        {{-- LEFT SIDEBAR: Filters + Statistics --}}
        <div class="w-full lg:w-80 lg:shrink-0">

            {{-- Filter by major --}}
            <table class="border border-gray-300 w-full text-sm">
                <thead class="bg-blue-100">
                    <tr>
                        <th colspan="2" class="border border-gray-300 px-3 py-2 text-center font-semibold">
                            Filter Berdasarkan Jurusan
                        </th>
                    </tr>
                </thead>

                {{-- Filter rows with clickable actions --}}
                <tbody>
                    {{--ALL MAJORS: This is the TOTAL STUDENTS function based on the filter --}}
                    <tr class="hover:bg-blue-200 cursor-pointer transition filter-row" onclick="filterMajor('ALL')" data-major="ALL">
                        <td class="border border-gray-300 px-3 py-2">Semua Jurusan</td>
                        <td class="border border-blue-300 px-3 py-2 text-center font-semibold">
                            {{ count($allStudents) }}
                        </td>
                    </tr>

                    {{-- Individual majors --}}
                    <tr class="hover:bg-blue-200 cursor-pointer transition filter-row" onclick="filterMajor('PPLG')" data-major="PPLG">
                        <td class="border border-gray-300 px-3 py-2">PPLG</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold">
                            {{ $allStudents->where('major', 'PPLG')->count() }}
                        </td>
                    </tr>

                    <tr class="hover:bg-blue-200 cursor-pointer transition filter-row" onclick="filterMajor('TJKT')" data-major="TJKT">
                        <td class="border border-gray-300 px-3 py-2">TJKT</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold">
                            {{ $allStudents->where('major', 'TJKT')->count() }}
                        </td>
                    </tr>

                    <tr class="hover:bg-blue-200 cursor-pointer transition filter-row" onclick="filterMajor('BCF')" data-major="BCF">
                        <td class="border border-gray-300 px-3 py-2">BCF</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold">
                            {{ $allStudents->where('major', 'BCF')->count() }}
                        </td>
                    </tr>

                    <tr class="hover:bg-blue-200 cursor-pointer transition filter-row" onclick="filterMajor('DKV')" data-major="DKV">
                        <td class="border border-gray-300 px-3 py-2">DKV</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold">
                            {{ $allStudents->where('major', 'DKV')->count() }}
                        </td>
                    </tr>
                </tbody>
            </table>

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
                    {{-- Count verified students --}}
                    <tr>
                        <td class="border border-gray-300 px-3 py-2 font-medium">Akun Ter-konfirmasi</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-approved">
                            {{ $allStudents->where('status', 'verified')->count() }}
                        </td>
                    </tr>

                    {{-- Count pending students --}}
                    <tr>
                        <td class="border border-gray-300 px-3 py-2 font-medium">Menunggu konfirmasi akun </td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-pending">
                            {{ $allStudents->where('status', 'pending')->count() }}
                        </td>
                    </tr>

                    {{-- Count students with squad --}}
                    <tr class="bg-blue-50">
                        <td class="border border-gray-300 px-3 py-2 font-medium">Murid Memiliki Squad</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-with-squad">
                            0
                        </td>
                    </tr>

                    {{-- Count students without squad --}}
                    <tr class="bg-green-50">
                        <td class="border border-gray-300 px-3 py-2 font-medium">Murid Belum Squad</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-without-squad">
                            0
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- RIGHT SIDE: Students tables --}}
        <div class="flex-1 w-full">
            
            {{-- Section 1: students with squad --}}
            <div class="mb-8">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800 bg-blue-100 border border-gray-300 px-4 py-2 mb-0">Murid yang sudah memiliki squad</h2>
                
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
                            {{-- Loop through students with squads --}}
                            @foreach($allStudents as $student)
                                @if(!is_null($student->squad_id))
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
                                            <span class="px-2 py-0.5 bg-green-100 text-green-800 text-xs font-semibold rounded">Verified</span>
                                        @else
                                            <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded">Pending</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1 text-center text-xs">{{ $student->created_at->format('d/m/Y') }}</td>

                                    {{-- Actions: view/edit/delete --}}
                                    <td class="border border-gray-300 px-2 py-1 text-center">
                                        <div class="flex gap-1 justify-center">
                                            <a href="{{ route('students.show', $student) }}" class="px-2 py-0.5 bg-blue-200 hover:bg-blue-300 text-blue-900 text-xs font-medium rounded border border-blue-500 transition">Lihat</a>
                                            <a href="{{ route('students.edit', $student) }}" class="px-2 py-0.5 bg-blue-200 hover:bg-blue-300 text-blue-900 text-xs font-medium rounded border border-blue-500 transition">Edit</a>

                                            {{-- Delete button --}}
                                            <form method="POST" action="{{ route('students.destroy', $student) }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin untuk menghapus?');" class="px-2 py-0.5 bg-red-200 hover:bg-red-300 text-red-900 text-xs font-medium rounded border border-red-500 transition">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            
                            {{-- Empty state row - ALWAYS in DOM, shown/hidden by JS --}}
                            <tr class="empty-state-row" style="display:none;">
                                <td colspan="8" class="border border-gray-300 px-2 py-2 text-center text-xs">
                                    Belum ada murid yang memiliki squad.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>

            {{-- Section 2: students without squad --}}
            <div class="mb-8">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800 bg-green-100 border border-gray-300 px-4 py-2 mb-0">Murid yang belum memiliki squad</h2>
                
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
                            {{-- Loop through students without squads --}}
                            @foreach($allStudents as $student)
                                @if(is_null($student->squad_id))
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
                                            <span class="px-2 py-0.5 bg-green-100 text-green-800 text-xs font-semibold rounded">Verified</span>
                                        @else
                                            <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded">Pending</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1 text-center text-xs">{{ $student->created_at->format('d/m/Y') }}</td>

                                    {{-- Action buttons --}}
                                    <td class="border border-gray-300 px-2 py-1 text-center">
                                        <div class="flex gap-1 justify-center">
                                            <a href="{{ route('students.show', $student) }}" class="px-2 py-0.5 bg-blue-200 hover:bg-blue-300 text-blue-900 text-xs font-medium rounded border border-blue-500 transition">Lihat</a>
                                            <a href="{{ route('students.edit', $student) }}" class="px-2 py-0.5 bg-blue-200 hover:bg-blue-300 text-blue-900 text-xs font-medium rounded border border-blue-500 transition">Edit</a>

                                            <form method="POST" action="{{ route('students.destroy', $student) }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin untuk menghapus?');" class="px-2 py-0.5 bg-red-200 hover:bg-red-300 text-red-900 text-xs font-medium rounded border border-red-500 transition">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            
                            {{-- Empty state row - ALWAYS in DOM, shown/hidden by JS --}}
                            <tr class="empty-state-row" style="display:none;">
                                <td colspan="8" class="border border-gray-300 px-2 py-2 text-center text-xs">
                                    Tidak menemukan murid tanpa squad.
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

{{-- JS for filtering and updating statistics --}}
<script>
    // Store all students in a JS object for client-side filtering
    const studentsData = {
        ALL: [
            @foreach($allStudents as $student)
            {
                id: {{ $student->id }},
                major: '{{ $student->major }}',
                status: '{{ $student->status }}',
                hasSquad: {{ is_null($student->squad_id) ? 'false' : 'true' }}
            },
            @endforeach
        ]
    };

    let currentFilter = 'ALL';

    // Called when user selects a major from filter table
    function filterMajor(major) {
        currentFilter = major;

        // Visual highlight on selected filter row
        const filterRows = document.querySelectorAll('.filter-row');
        filterRows.forEach(row => {
            if (row.getAttribute('data-major') === major) {
                // Add a class to highlight the active filter.
                row.classList.add('bg-blue-400', 'text-white', 'font-bold');
                row.classList.remove('hover:bg-blue-200', 'text-gray-900');
            } else {
                // Remove highlighting from other filters
                row.classList.remove('bg-blue-400', 'text-white', 'font-bold');
                row.classList.add('hover:bg-blue-200', 'text-gray-900');
            }
        });

        // Show only students matching the selected major
        const allRows = document.querySelectorAll('.student-row');
        allRows.forEach(row => {
            const shouldShow = (major === 'ALL' || row.getAttribute('data-major') === major);
            row.style.display = shouldShow ? '' : 'none';
        });

        // Always show the table wrapper (so the table doesn't disappear if the filter returns 0 rows)
        document.getElementById('tableWithSquadWrapper').style.display = '';
        document.getElementById('tableWithoutSquadWrapper').style.display = '';

        // Check Filter Student Has Squad
        let majorHasWithSquad = false;
        for (let student of studentsData.ALL) {
            if ((major === 'ALL' || student.major === major) && student.hasSquad === true) {
                majorHasWithSquad = true;
                break;
            }
        }
        
        const withSquadEmpty = document.querySelector('#tableWithSquad tbody tr.empty-state-row');
        if (withSquadEmpty) {
            withSquadEmpty.style.display = majorHasWithSquad ? 'none' : 'table-row';
        }

        // Check Filter Student Without Squad
        let majorHasWithoutSquad = false;
        for (let student of studentsData.ALL) {
            if ((major === 'ALL' || student.major === major) && student.hasSquad === false) {
                majorHasWithoutSquad = true;
                break;
            }
        }
        
        const withoutSquadEmpty = document.querySelector('#tableWithoutSquad tbody tr.empty-state-row');
        if (withoutSquadEmpty) {
            withoutSquadEmpty.style.display = majorHasWithoutSquad ? 'none' : 'table-row';
        }

        // Refresh statistics
        updateStatistics(major);
    }

    // Recalculate statistics when filter changes
    function updateStatistics(major) {
        let filteredStudents = major === 'ALL'
            ? studentsData.ALL
            : studentsData.ALL.filter(s => s.major === major);

        const approved = filteredStudents.filter(s => s.status === 'verified').length;
        const pending = filteredStudents.filter(s => s.status === 'pending').length;
        const withSquad = filteredStudents.filter(s => s.hasSquad === true).length;
        const withoutSquad = filteredStudents.filter(s => s.hasSquad === false).length;

        // Update DOM
        document.getElementById('stat-approved').textContent = approved;
        document.getElementById('stat-pending').textContent = pending;
        document.getElementById('stat-with-squad').textContent = withSquad;
        document.getElementById('stat-without-squad').textContent = withoutSquad;
    }

    // Load with ALL filter active
    document.addEventListener('DOMContentLoaded', function() {
        filterMajor('ALL');
    });
</script>
@endsection
