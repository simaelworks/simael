@extends('layouts.app')

@section('content')
<div>

    <h1>Siswa/Siswi</h1>

    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <div>
        <a href="{{ route('students.create') }}">
            Tambahkan Akun Murid
        </a>
    </div>

    <div>
        
        <div>

            <table>
                <thead>
                    <tr>
                        <th colspan="2">
                            Filter Berdasarkan Jurusan
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr onclick="filterMajor('ALL')" data-major="ALL">
                        <td>ALL MAJOR</td>
                        <td>{{ count($allStudents) }}</td>
                    </tr>

                    <tr onclick="filterMajor('PPLG')" data-major="PPLG">
                        <td>PPLG</td>
                        <td>{{ $allStudents->where('major', 'PPLG')->count() }}</td>
                    </tr>

                    <tr onclick="filterMajor('TJKT')" data-major="TJKT">
                        <td>TJKT</td>
                        <td>{{ $allStudents->where('major', 'TJKT')->count() }}</td>
                    </tr>

                    <tr onclick="filterMajor('BCF')" data-major="BCF">
                        <td>BCF</td>
                        <td>{{ $allStudents->where('major', 'BCF')->count() }}</td>
                    </tr>

                    <tr onclick="filterMajor('DKV')" data-major="DKV">
                        <td>DKV</td>
                        <td>{{ $allStudents->where('major', 'DKV')->count() }}</td>
                    </tr>
                </tbody>
            </table>

            <table>
                <thead>
                    <tr>
                        <th colspan="2">
                            Statistik
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Approved</td>
                        <td id="stat-approved">
                            {{ $allStudents->where('status', 'verified')->count() }}
                        </td>
                    </tr>

                    <tr>
                        <td>Pending</td>
                        <td id="stat-pending">
                            {{ $allStudents->where('status', 'pending')->count() }}
                        </td>
                    </tr>

                    <tr>
                        <td>Total Students</td>
                        <td id="stat-total">
                            {{ count($allStudents) }}
                        </td>
                    </tr>

                    <tr>
                        <td>With Squad</td>
                        <td id="stat-with-squad">
                            {{ count($studentsWithSquad) }}
                        </td>
                    </tr>

                    <tr>
                        <td>Without Squad</td>
                        <td id="stat-without-squad">
                            {{ count($studentsWithoutSquad) }}
                        </td>
                    </tr>

                    <tr>
                        <td>Total Squads</td>
                        <td id="stat-squads">
                            {{ $totalSquads }}
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
