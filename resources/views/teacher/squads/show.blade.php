@extends('layouts.app')

@section('content')

<div class="mt-4 p-4 md:p-6 max-w-full md:max-w-3xl mx-auto">
    <h1 class="text-2xl md:text-3xl font-bold mb-6 max-w-full overflow-hidden text-ellipsis">{{ $squad->name }}</h1>

    {{-- Success message --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Squad Information Card --}}
    <div class="bg-white border border-gray-300 rounded shadow-md p-6 mb-6">
        
        {{-- Status Badge --}}
        <div class="mb-4">
            <span class="px-3 py-1 rounded text-xs font-semibold
                @if($squad->status === 'pengajuan') bg-yellow-200 text-yellow-900
                @elseif($squad->status === 'on-progress') bg-blue-200 text-blue-900
                @elseif($squad->status === 'diterima') bg-green-200 text-green-900
                @else bg-gray-200 text-gray-900
                @endif
            ">
                {{ $squad->status }}
            </span>
        </div>

        {{-- Basic Information --}}
        <div class="mb-6 pb-6 border-b border-gray-300">
            <table class="w-full text-sm">
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2 font-medium text-gray-700 w-32">ID</td>
                    <td class="px-3 py-2">{{ $squad->id }}</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2 font-medium text-gray-700">Nama Squad</td>
                    <td class="px-3 py-2">{{ $squad->name }}</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2 font-medium text-gray-700">Dibuat</td>
                    <td class="px-3 py-2">{{ $squad->created_at->format('d M Y H:i') }}</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2 font-medium text-gray-700">Diperbarui</td>
                    <td class="px-3 py-2">{{ $squad->updated_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>

        {{-- Leader Information --}}
        <div class="mb-6 pb-6 border-b border-gray-300">
            <h3 class="text-lg font-semibold mb-3">Leader</h3>
            @if($squad->leader)
                <table class="w-full text-sm">
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 font-medium text-gray-700 w-32">Nama</td>
                        <td class="px-3 py-2">{{ $squad->leader->name }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 font-medium text-gray-700">NISN</td>
                        <td class="px-3 py-2">{{ $squad->leader->nisn }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 font-medium text-gray-700">Jurusan</td>
                        <td class="px-3 py-2">{{ $squad->leader->major }}</td>
                    </tr>
                </table>
            @else
                <p class="text-red-500 font-semibold">Leader tidak ditemukan</p>
            @endif
        </div>

        {{-- Company Information --}}
        <div class="mb-6 pb-6 border-b border-gray-300">
            <h3 class="text-lg font-semibold mb-3">Informasi Perusahaan</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 font-medium text-gray-700 w-40">Nama Perusahaan</td>
                        <td class="px-3 py-2 break-words max-w-xs">{{ $squad->company_name ?? '-' }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 font-medium text-gray-700 w-40">Alamat Perusahaan</td>
                        <td class="px-3 py-2 break-words max-w-2xl whitespace-normal">{{ $squad->company_address ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Members List --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-3">
                Daftar Anggota ({{ count($squad->users) }} orang total)
            </h3>

            {{-- Members Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Role</th>
                            <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Nama</th>
                            <th class="border border-gray-300 px-3 py-2 text-left font-semibold">NISN</th>
                            <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Jurusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Leader --}}
                        @if($squad->leader)
                            <tr class="hover:bg-gray-50 bg-blue-50">
                                <td class="border border-gray-300 px-3 py-2">Leader</td>
                                <td class="border border-gray-300 px-3 py-2 font-semibold">
                                    <a href="{{ route('students.show', $squad->leader) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                        {{ $squad->leader->name }}
                                    </a>
                                </td>
                                <td class="border border-gray-300 px-3 py-2">{{ $squad->leader->nisn }}</td>
                                <td class="border border-gray-300 px-3 py-2">{{ $squad->leader->major }}</td>
                            </tr>
                        @endif

                        {{-- Members --}}
                        @php $memberIndex = 1; @endphp
                        @forelse($squad->users as $member)
                            @if(!$squad->leader || $member->id !== $squad->leader->id)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-3 py-2">{{ $memberIndex++ }}</td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        <a href="{{ route('students.show', $member) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                            {{ $member->name }}
                                        </a>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2">{{ $member->nisn }}</td>
                                    <td class="border border-gray-300 px-3 py-2">{{ $member->major }}</td>
                                </tr>
                            @endif
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
        <a href="{{ route('teacher.squads.index') }}" class="px-4 py-2 text-gray-700 font-semibold border border-gray-300 rounded hover:bg-gray-100 transition">
            ← Kembali
        </a>

        <div class="flex gap-3">
            {{-- Edit Button --}}
            <a href="{{ route('teacher.squads.edit', $squad) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded transition">
                Edit
            </a>

            {{-- Delete Button --}}
            <form method="POST" action="{{ route('teacher.squads.destroy', $squad) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Yakin untuk menghapus squad ini?');" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
