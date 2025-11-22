@extends('layouts.app')

@section('content')

<div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Preview Squad</h1>

    {{-- Squad Information Card --}}
    <div class="bg-white border border-gray-300 rounded shadow-md p-6 mb-6">
        
        {{-- Squad Name --}}
        <div class="mb-4">
            <h2 class="text-2xl font-bold text-blue-600">{{ $validated['name'] }}</h2>
            <p class="text-gray-600 text-sm">Nama Squad</p>
        </div>

        {{-- Status Badge --}}
        <div class="mb-4">
            <span class="px-3 py-1 rounded text-xs font-semibold
                @if($validated['status'] === 'pengajuan') bg-yellow-200 text-yellow-900
                @elseif($validated['status'] === 'on-progress') bg-blue-200 text-blue-900
                @elseif($validated['status'] === 'diterima') bg-green-200 text-green-900
                @else bg-gray-200 text-gray-900
                @endif
            ">
                {{ $validated['status'] }}
            </span>
        </div>

        {{-- Leader Information --}}
        <div class="mb-6 pb-6 border-b border-gray-300">
            <h3 class="text-lg font-semibold mb-3">Leader</h3>
            @if($leader)
                <table class="w-full text-sm">
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 font-medium text-gray-700">Nama</td>
                        <td class="px-3 py-2">{{ $leader->name }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 font-medium text-gray-700">NISN</td>
                        <td class="px-3 py-2">{{ $leader->nisn }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 font-medium text-gray-700">Jurusan</td>
                        <td class="px-3 py-2">{{ $leader->major }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 font-medium text-gray-700">Status</td>
                        <td class="px-3 py-2">{{ $leader->status }}</td>
                    </tr>
                </table>
            @else
                <p class="text-red-500 font-semibold">Leader tidak ditemukan</p>
            @endif
        </div>

        {{-- Members List --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-3">
                Daftar Anggota ({{ count($members) + 1 }} orang total)
            </h3>

            {{-- Invalid NISNs Warning --}}
            @if(!empty($invalidNisns))
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                    <strong>NISN tidak valid:</strong> {{ implode(', ', $invalidNisns) }}
                </div>
            @endif

            {{-- Members Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-3 py-2 text-left font-semibold">No</th>
                            <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Nama</th>
                            <th class="border border-gray-300 px-3 py-2 text-left font-semibold">NISN</th>
                            <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Jurusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Leader --}}
                        <tr class="hover:bg-gray-50 bg-blue-50">
                            <td class="border border-gray-300 px-3 py-2">Leader</td>
                            <td class="border border-gray-300 px-3 py-2 font-semibold">{{ $leader->name }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $leader->nisn }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $leader->major }}</td>
                        </tr>

                        {{-- Members --}}
                        @forelse($members as $index => $member)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-3 py-2">{{ $index + 1 }}</td>
                                <td class="border border-gray-300 px-3 py-2">{{ $member->name }}</td>
                                <td class="border border-gray-300 px-3 py-2">{{ $member->nisn }}</td>
                                <td class="border border-gray-300 px-3 py-2">{{ $member->major }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="border border-gray-300 px-3 py-2 text-center text-gray-500">
                                    Hanya leader (tidak ada anggota lain)
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex justify-between gap-3">
        <a href="{{ route('squads.create') }}" class="px-4 py-2 text-gray-700 font-semibold border border-gray-300 rounded hover:bg-gray-100 transition">
            ← Kembali Edit
        </a>

        <div class="flex gap-3">
            {{-- Cancel Button --}}
            <a href="{{ route('squads.index') }}" class="px-4 py-2 text-gray-700 font-semibold border border-gray-300 rounded hover:bg-gray-100 transition">
                Batal
            </a>

            {{-- Confirm Create Button --}}
            <form method="POST" action="{{ route('squads.store') }}" style="display:inline;">
                @csrf
                <input type="hidden" name="name" value="{{ $validated['name'] }}">
                <input type="hidden" name="leader_nisn" value="{{ $validated['leader_nisn'] }}">
                <input type="hidden" name="members_nisn" value="{{ $validated['members_nisn'] }}">
                <input type="hidden" name="status" value="{{ $validated['status'] }}">
                <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded transition">
                    Buat Squad
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
