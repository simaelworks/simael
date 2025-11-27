@extends('layouts.app')

@section('content')
<div class="mt-4 p-4 md:p-6 max-w-full md:max-w-2xl mx-auto">
    <h1 class="text-2xl md:text-3xl font-bold mb-6">Info Lengkap Murid</h1>

    {{-- Success Message (Shown after update or other success actions) --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Main Details Container --}}
    <div class="border border-gray-300 rounded bg-white p-6 space-y-4">

        {{-- Student ID --}}
        <div class="flex justify-between border-b border-gray-200 pb-3">
            <span class="font-semibold text-gray-700">ID:</span>
            <span class="text-gray-900">{{ $student->id }}</span>
        </div>

        {{-- NISN --}}
        <div class="flex justify-between border-b border-gray-200 pb-3">
            <span class="font-semibold text-gray-700">NISN:</span>
            <span class="text-gray-900">{{ $student->nisn }}</span>
        </div>

        {{-- Student Name --}}
        <div class="flex justify-between border-b border-gray-200 pb-3">
            <span class="font-semibold text-gray-700">Nama:</span>
            <span class="text-gray-900">{{ $student->name }}</span>
        </div>

        {{-- Major --}}
        <div class="flex justify-between border-b border-gray-200 pb-3">
            <span class="font-semibold text-gray-700">Jurusan:</span>
            <span class="text-gray-900">{{ $student->major }}</span>
        </div>

        {{-- Squad --}}
        <div class="flex justify-between border-b border-gray-200 pb-3">
            <span class="font-semibold text-gray-700">Squad:</span>
            <div class="text-right">
                @if($student->squad)
                    <div class="flex gap-2 justify-end flex-wrap">
                        <a href="{{ route('squads.show', $student->squad) }}" class="px-3 py-1 bg-blue-200 hover:bg-blue-300 text-blue-900 text-sm font-semibold rounded border border-blue-500 transition">
                            {{ $student->squad->name }}
                        </a>
                    </div>
                @else
                    <span class="text-gray-500">-</span>
                @endif
            </div>
        </div>

        {{-- Status Badge --}}
        <div class="flex justify-between border-b border-gray-200 pb-3">
            <span class="font-semibold text-gray-700">Status:</span>
            @if($student->status === 'verified')
                <span class="px-2 py-0.5 bg-green-100 text-green-800 text-xs font-semibold rounded transition-colors duration-150 hover:bg-green-200">Verified</span>
            @else
                <form method="POST" action="{{ route('students.update', $student) }}" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="nisn" value="{{ $student->nisn }}">
                    <input type="hidden" name="name" value="{{ $student->name }}">
                    <input type="hidden" name="major" value="{{ $student->major }}">
                    <input type="hidden" name="status" value="verified">
                    <button type="submit" class="relative group px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded transition-colors duration-150 hover:bg-yellow-200">
                        <span class="group-hover:hidden">pending</span>
                        <span class="hidden group-hover:inline text-blue-700">approve?</span>
                    </button>
                </form>
            @endif
        </div>

        {{-- Created Timestamp --}}
        <div class="flex justify-between border-b border-gray-200 pb-3">
            <span class="font-semibold text-gray-700">Akun Dibuat:</span>
            <span class="text-gray-900">{{ $student->created_at->format('Y-m-d H:i:s') }}</span>
        </div>

        {{-- Updated Timestamp --}}
        <div class="flex justify-between">
            <span class="font-semibold text-gray-700">Terakhir Di-update:</span>
            <span class="text-gray-900">{{ $student->updated_at->format('Y-m-d H:i:s') }}</span>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex gap-3 mt-6">
        {{-- Edit Button --}}
        <a href="{{ route('teacher.students.edit', $student) }}"
            class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-900 font-semibold rounded border-2 border-blue-500 transition">
            Edit
        </a>

        {{-- Back to Student Index --}}
        <a href="{{ route('teacher.students.index') }}"
            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 font-semibold rounded border-2 border-gray-500 transition">
            Kembali ke Daftar Murid
        </a>
    </div>
</div>
@endsection
