@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- <h1>Welcome {{ $student['name'] }}</h1>
@if ($squad)
<p>Squad kamu : {{ $squad->name }}</p> 
@else
<p>Kamu belum masuk kedalam squad</p>
@endif
<form action="{{ route('logout') }}" method="post">
    @csrf

    <button type="submit">Logout</button>
</form> --}}
<div class="min-h-screen bg-linear-to-br from-background via-background to-secondary/20">
        <main class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-foreground mb-2">Halo, {{ $student->name }} 👋</h2>
        @if (!$squad)
            <p class="text-muted-foreground">Kamu belum memiliki squad PKL</p>
        </div>
        <div class="rounded-xl text-card-foreground shadow p-8 mb-8 card-shadow border-0 bg-muted/50">
            <div class="text-center py-8">
                <div class="w-20 h-20 rounded-full bg-muted flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users w-10 h-10 text-muted-foreground" aria-hidden="true">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-muted-foreground mb-6">Kamu belum memiliki squad PKL</h3>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button id="openModalCreateSquad" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-primary-foreground shadow hover:bg-blue-500 hover:text-white cursor-pointer h-10 rounded-md px-8 bg-gradient-primary hover:opacity-90 shadow-elegant">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus w-5 h-5 mr-2" aria-hidden="true">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <line x1="19" x2="19" y1="8" y2="14"></line>
                            <line x1="22" x2="16" y1="11" y2="11"></line>
                        </svg>
                        Buat Squad
                    </button>
                    <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border-input shadow-sm hover:bg-accent hover:bg-black hover:text-white h-10 rounded-md px-8 border-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-5 h-5 mr-2" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        Tunggu Undangan Leader
                    </button>
                </div>
            </div>
        </div>
        @else
                        <p class="text-muted-foreground">Kamu adalah bagian dari {{ $squad->name }}</p>
                    </div>
                    <div class="rounded-xl text-card-foreground shadow p-8 mb-8 card-shadow border-0 bg-linear-to-br from-primary/5 to-primary/10">
                        <div>
                            <div class="flex items-start justify-between mb-6">
                                <div>
                                    <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent text-primary-foreground shadow mb-3 bg-primary hover:bg-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-3 h-3 mr-1" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>
                                        Aktif
                                    </div>
                                    <h3 class="text-2xl font-bold text-foreground mb-2">{{ $squad->name }}</h3>
                                    <p class="text-muted-foreground">Leader : {{ $squad->leader->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-muted-foreground mb-1">Dibuat pada</p>
                                    <p class="text-sm font-medium">22/11/2025</p>
                                </div>
                            </div>
                            @if ($squad->leader->id == $student->id)
                            <div class="mb-3 text-right">
                                <button id="openModalAddAnggota" class="px-3 py-2 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-sm cursor-pointer transition">
                                    Tambah Anggota
                                </button>
                            </div>
                            @endif
                            <div class="bg-card rounded-xl p-6 border border-border">
                                <h4 class="font-semibold mb-4 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users w-5 h-5 text-primary" aria-hidden="true">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                    </svg>
                                    Anggota Squad ({{ count($squad->users) }})
                                </h4>
                                <div class="space-y-3">
                                    @foreach ($squad->users as $student)
                                    <div class="flex items-center justify-between p-3 rounded-lg bg-muted/50 hover:bg-muted transition-smooth">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-primary flex items-center justify-center text-primary-foreground font-semibold">{{ $student->id }}</div>
                                            <div>
                                                <p class="font-medium">{{ $student->name }}</p>
                                                @if ($squad->leader_id == $student->id)
                                                <p class="text-xs text-muted-foreground">Leader</p>
                                            </div>
                                        </div>
                                        <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-primary/30 text-primary">Leader</div>
                                                @else
                                                <p class="text-xs text-muted-foreground">Member</p>
                                            </div>
                                        </div>
                                        <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-primary/30 text-primary">Member</div>
                                                @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
        @endif
        @if (!$squad)
        <div>
            <h3 class="text-xl font-semibold mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus w-5 h-5 text-primary" aria-hidden="true">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <line x1="19" x2="19" y1="8" y2="14"></line>
                    <line x1="22" x2="16" y1="11" y2="11"></line>
                </svg>
                Undangan Masuk Squad
            </h3>
            <div class="space-y-3">
                @foreach ($student->invites as $invite)
                <div class="rounded-xl text-card-foreground shadow p-5 card-shadow-hover border-0 bg-card">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex-1">
                            <h4 class="font-semibold text-lg mb-1">{{ $invite->squad->name }}</h4>
                            <div class="flex items-center gap-4 text-sm text-muted-foreground">
                                <span>Leader: {{ $invite->squad->leader->name }}</span>
                                <span>•</span>
                                <span>{{ count($invite->squad->users) }} anggota</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-primary-foreground shadow h-8 rounded-md px-3 text-xs bg-success hover:bg-blue-500 hover:text-white cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 mr-1" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg>
                                Terima
                            </button>
                            <form action="{{ route('invite.destroy', $invite) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border shadow-sm hover:text-white hover:bg-red-500 h-8 rounded-md px-3 text-xs border-destructive text-destructive hover:bg-destructive/10 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-4 h-4 mr-1" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m15 9-6 6"></path>
                                        <path d="m9 9 6 6"></path>
                                    </svg>
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
                    <div class="rounded-xl text-card-foreground shadow p-6 border-0 bg-primary/5 border-l-4 border-l-primary">
                        <div class="flex gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-5 h-5 text-primary" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Status Squad Aktif</h4>
                                <p class="text-sm text-muted-foreground">Kamu sudah tergabung dalam squad. Fitur buat squad dan terima undangan tidak tersedia.</p>
                            </div>
                        </div>
                    </div>
        @endif
    </main>
        
    <div id="modal2" data-state="closed" class="hidden fixed inset-0 z-20 bg-black/80 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0" data-aria-hidden="true" aria-hidden="true" style="pointer-events: auto;"></div>
    <div id="modal1" class="hidden fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-white p-6 shadow-lg duration-200 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[state=closed]:slide-out-to-left-1/2 data-[state=closed]:slide-out-to-top-[48%] data-[state=open]:slide-in-from-left-1/2 data-[state=open]:slide-in-from-top-[48%] sm:rounded-lg sm:max-w-md" style="pointer-events: auto;">
        
        <div class="flex flex-col space-y-1.5 text-center sm:text-left">
            <h2 id="radix-_r_g_" class="text-lg font-semibold leading-none tracking-tight">Buat Squad Baru</h2>
            <p id="radix-_r_h_" class="text-sm text-muted-foreground">Masukkan nama squad PKL yang ingin kamu buat. Kamu akan menjadi leader dari squad ini.</p>
        </div>
        <form action="{{ route('squads.store') }}" method="post"> 
            @csrf
            <div class="space-y-4 py-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="squadName">Nama Squad</label>
                    <input name="name" class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm focus-ring" id="squadName" placeholder="Contoh: Web Dev Squad" value="" required>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="squadName">Deskripsi</label>
                    <input name="description" class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm focus-ring" id="squadName" placeholder="Ini Opsional" value="">
                </div>
            </div>
            
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                <button id="closeModalCreateSquad1" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input shadow-sm hover:bg-red-500 hover:text-white cursor-pointer h-9 px-4 py-2">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-primary-foreground shadow hover:bg-blue-500 hover:text-white cursor-pointer h-9 px-4 py-2 bg-gradient-primary">Buat Squad</button>
            </div>
            
            <button id="closeModalCreateSquad2" type="button" class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none data-[state=open]:bg-accent data-[state=open]:text-muted-foreground">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x h-4 w-4" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
                <span class="sr-only">Close</span>
            </button>
        </form>
    </div>
    <script>
        const modal1 = document.getElementById('modal1');
        const modal2 = document.getElementById('modal2');
        const openModalCreateSquad = document.getElementById('openModalCreateSquad');
        const closeModalCreateSquad1 = document.getElementById('closeModalCreateSquad1');
        const closeModalCreateSquad2 = document.getElementById('closeModalCreateSquad2');

        function openModal() {
            modal1.classList.remove('hidden');
            modal2.classList.remove('hidden');
        }

        function closeModal() {
            modal2.classList.add('hidden');
            modal1.classList.add('hidden');
        }

        closeModalCreateSquad1.addEventListener('click', closeModal);
        closeModalCreateSquad2.addEventListener('click', closeModal);
        if (openModalCreateSquad) openModalCreateSquad.addEventListener('click', openModal);
    </script>

    @if ($squad)
    <div id="modalAddAnggota2" data-state="closed" class="hidden fixed inset-0 z-20 bg-black/80 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0" data-aria-hidden="true" aria-hidden="true" style="pointer-events: auto;"></div>
    <div id="modalAddAnggota1" class="hidden fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-white p-6 shadow-lg duration-200 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[state=closed]:slide-out-to-left-1/2 data-[state=closed]:slide-out-to-top-[48%] data-[state=open]:slide-in-from-left-1/2 data-[state=open]:slide-in-from-top-[48%] sm:rounded-lg sm:max-w-md transition" style="pointer-events: auto;">
        
        <div class="flex flex-col space-y-1.5 text-center sm:text-left">
            <h2 id="radix-_r_g_" class="text-lg font-semibold leading-none tracking-tight">Cari Student</h2>
            <p id="radix-_r_h_" class="text-sm text-muted-foreground">Cari student berdasarkan ID, Nama, Atau NISN</p>
        </div>
            <div class="space-y-4 py-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="squadName">Search</label>
                    <input id="searchStudentInput" class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm focus-ring" id="squadName" placeholder="Cari ID, NISN, atau Nama" value="" required>
                    <div id="search-result" class="max-h-[50dvh] overflow-auto flex flex-col gap-2">
                        <template data-student-template>
                            <div class="flex w-full border py-2 px-3 justify-between rounded-lg items-center">
                                <div>
                                    <div data-student-name class="text-sm"></div>
                                    <div data-student-info class="text-[10px]"></div>
                                </div>
                                    <button data-button class="px-2 py-1 text-sm border bg-blue-500 text-white hover:bg-blue-600 transition-all rounded-lg cursor-pointer">
                                        Invite
                                    </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            
            {{-- <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                <button id="closeModalCreateSquad1" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input shadow-sm hover:bg-red-500 hover:text-white cursor-pointer h-9 px-4 py-2">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-primary-foreground shadow hover:bg-blue-500 hover:text-white cursor-pointer h-9 px-4 py-2 bg-gradient-primary">Buat Squad</button>
            </div> --}}
            
            <button id="closeModalAddAnggota" type="button" class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none data-[state=open]:bg-accent data-[state=open]:text-muted-foreground">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x h-4 w-4" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
                <span class="sr-only">Close</span>
            </button>
    </div>
    <script>
        const modalAddAnggota1 = document.getElementById('modalAddAnggota1');
        const modalAddAnggota2 = document.getElementById('modalAddAnggota2');
        const openModalAddAnggota = document.getElementById('openModalAddAnggota');
        const closeModalAddAnggota = document.getElementById('closeModalAddAnggota');

        function openModal() {
            modalAddAnggota1.classList.remove('hidden');
            modalAddAnggota2.classList.remove('hidden');
        }

        function closeModal() {
            modalAddAnggota1.classList.add('hidden');
            modalAddAnggota2.classList.add('hidden');
        }

        closeModalAddAnggota.addEventListener('click', closeModal);
        if (openModalAddAnggota) openModalAddAnggota.addEventListener('click', openModal);


        const searchInput = document.getElementById('searchStudentInput');
        const studentSearchCardTemplate = document.querySelector('[data-student-template]');
        const searchResultContainer = document.getElementById('search-result');

        searchInput.addEventListener('input', e => {
            value = e.target.value.toLowerCase()

            students.forEach(data => {
                isVisible = data.student.name.toLowerCase().includes(value) || data.student.nisn.toString().includes(value) || data.student.id.toString().includes(value)

                data.element.classList.toggle('hidden', !isVisible)
            })
        })

        function inviteStudent(student_id, btn) {
            console.log('Inviting Student')
            btn.innerHTML = 'Inviting..';

            fetch('{{ route('inviteStudent') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    'squad_id': {{ $squad->id }},
                    'student_id': student_id
                })
            })
            .then(() => {
                btn.classList.remove('bg-blue-500')
                btn.classList.remove('hover:bg-blue-600');
                btn.classList.remove('cursor-pointer');

                btn.classList.add('bg-green-500');
                btn.innerHTML = 'Invited';
                btn.disabled = true;
            })
        }

        @if ($squad)
        fetch('{{ route('getStudent') }}').then(res => res.json()).then(data => {
            students = data.map(student => {
                const card = studentSearchCardTemplate.content.cloneNode(true).children[0];

                const name = card.querySelector('[data-student-name]');
                const info = card.querySelector('[data-student-info]');
                const btn = card.querySelector('[data-button]');

                name.innerHTML = student.name;
                info.innerHTML = 'ID: ' + student.id + '   |   ' + ' NISN: ' + student.nisn;

                if (student.squad_id) {
                    btn.disabled = true
                    btn.innerHTML = 'In Squad'

                    btn.classList.remove('bg-blue-500');
                    btn.classList.remove('hover:bg-blue-600');
                    btn.classList.remove('cursor-pointer');

                    btn.classList.add('bg-gray-500');
                }
                btn.onclick = () => inviteStudent(student.id, btn)

                searchResultContainer.append(card);

                return { student: student, element: card }
            })
        })
        @endif
    </script>

    @endif
</div>

@endsection