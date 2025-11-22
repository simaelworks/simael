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
                    <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-primary-foreground shadow hover:bg-blue-500 hover:text-white cursor-pointer h-10 rounded-md px-8 bg-gradient-primary hover:opacity-90 shadow-elegant">
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
                                    <p class="text-muted-foreground">Leader: {{ $squad->leader->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-muted-foreground mb-1">Dibuat pada</p>
                                    <p class="text-sm font-medium">22/11/2025</p>
                                </div>
                            </div>
                            <div class="bg-card rounded-xl p-6 border border-border">
                                <h4 class="font-semibold mb-4 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users w-5 h-5 text-primary" aria-hidden="true">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                    </svg>
                                    Anggota Squad (2)
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
                <div class="rounded-xl text-card-foreground shadow p-5 card-shadow-hover border-0 bg-card">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex-1">
                            <h4 class="font-semibold text-lg mb-1">Web Dev Squad</h4>
                            <div class="flex items-center gap-4 text-sm text-muted-foreground">
                                <span>Leader: Andi Pratama</span>
                                <span>•</span>
                                <span>3 anggota</span>
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
                            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border shadow-sm hover:text-white hover:bg-red-500 h-8 rounded-md px-3 text-xs border-destructive text-destructive hover:bg-destructive/10 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-4 h-4 mr-1" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m15 9-6 6"></path>
                                    <path d="m9 9 6 6"></path>
                                </svg>
                                Tolak
                            </button>
                        </div>
                    </div>
                </div>
                <div class="rounded-xl text-card-foreground shadow p-5 card-shadow-hover border-0 bg-card">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex-1">
                            <h4 class="font-semibold text-lg mb-1">Mobile App Team</h4>
                            <div class="flex items-center gap-4 text-sm text-muted-foreground">
                                <span>Leader: Siti Rahma</span>
                                <span>•</span>
                                <span>4 anggota</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-primary-foreground shadow h-8 rounded-md px-3 text-xs bg-success hover:bg-success/90">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 mr-1" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg>
                                Terima
                            </button>
                            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border shadow-sm hover:text-accent-foreground h-8 rounded-md px-3 text-xs border-destructive text-destructive hover:bg-destructive/10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-4 h-4 mr-1" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m15 9-6 6"></path>
                                    <path d="m9 9 6 6"></path>
                                </svg>
                                Tolak
                            </button>
                        </div>
                    </div>
                </div>
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
</div>

@endsection