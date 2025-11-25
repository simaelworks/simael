@extends('layouts.app')

@section('title', 'Pending')

@section('content')
<div class="flex fle-col items-center justify-center p-6">

      <div class="items-center gap-8 max-w-6xl max-lg:max-w-lg w-full">
        <div class="lg:max-w-md w-full">
          <h1 class="text-slate-900 text-3xl font-semibold mb-8">Akun Belum Terverifikasi</h1>
          <label class="text-slate-900 text-sm mb-2 block">Minta Wali Kelas atau Guru untuk memverifikasi akun kamu</label>

          <div class="mt-6">
            <button id="copyLinkButton" type="submit" class="py-3 px-6 text-sm text-white tracking-wide bg-blue-600 hover:bg-blue-700 focus:outline-none cursor-pointer">
              Salin Link Akun
            </button>
            <input id="linkToCopy" type="hidden" value="{{ route('students.show', $student) }}">
          </div>
      </div>
    </div>
    <script>
      document.getElementById('copyLinkButton').addEventListener('click', function() {
        const linkInput = document.getElementById('linkToCopy');
        const link = linkInput.value; // Get the link from the input's value

        navigator.clipboard.writeText(link)
          .then(() => {
            alert('Link copied to clipboard!');
          })
          .catch(err => {
            console.error('Failed to copy link: ', err);
            alert('Failed to copy link. Please try again or copy manually.');
          });
      });
    </script>
@endsection