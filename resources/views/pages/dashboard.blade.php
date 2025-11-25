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
                                    <div class="flex gap-5">
                                        <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent shadow mb-3 
                                            @if($squad->status === 'pengajuan') bg-yellow-200 text-yellow-900
                                            @elseif($squad->status === 'on-progress') bg-blue-200 text-blue-900
                                            @elseif($squad->status === 'diterima') bg-green-200 text-green-900
                                            @else bg-gray-200 text-gray-900
                                            @endif
                                        ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-3 h-3 mr-1" aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="m9 12 2 2 4-4"></path>
                                            </svg>
                                            {{ ucfirst($squad->status) }}
                                        </div>
                                        @if ($squad->leader->id == $student->id)
                                        <div id="openModalEditStatus" class="cursor-pointer opacity-50 hover:opacity-100 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </div>
                                        @endif
                                    </div>
                                    <h3 class="text-2xl font-bold text-foreground mb-2">{{ $squad->name }}</h3>
                                    <p class="text-muted-foreground">Leader : {{ $squad->leader->name }}</p>
                                </div>
                                <div class="text-right flex flex-col items-end gap-5">
                                    <form action="{{ route('squads.leave', $squad) }}" method="post">
                                        @csrf
                                        <button>
                                            <svg onclick="confirm('Apakah kamu yakin ingin keluar dari Squad ini?, jika kamu Leader, kamu akan mengeluarkan semua member dari Squad ini.');" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 opacity-50 hover:opacity-100 transition-all cursor-pointer">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                            </svg>
                                        </button>
                                    </form>
                                    <div class="text-right">
                                        <p class="text-sm text-muted-foreground mb-1">Dibuat pada</p>
                                        <p class="text-sm font-medium">22/11/2025</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-between mb-3">
                                <div class="flex gap-5 items-center">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="flex gap-5">
                                            <div>
                                                {{ $squad->company_name ? $squad->company_name : 'Tidak ada perusahaan' }}
                                            </div>
                                            @if ($squad->leader->id == $student->id)
                                            <div id="openModalEditCompany" class="cursor-pointer opacity-50 hover:opacity-100 transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $squad->company_address ? $squad->company_address : '-' }}
                                        </div>
                                    </div>
                                </div>
                                @if ($squad->leader->id == $student->id)
                                <button id="openModalAddAnggota" class="px-3 py-2 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-sm cursor-pointer transition">
                                    Tambah Anggota
                                </button>
                                @endif
                            </div>
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
                                    @foreach ($squad->users as $member)
                                    <div class="flex items-center justify-between p-3 rounded-lg bg-muted/50 hover:bg-muted transition-smooth">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-primary flex items-center justify-center text-primary-foreground font-semibold">{{ $student->id }}</div>
                                            <div>
                                                <p class="font-medium">{{ $member->name }}</p>
                                                @if ($squad->leader_id == $member->id)
                                                <p class="text-xs text-muted-foreground">Leader</p>
                                            </div>
                                        </div>
                                        <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-primary/30 text-primary">Leader</div>
                                                @else
                                                <p class="text-xs text-muted-foreground">Member</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-5">
                                        @if ($squad->leader_id == $student->id)
                                        <form action="{{ route('squads.kick', $member) }}" method="post">
                                            @csrf
                                            <button>
                                                <svg onclick="confirm('Apakah kamu yakin ingin mengeluarkan {{ $member->name }}?');" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 opacity-50 hover:opacity-100 transition-all cursor-pointer">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                        <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-primary/30 text-primary">Member</div>
                                        </div>
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
                        @if ($invite->squad)
                        <div class="flex-1">
                            <h4 class="font-semibold text-lg mb-1">{{ $invite->squad->name }}</h4>
                            <div class="flex items-center gap-4 text-sm text-muted-foreground">
                                <span>Leader: {{ $invite->squad->leader->name }}</span>
                                <span>•</span>
                                <span>{{ count($invite->squad->users) }} anggota</span>
                            </div>
                        </div>
                        @else
                        <div class="flex-1">
                            <h4 class="font-semibold text-lg mb-1">Squad tidak ada atau telah dihapus :(</h4>
                            <div class="flex items-center gap-4 text-sm text-muted-foreground">
                                <span>Leader: -</span>
                            </div>
                        </div>
                        @endif
                        <div class="flex gap-2">
                            @if ($invite->squad)
                            <form action="{{ route('invite.join', $invite) }}" method="post">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-primary-foreground shadow h-8 rounded-md px-3 text-xs bg-success hover:bg-blue-500 hover:text-white cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 mr-1" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg>
                                    Terima
                                </button>
                            </form>
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
                            @else
                        <form action="{{ route('invite.destroy', $invite) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border shadow-sm hover:text-white hover:bg-red-500 h-8 rounded-md px-3 text-xs border-destructive text-destructive hover:bg-destructive/10 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-4 h-4 mr-1" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m15 9-6 6"></path>
                                        <path d="m9 9 6 6"></path>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                            @endif
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
    @if ($squad)
    <div id="modalEditCompany1" data-state="closed" class="hidden fixed inset-0 z-20 bg-black/80 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0" data-aria-hidden="true" aria-hidden="true" style="pointer-events: auto;"></div>
    <div id="modalEditCompany2" class="hidden fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-white p-6 shadow-lg duration-200 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[state=closed]:slide-out-to-left-1/2 data-[state=closed]:slide-out-to-top-[48%] data-[state=open]:slide-in-from-left-1/2 data-[state=open]:slide-in-from-top-[48%] sm:rounded-lg sm:max-w-md" style="pointer-events: auto;">
        
        <div class="flex flex-col space-y-1.5 text-center sm:text-left">
            <h2 id="radix-_r_g_" class="text-lg font-semibold leading-none tracking-tight">Edit Squad Perusahaan</h2>
            <p id="radix-_r_h_" class="text-sm text-muted-foreground">Masukkan informasi Perusahaan PKL yang kamu dan temanmu ingin datangi.</p>
        </div>
        <form action="{{ route('squads.update', $squad) }}" method="post"> 
            @method('PUT')
            @csrf
            <div class="space-y-4 py-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="squadName">Nama Perusahaan</label>
                    <input name="company_name" class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm focus-ring" id="squadName" placeholder="Contoh: Mataer Digital" value="{{ $squad->company_name }}" required>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="squadName">Alamat Perusahaan</label>
                    <textarea name="company_address" rows="3" class="flex w-full rounded-md border border-input bg-transparent px-3 py-2 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm focus-ring" id="squadName" placeholder="Masukkan Alamat">{{ $squad->company_address }}</textarea>
                </div>
            </div>
            
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                <button type="button" id="closeModalEditCompany1" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input shadow-sm hover:bg-red-500 hover:text-white cursor-pointer h-9 px-4 py-2">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-primary-foreground shadow hover:bg-blue-500 hover:text-white cursor-pointer h-9 px-4 py-2 bg-gradient-primary">Simpan</button>
            </div>
            
            <button id="closeModalEditCompany2" type="button" class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none data-[state=open]:bg-accent data-[state=open]:text-muted-foreground">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x h-4 w-4" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
                <span class="sr-only">Close</span>
            </button>
        </form>
    </div>
    <script>
        const modalEditCompany1 = document.getElementById('modalEditCompany1');
        const modalEditCompany2 = document.getElementById('modalEditCompany2');
        const openModalEditCompany = document.getElementById('openModalEditCompany');
        const closeModalEditCompany1 = document.getElementById('closeModalEditCompany1');
        const closeModalEditCompany2 = document.getElementById('closeModalEditCompany2');

        function openModal() {
            modalEditCompany1.classList.remove('hidden');
            modalEditCompany2.classList.remove('hidden');
        }

        function closeModal() {
            modalEditCompany1.classList.add('hidden');
            modalEditCompany2.classList.add('hidden');
        }

        closeModalEditCompany1.addEventListener('click', closeModal);
        closeModalEditCompany2.addEventListener('click', closeModal);
        if (openModalEditCompany) openModalEditCompany.addEventListener('click', openModal);
    </script>

    <div id="modalEditStatus1" data-state="closed" class="hidden fixed inset-0 z-20 bg-black/80 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0" data-aria-hidden="true" aria-hidden="true" style="pointer-events: auto;"></div>
    <div id="modalEditStatus2" class="hidden fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-white p-6 shadow-lg duration-200 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[state=closed]:slide-out-to-left-1/2 data-[state=closed]:slide-out-to-top-[48%] data-[state=open]:slide-in-from-left-1/2 data-[state=open]:slide-in-from-top-[48%] sm:rounded-lg sm:max-w-md" style="pointer-events: auto;">
        
        <div class="flex flex-col space-y-1.5 text-center sm:text-left">
            <h2 id="radix-_r_g_" class="text-lg font-semibold leading-none tracking-tight">Edit Status</h2>
            <p id="radix-_r_h_" class="text-sm text-muted-foreground">Beri tahu guru bagaimana progress penerimaan PKL kalian.</p>
        </div>
        <form action="{{ route('squads.update', $squad) }}" method="post"> 
            @method('PUT')
            @csrf
            <div class="space-y-4 py-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="squadName">Status</label>
                    <select name="status" class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm focus-ring" id="squadName" placeholder="Contoh: Mataer Digital" required>
                        <option value="pengajuan" @if ($squad->status == 'pengajuan')
                            selected
                        @endif>Pengajuan</option>
                        <option value="on-progress" @if ($squad->status == 'on-progress')
                            selected
                        @endif>On-Progress</option>
                        <option value="diterima" @if ($squad->status == 'diterima')
                            selected
                        @endif>Diterima</option>
                    </select>
                </div>
            </div>
            
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                <button type="button" id="closeModalEditStatus1" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input shadow-sm hover:bg-red-500 hover:text-white cursor-pointer h-9 px-4 py-2">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-primary-foreground shadow hover:bg-blue-500 hover:text-white cursor-pointer h-9 px-4 py-2 bg-gradient-primary">Simpan</button>
            </div>
            
            <button id="closeModalEditStatus2" type="button" class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none data-[state=open]:bg-accent data-[state=open]:text-muted-foreground">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x h-4 w-4" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
                <span class="sr-only">Close</span>
            </button>
        </form>
    </div>
    <script>
        const modalEditStatus1 = document.getElementById('modalEditStatus1');
        const modalEditStatus2 = document.getElementById('modalEditStatus2');
        const openModalEditStatus = document.getElementById('openModalEditStatus');
        const closeModalEditStatus1 = document.getElementById('closeModalEditStatus1');
        const closeModalEditStatus2 = document.getElementById('closeModalEditStatus2');

        function openModal() {
            modalEditStatus1.classList.remove('hidden');
            modalEditStatus2.classList.remove('hidden');
        }

        function closeModal() {
            modalEditStatus1.classList.add('hidden');
            modalEditStatus2.classList.add('hidden');
        }

        closeModalEditStatus1.addEventListener('click', closeModal);
        closeModalEditStatus2.addEventListener('click', closeModal);
        if (openModalEditCompany) openModalEditStatus.addEventListener('click', openModal);
    </script>
    @endif
        
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