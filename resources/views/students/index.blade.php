@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Siswa/Siswi</h1>

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
    <div class="flex gap-4">
        
        {{-- LEFT SIDEBAR: Filters + Statistics --}}
        <div class="sticky top-6 h-fit w-80">

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
                    {{-- ALL MAJORS --}}
                    <tr class="hover:bg-blue-200 cursor-pointer transition filter-row" onclick="filterMajor('ALL')" data-major="ALL">
                        <td class="border border-gray-300 px-3 py-2">Semua Jurusan</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold">
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

                    {{-- Total students --}}
                    <tr class="bg-blue-50">
                        <td class="border border-gray-300 px-3 py-2 font-medium">Total Murid</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-total">
                            {{ count($allStudents) }}
                        </td>
                    </tr>

                    {{-- Count students with a squad --}}
                    <tr>
                        <td class="border border-gray-300 px-3 py-2 font-medium">Dalam Squad</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-with-squad">
                            {{ count($studentsWithSquad) }}
                        </td>
                    </tr>

                    {{-- Count students without a squad --}}
                    <tr>
                        <td class="border border-gray-300 px-3 py-2 font-medium">Tanpa Squad</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-without-squad">
                            {{ count($studentsWithoutSquad) }}
                        </td>
                    </tr>

                    {{-- Number of total squads --}}
                    <tr class="bg-green-50">
                        <td class="border border-gray-300 px-3 py-2 font-medium">Jumlah Squads</td>
                        <td class="border border-gray-300 px-3 py-2 text-center font-semibold" id="stat-squads">
                            {{ $totalSquads }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- RIGHT SIDE: Students tables --}}
        <div class="flex-1">

            {{-- Table: students with squad --}}
            <div class="mb-10">
                <div class="flex justify-center">

                    {{-- Main students-with-squad table --}}
                    <table class="border border-gray-300 w-full text-xs table-fixed" id="tableWithSquad">
                        <colgroup>
                            <col style="width:8%">
                            <col style="width:12%">
                            <col style="width:30%">
                            <col style="width:12%">
                            <col style="width:12%">
                            <col style="width:8%">
                            <col style="width:18%">
                        </colgroup>

                        <thead class="bg-blue-100">
                            <tr>
                                <th colspan="7" class="border border-gray-300 px-2 py-2 text-center font-semibold">
                                    Murid yang telah memiliki squad
                                </th>
                            </tr>

                            {{-- Table headings --}}
                            <tr>
                                <th class="border border-gray-300 px-2 py-1 text-center w-10">ID</th>
                                <th class="border border-gray-300 px-2 py-1 text-center w-16">NISN</th>
                                <th class="border border-gray-300 px-2 py-1 text-center flex-1">Nama</th>
                                <th class="border border-gray-300 px-2 py-1 text-center w-16">Jurusan</th>
                                <th class="border border-gray-300 px-2 py-1 text-center w-20">Squad</th>
                                <th class="border border-gray-300 px-2 py-1 text-center w-16">Status</th>
                                <th class="border border-gray-300 px-2 py-1 text-center w-20">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- Loop through students with squads --}}
                            @forelse($studentsWithSquad as $student)
                                <tr class="hover:bg-gray-50 student-row" data-major="{{ $student->major }}">
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->id }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->nisn }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->name }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->major }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->squad->name ?? 'N/A' }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->status }}</td>

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
                            @empty
                                {{-- When no student exists --}}
                                <tr>
                                    <td colspan="7" class="border border-gray-300 px-2 py-2 text-center text-xs">
                                        Belum ada murid yang memiliki squad.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Table: students without squad --}}
            <div>
                <div class="flex justify-center">

                    {{-- Main table for students without squads --}}
                    <table class="border border-gray-300 w-full text-xs table-fixed" id="tableWithoutSquad">
                        <colgroup>
                            <col style="width:8%">
                            <col style="width:12%">
                            <col style="width:30%">
                            <col style="width:12%">
                            <col style="width:12%">
                            <col style="width:8%">
                            <col style="width:18%">
                        </colgroup>

                        <thead class="bg-blue-100">
                            <tr>
                                <th colspan="7" class="border border-gray-300 px-2 py-2 text-center font-semibold">
                                    Murid yang belum memiliki squad
                                </th>
                            </tr>

                            {{-- Table header columns --}}
                            <tr>
                                <th class="border border-gray-300 px-2 py-1 text-center w-10">ID</th>
                                <th class="border border-gray-300 px-2 py-1 text-center w-16">NISN</th>
                                <th class="border border-gray-300 px-2 py-1 text-center flex-1">Nama</th>
                                <th class="border border-gray-300 px-2 py-1 text-center w-16">Major</th>
                                <th class="border border-gray-300 px-2 py-1 text-center w-20">Squad</th>
                                <th class="border border-gray-300 px-2 py-1 text-center w-16">Status</th>
                                <th class="border border-gray-300 px-2 py-1 text-center w-20">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- Loop through students without squads --}}
                            @forelse($studentsWithoutSquad as $student)
                                <tr class="hover:bg-gray-50 student-row" data-major="{{ $student->major }}">
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->id }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->nisn }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->name }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->major }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->squad->name ?? 'N/A' }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $student->status }}</td>

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
                            @empty
                                {{-- If no data exists --}}
                                <tr>
                                    <td colspan="7" class="border border-gray-300 px-2 py-2 text-center text-xs">
                                        Tidak menemukan siswa tanpa squad.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
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
                squad_id: {{ $student->squad_id ?? 'null' }}
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
                row.classList.add('bg-blue-400', 'text-blue', 'font-bold');
                row.classList.remove('hover:bg-blue-200', 'text-gray-900');
            } else {
                row.classList.remove('bg-blue-400', 'text-white', 'font-bold');
                row.classList.add('hover:bg-blue-200', 'text-gray-900');
            }
        });

        // Show only students matching the selected major
        const rows = document.querySelectorAll('.student-row');
        rows.forEach(row => {
            row.style.display = (major === 'ALL' || row.getAttribute('data-major') === major) ? '' : 'none';
        });

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
        const withSquad = filteredStudents.filter(s => s.squad_id !== null).length;
        const withoutSquad = filteredStudents.filter(s => s.squad_id === null).length;
        const total = filteredStudents.length;

        // Unique squad count
        const uniqueSquads = new Set(
            filteredStudents.filter(s => s.squad_id !== null).map(s => s.squad_id)
        ).size;

        // Update DOM
        document.getElementById('stat-approved').textContent = approved;
        document.getElementById('stat-pending').textContent = pending;
        document.getElementById('stat-total').textContent = total;
        document.getElementById('stat-with-squad').textContent = withSquad;
        document.getElementById('stat-without-squad').textContent = withoutSquad;
        document.getElementById('stat-squads').textContent = uniqueSquads;
    }

    // Load with ALL filter active
    document.addEventListener('DOMContentLoaded', function() {
        filterMajor('ALL');
    });
</script>
@endsection
