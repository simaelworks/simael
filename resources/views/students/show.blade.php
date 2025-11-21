@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Student Details</h1>

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
            <span class="font-semibold text-gray-700">Name:</span>
            <span class="text-gray-900">{{ $student->name }}</span>
        </div>

        {{-- Major --}}
        <div class="flex justify-between border-b border-gray-200 pb-3">
            <span class="font-semibold text-gray-700">Major:</span>
            <span class="text-gray-900">{{ $student->major }}</span>
        </div>

        {{-- Squad (nullable relationship) --}}
        <div class="flex justify-between border-b border-gray-200 pb-3">
            <span class="font-semibold text-gray-700">Squad:</span>
            <span class="text-gray-900">{{ $student->squad->name ?? 'N/A' }}</span>
        </div>

        {{-- Status Badge --}}
        <div class="flex justify-between border-b border-gray-200 pb-3">
            <span class="font-semibold text-gray-700">Status:</span>

            {{-- Status badge with color depending on value --}}
            <span
                class="px-3 py-1 rounded text-sm font-medium 
                {{ $student->status === 'verified' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ ucfirst($student->status) }}
            </span>
        </div>

        {{-- Created Timestamp --}}
        <div class="flex justify-between border-b border-gray-200 pb-3">
            <span class="font-semibold text-gray-700">Created:</span>
            <span class="text-gray-900">{{ $student->created_at->format('Y-m-d H:i:s') }}</span>
        </div>

        {{-- Updated Timestamp --}}
        <div class="flex justify-between">
            <span class="font-semibold text-gray-700">Updated:</span>
            <span class="text-gray-900">{{ $student->updated_at->format('Y-m-d H:i:s') }}</span>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex gap-3 mt-6">
        {{-- Edit Button --}}
        <a href="{{ route('students.edit', $student) }}" 
            class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-900 font-semibold rounded border-2 border-blue-500 transition">
            Edit
        </a>

        {{-- Back to Student Index --}}
        <a href="{{ route('students.index') }}" 
            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 font-semibold rounded border-2 border-gray-500 transition">
            Back to List
        </a>
    </div>
</div>
@endsection
