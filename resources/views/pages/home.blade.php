@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <!-- Navbar Section -->

    @section('navbar-items')
        <div class="hidden sm:flex sm:items-center sm:space-x-10">
            <a href="#home" class="group relative inline-block text-gray-700 font-medium text-sm transition duration-200 ease-in-out">
                Home
                <span class="absolute left-0 -bottom-1 h-0.5 w-0 bg-black transition-all duration-300 ease-in-out group-hover:w-full"></span>
                </a>
            <a href="#feature" class="group relative inline-block text-gray-700 font-medium text-sm transition duration-200 ease-in-out">
                Feature
                <span class="absolute left-0 -bottom-1 h-0.5 w-0 bg-black transition-all duration-300 ease-in-out group-hover:w-full"></span>
                </a>
            <a href="#about" class="group relative inline-block text-gray-700 font-medium text-sm transition duration-200 ease-in-out">
                About
                <span class="absolute left-0 -bottom-1 h-0.5 w-0 bg-black transition-all duration-300 ease-in-out group-hover:w-full"></span>
                </a>
            <a href="#team-developer" class="group relative inline-block text-gray-700 font-medium text-sm transition duration-200 ease-in-out">
                Developer
                <span class="absolute left-0 -bottom-1 h-0.5 w-0 bg-black transition-all duration-300 ease-in-out group-hover:w-full"></span>
                </a>
        </div>
    @endsection

    <!-- Main Section -->

    <div class="bg-gradient-to-br from-blue-800 to-cyan-700 text-white relative">

        <section id="home" class="pt-32 pb-20 text-white">
            <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center font-stacksans">

                <div data-aos="fade-right">
                    <h2 class="text-5xl font-extrabold leading-tight ">
                        Platform Manajemen PKL yang <span class="text-yellow-300">Modern</span> & Efisien
                    </h2>

                    <p class="mt-4 text-lg opacity-90">
                        Simael membantu sekolah dalam mengelola data pkl, kelompok, dan kerja kelompok dengan cepat dan terintegrasi.
                    </p>

                    <div class="mt-6 flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-yellow-300 text-gray-900 font-semibold rounded-lg shadow hover:bg-gray-200 transition">
                            Login Untuk Murid
                        </a>
                        <a href="{{ route('teacher.login') }}" class="px-6 py-3 bg-transparent border border-yellow-300 text-yellow-300 font-semibold rounded-lg shadow hover:bg-yellow-300 hover:text-gray-900 transition">
                            Login Untuk Guru
                        </a>
                    </div>
                </div>

                <div data-aos="fade-left" class="flex justify-center">
                    <img src="{{ asset('assets/img/simael-logo.webp') }}"
                        class="w-96 md:w-auto max-w-sm drop-shadow-2xl rounded-xl
                        rotate-3 hover:rotate-0 hover:scale-105 transition-all duration-500 ease-in-out">
                </div>
            </div>
        </section>


        <!-- Feature Section -->

        <section id="feature" class="py-25 bg-white text-gray-800">
            <div class="max-w-7xl mx-auto px-6 font-stacksans">

                <h2 class="text-4xl text-center font-bold mb-12">Fitur</h2>

                <div class="grid md:grid-cols-3 gap-8">
                    <div data-aos="zoom-in" class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-3 text-blue-600 font-sans">Dashboard Real-Time</h3>
                        <p class="font-stacksans">Pantau aktivitas siswa dan data penting secara langsung.</p>
                    </div>

                    <div data-aos="zoom-in" class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-3 text-blue-600 font-sans">Manajemen Data Siswa</h3>
                        <p class="font-stacksans">Kelola data siswa dengan sistem yang rapi dan terstruktur.</p>
                    </div>

                    <div data-aos="zoom-in" class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-3 text-blue-600 font-sans">Sistem Squad & Undangan</h3>
                        <p class="font-stacksans">Buat kelompok PKL dan koordinasi kelompok secara mudah.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->

        <section id="about" class="py-30 bg-gray-200 text-gray-800">
            <div class="max-w-5xl mx-auto px-6 text-center font-stacksans" data-aos="fade-up">
                <h2 class="text-4xl font-bold mb-6">Tentang Simael</h2>

                <p class="text-lg leading-relaxed max-w-3xl mx-auto font-stacksans">
                    SIMAEL adalah platform manajemen digital terpadu yang dirancang khusus untuk mengoptimalkan proses Praktek Kerja Lapangan (PKL) di lingkungan sekolah. Mulai dari pendaftaran, penugasan lokasi, pencatatan jurnal harian, hingga penilaian akhir, SIMAEL memastikan seluruh alur PKL berjalan efisien, transparan, dan terintegrasi bagi siswa, guru pembimbing, dan pihak industri.
                </p>
            </div>
        </section>

        <!-- Developer Section -->

        <section id="team-developer" class="py-20 bg-white text-gray-800">
            <div class="max-w-4xl mx-auto px-6 font-stacksans">
                <h2 class="text-4xl font-bold text-center mb-12">Tim Pengembang</h2>
                <div class="grid md:grid-cols-3 gap-20 justify-items-center">

                    <!-- Card 1 -->

                    <div data-aos="fade-up" data-aos-delay="100"
                        class="relative bg-gray-200 p-6 pt-36 rounded-xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-500 ease-in-out text-center w-64">

                        <div class="absolute top-0 left-0 w-full h-36 z-0 rounded-t-xl overflow-hidden">
                            <video autoplay loop muted class="absolute inset-0 w-full h-full object-cover">
                                <source src="{{ asset('assets/video/luffy.webm') }}" 
                                    class="w-full h-full object-cover" type="video/webm">
                            </video>
                        </div>

                        <!-- Profile -->

                        <div class="relative -mt-20 z-10">
                            <img src="{{ asset('assets/img/lutfi-profile.webp') }}" 
                                class="w-36 h-36 rounded-full mx-auto mb-4 object-cover border-4 border-white shadow-lg">
                        </div>

                        <h3 class="text-xl font-semibold mt-2">Lutfi</h3>
                        <p class="text-gray-600">Frontend Developer</p>

                        <a href="https://github.com/ReizeJS" target="_blank" class="mt-2 inline-flex items-center text-black-600 hover:underline">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 0C5.37 0 0 5.37 0 12c0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577
                                    0-.285-.01-1.04-.015-2.04-3.338.726-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.744.083-.729.083-.729
                                    1.205.084 1.84 1.237 1.84 1.237 1.07 1.835 2.807 1.305 3.492.997.108-.775.418-1.305.762-1.605-2.665-.303-5.467-1.333-5.467-5.933
                                    0-1.31.468-2.38 1.235-3.22-.124-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23.957-.266 1.983-.399 3.003-.404
                                    1.02.005 2.047.138 3.006.404 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.873.118 3.176.77.84 1.232 1.91
                                    1.232 3.22 0 4.61-2.807 5.625-5.48 5.922.43.37.823 1.102.823 2.222 0 1.606-.015 2.898-.015 3.293 0 .321.218.694.825.576C20.565
                                    21.796 24 17.303 24 12c0-6.63-5.373-12-12-12z"/>
                            </svg>
                            GitHub
                        </a>
                    </div>
                   
                    <!-- Card 2 -->

                    <div data-aos="fade-up" data-aos-delay="100"
                        class="relative bg-gray-200 p-6 pt-36 rounded-xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-500 ease-in-out text-center w-64 overflow-hidden">

                        <div class="absolute top-0 left-0 w-full h-36 z-0 rounded-t-xl overflow-hidden">
                            <video autoplay loop muted class="absolute inset-0 w-full h-full object-cover">
                                <source src="{{ asset('assets/video/maomao.webm') }}" 
                                    class="w-full h-full object-cover" type="video/webm">
                            </video>
                        </div>

                        <!-- Profile -->

                        <div class="relative -mt-20 z-10">
                            <img src="{{ asset('assets/img/riyandra-profile.webp') }}" 
                                class="w-36 h-36 rounded-full mx-auto mb-4 object-cover border-4 border-white shadow-lg">
                        </div>

                        <h3 class="text-xl font-semibold mt-2">Ry</h3>
                        <p class="text-gray-600">Backend Developer</p>

                        <a href="https://github.com/ry726" target="_blank" class="mt-2 inline-flex items-center text-black-600 hover:underline">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 0C5.37 0 0 5.37 0 12c0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577
                                    0-.285-.01-1.04-.015-2.04-3.338.726-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.744.083-.729.083-.729
                                    1.205.084 1.84 1.237 1.84 1.237 1.07 1.835 2.807 1.305 3.492.997.108-.775.418-1.305.762-1.605-2.665-.303-5.467-1.333-5.467-5.933
                                    0-1.31.468-2.38 1.235-3.22-.124-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23.957-.266 1.983-.399 3.003-.404
                                    1.02.005 2.047.138 3.006.404 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.873.118 3.176.77.84 1.232 1.91
                                    1.232 3.22 0 4.61-2.807 5.625-5.48 5.922.43.37.823 1.102.823 2.222 0 1.606-.015 2.898-.015 3.293 0 .321.218.694.825.576C20.565
                                    21.796 24 17.303 24 12c0-6.63-5.373-12-12-12z"/>
                            </svg>
                            GitHub
                        </a>
                    </div>

                    <!-- Card 3 -->

                    <div data-aos="fade-up" data-aos-delay="100"
                        class="relative bg-gray-200 p-6 pt-36 rounded-xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-500 ease-in-out text-center w-64 overflow-hidden">

                        <div class="absolute top-0 left-0 w-full h-36 z-0 rounded-t-xl overflow-hidden">
                            <video autoplay loop muted class="absolute inset-0 w-full h-full object-cover">
                                <source src="{{ asset('assets/video/kureichi.webm') }}" 
                                    class="w-full h-full object-cover" type="video/webm">
                            </video>
                        </div>

                        <!-- Profile -->

                        <div class="relative -mt-20 z-10">
                            <img src="{{ asset('assets/img/habiburohman-profile.webp') }}" 
                                class="w-36 h-36 rounded-full mx-auto mb-4 object-cover border-4 border-white shadow-lg">
                        </div>

                        <h3 class="text-xl font-semibold mt-2">Abi</h3>
                        <p class="text-gray-600">Backend Developer</p>

                        <a href="https://github.com/Kuredew" target="_blank" class="mt-2 inline-flex items-center text-black-600 hover:underline">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 0C5.37 0 0 5.37 0 12c0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577
                                    0-.285-.01-1.04-.015-2.04-3.338.726-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.744.083-.729.083-.729
                                    1.205.084 1.84 1.237 1.84 1.237 1.07 1.835 2.807 1.305 3.492.997.108-.775.418-1.305.762-1.605-2.665-.303-5.467-1.333-5.467-5.933
                                    0-1.31.468-2.38 1.235-3.22-.124-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23.957-.266 1.983-.399 3.003-.404
                                    1.02.005 2.047.138 3.006.404 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.873.118 3.176.77.84 1.232 1.91
                                    1.232 3.22 0 4.61-2.807 5.625-5.48 5.922.43.37.823 1.102.823 2.222 0 1.606-.015 2.898-.015 3.293 0 .321.218.694.825.576C20.565
                                    21.796 24 17.303 24 12c0-6.63-5.373-12-12-12z"/>
                            </svg>
                            GitHub
                        </a>
                    </div>

                    <!-- Card 4 -->

                    <div data-aos="fade-up" data-aos-delay="100"
                        class="relative bg-gray-200 p-6 pt-36 rounded-xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-500 ease-in-out text-center w-64 overflow-hidden">

                        <div class="absolute top-0 left-0 w-full h-36 z-0 rounded-t-xl overflow-hidden">
                            <video autoplay loop muted class="absolute inset-0 w-full h-full object-cover">
                                <source src="{{ asset('assets/video/wangja.webm') }}" 
                                    class="w-full h-full" type="video/webm">
                            </video>
                        </div>

                        <!-- Profile -->

                        <div class="relative -mt-20 z-10">
                            <img src="{{ asset('assets/img/aufa-profile.webp') }}" 
                                class="w-36 h-36 rounded-full mx-auto mb-4 object-cover border-4 border-white shadow-lg">
                        </div>

                        <h3 class="text-xl font-semibold mt-2">Aufa</h3>
                        <p class="text-gray-600">Frontend Developer</p>

                        <a href="https://github.com/hehehdev" target="_blank" class="mt-2 inline-flex items-center text-black-600 hover:underline">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 0C5.37 0 0 5.37 0 12c0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577
                                    0-.285-.01-1.04-.015-2.04-3.338.726-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.744.083-.729.083-.729
                                    1.205.084 1.84 1.237 1.84 1.237 1.07 1.835 2.807 1.305 3.492.997.108-.775.418-1.305.762-1.605-2.665-.303-5.467-1.333-5.467-5.933
                                    0-1.31.468-2.38 1.235-3.22-.124-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23.957-.266 1.983-.399 3.003-.404
                                    1.02.005 2.047.138 3.006.404 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.873.118 3.176.77.84 1.232 1.91
                                    1.232 3.22 0 4.61-2.807 5.625-5.48 5.922.43.37.823 1.102.823 2.222 0 1.606-.015 2.898-.015 3.293 0 .321.218.694.825.576C20.565
                                    21.796 24 17.303 24 12c0-6.63-5.373-12-12-12z"/>
                            </svg>
                            GitHub
                        </a>
                    </div>

                    <!-- Card 5 -->

                    <div data-aos="fade-up" data-aos-delay="100"
                        class="relative bg-gray-200 p-6 pt-36 rounded-xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-500 ease-in-out text-center w-64 overflow-hidden">

                        <div class="absolute top-0 left-0 w-full h-36 z-0 rounded-t-xl overflow-hidden">
                            <video autoplay loop muted class="absolute inset-0 w-full h-full object-cover">
                                <source src="{{ asset('assets/video/waguri.webm') }}" 
                                    class="w-full h-full" type="video/webm">
                            </video>
                        </div>

                        <!-- Profile -->

                        <div class="relative -mt-20 z-10">
                            <img src="{{ asset('assets/img/kenneth-profile.webp') }}" 
                                class="w-36 h-36 rounded-full mx-auto mb-4 object-cover border-4 border-white shadow-lg">
                        </div>

                        <h3 class="text-xl font-semibold mt-2">Kenneth</h3>
                        <p class="text-gray-600">UI/UX Designer</p>

                        <a href="https://github.com/Caxerion" target="_blank" class="mt-2 inline-flex items-center text-black-600 hover:underline">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 0C5.37 0 0 5.37 0 12c0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577
                                    0-.285-.01-1.04-.015-2.04-3.338.726-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.744.083-.729.083-.729
                                    1.205.084 1.84 1.237 1.84 1.237 1.07 1.835 2.807 1.305 3.492.997.108-.775.418-1.305.762-1.605-2.665-.303-5.467-1.333-5.467-5.933
                                    0-1.31.468-2.38 1.235-3.22-.124-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23.957-.266 1.983-.399 3.003-.404
                                    1.02.005 2.047.138 3.006.404 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.873.118 3.176.77.84 1.232 1.91
                                    1.232 3.22 0 4.61-2.807 5.625-5.48 5.922.43.37.823 1.102.823 2.222 0 1.606-.015 2.898-.015 3.293 0 .321.218.694.825.576C20.565
                                    21.796 24 17.303 24 12c0-6.63-5.373-12-12-12z"/>
                            </svg>
                            GitHub
                        </a>
                    </div>

                    <!-- Card 6 -->

                    <div data-aos="fade-up" data-aos-delay="100"
                        class="relative bg-gray-200 p-6 pt-36 rounded-xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-500 ease-in-out text-center w-64 overflow-hidden">

                        <div class="absolute top-0 left-0 w-full h-36 z-0 rounded-t-xl overflow-hidden">
                            <video autoplay loop muted class="absolute inset-0 w-full h-full object-cover">
                                <source src="{{ asset('assets/video/porsche.webm') }}" 
                                    class="w-full h-full object-cover" type="video/webm">
                            </video>
                        </div>

                        <!-- Profile -->

                        <div class="relative -mt-20 z-10">
                            <img src="{{ asset('assets/img/aziz-profile.webp') }}" 
                                class="w-36 h-36 rounded-full mx-auto mb-4 object-cover border-4 border-white shadow-lg">
                        </div>

                        <h3 class="text-xl font-semibold mt-2">Aziz</h3>
                        <p class="text-gray-600">UI/UX Designer</p>

                        <a href="https://github.com/ry726" target="_blank" class="mt-2 inline-flex items-center text-black-600 hover:underline">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 0C5.37 0 0 5.37 0 12c0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577
                                    0-.285-.01-1.04-.015-2.04-3.338.726-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.744.083-.729.083-.729
                                    1.205.084 1.84 1.237 1.84 1.237 1.07 1.835 2.807 1.305 3.492.997.108-.775.418-1.305.762-1.605-2.665-.303-5.467-1.333-5.467-5.933
                                    0-1.31.468-2.38 1.235-3.22-.124-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23.957-.266 1.983-.399 3.003-.404
                                    1.02.005 2.047.138 3.006.404 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.873.118 3.176.77.84 1.232 1.91
                                    1.232 3.22 0 4.61-2.807 5.625-5.48 5.922.43.37.823 1.102.823 2.222 0 1.606-.015 2.898-.015 3.293 0 .321.218.694.825.576C20.565
                                    21.796 24 17.303 24 12c0-6.63-5.373-12-12-12z"/>
                            </svg>
                            GitHub
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- Footer -->

        <footer class="bg-blue-800 text-white py-6 text-center">
            © 2025 Simael - Sistem Manajemen Pintar PKL
        </footer>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init();

            // Mobile menu toggle

            const mobileBtn = document.getElementById('navbar-items-btn');
            const mobileMenu = document.getElementById('navbar-items');
            // mobileBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
        </script>

    </div>
@endsection