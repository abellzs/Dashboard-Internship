<!-- resources/views/landing.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Witel Yogya Jateng Selatan</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="svg">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>
</head>

<body class="landing-page">
    <header class="bg-white px-4 sm:px-6 py-5 shadow fixed top-0 w-full z-50" x-data="{ open: false }">
        <div class="w-full flex items-center">
            <!-- KIRI: Hamburger (mobile) -->
            <div class="w-full flex items-start md:hidden">
                <button @click="open=!open" class="text-gray-600 hover:text-black focus:outline-none">
                    <!-- heroicons menu -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>


            <!-- TENGAH: Nav desktop -->
            <nav
                class="flex-1 hidden md:flex justify-center gap-6 text-sm sm:text-base font-medium text-[#667085] mx-auto">
                <a href="#internship" class="flex items-center gap-1 hover:text-black">
                    Internship
                    <img src="{{ asset('images/arrow_down.svg') }}" alt="arrow"
                        class="w-3 h-3 opacity-70 group-hover:opacity-100 transition duration-200">
                </a>
                <a href="#benefit" class="flex items-center gap-1 hover:text-black">
                    Benefit
                    <img src="{{ asset('images/arrow_down.svg') }}" alt="arrow" class="w-3 h-3">
                </a>
                <!-- <a href="#contact" class="flex items-center gap-1 hover:text-black">
                    Contact
                    <img src="{{ asset('images/arrow_down.svg') }}" alt="arrow" class="w-3 h-3">
                </a> -->
                <a href="#about" class="flex items-center gap-1 hover:text-black">
                    About Us
                    <img src="{{ asset('images/arrow_down.svg') }}" alt="arrow" class="w-3 h-3">
                </a>
            </nav>

            <!-- KANAN: Placeholder agar nav tetap center -->
            <div class="flex items-center">
                <a href="{{ route('login') }}"
                    class="text-red-600 hover:text-red-700 font-semibold text-sm sm:text-base transition-colors duration-200 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Login
                </a>
            </div>
        </div>

        <!-- Mobile sidebar -->
        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:leave="transition ease-in duration-200" @click.away="open=false"
            class="md:hidden bg-white shadow px-6 py-4 space-y-3">
            <a href="#internship" class="block text-[#667085] hover:text-black">Internship</a>
            <a href="#benefit" class="block text-[#667085] hover:text-black">Benefit</a>
            <!-- <a href="#contact"    class="block text-[#667085] hover:text-black">Contact</a> -->
            <a href="#about" class="block text-[#667085] hover:text-black">About Us</a>
        </div>


    </header>

    <!-- Hero Section -->
    <section id="internship" class="relative w-full h-[600px] pt-80px flex items-center text-white overflow-hidden">
        <img src="{{ asset('images/infomagang.png') }}" class="absolute inset-0 w-full h-full object-cover z-10"
            alt="info">
        <div class="absolute inset-0 bg-black opacity-40 z-10"></div> <!-- overlay -->
        <div class="relative z-20 max-w-3xl mx-auto px-6 text-left">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4 text-white">Kickstart Your Career with an
                Internship at Witel Yogya Jateng Selatan!</h1>
            <p class="text-lg mb-6">Ikuti program magang kami untuk mendapatkan pengalaman langsung, mengasah
                kemampuanmu, dan terlibat dalam proyek nyata yang membawa perubahan.</p>
            <div class="flex gap-4 flex-wrap">
                <a href="{{ route('login') }}" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-red-700">Apply
                    Now</a>
                <a href="https://wa.me/6282174144800" target="_blank"
                    class="px-6 py-3 bg-white text-black rounded-lg hover:bg-gray-300">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- Benefit Intro Section with Carousel -->
    <section id="benefit" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-2 items-center gap-10">
            <!-- Carousel Image -->
            <div>
                <div id="benefit-carousel" class="relative w-full" data-carousel="slide">
                    <!-- Carousel wrapper -->
                    <div class="relative h-56 sm:h-72 md:h-96 overflow-hidden rounded-lg">

                        <!-- Carousel Item 1 (AKTIF) -->
                        <div class="duration-700 ease-in-out" data-carousel-item="active">
                            <img src="{{ asset('images/benefitcr1.png') }}" alt="Benefit 1"
                                class="object-cover w-full h-full rounded-lg">
                        </div>

                        <!-- Carousel Item 2 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('images/benefitcr2.png') }}" alt="Benefit 2"
                                class="object-cover w-full h-full rounded-lg">
                        </div>

                        <!-- Carousel Item 3 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('images/benefitcr3.png') }}" alt="Benefit 3"
                                class="object-cover w-full h-full rounded-lg">
                        </div>

                        <!-- Carousel Item 4 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('images/benefitcr4.png') }}" alt="Benefit 4"
                                class="object-cover w-full h-full rounded-lg">
                        </div>

                    </div>

                    <!-- Slider indicators -->
                    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                        <button type="button" class="w-3 h-3 rounded-full bg-white/70" aria-current="true"
                            aria-label="Slide 1" data-carousel-slide-to="0"></button>
                        <button type="button" class="w-3 h-3 rounded-full bg-white/50" aria-label="Slide 2"
                            data-carousel-slide-to="1"></button>
                        <button type="button" class="w-3 h-3 rounded-full bg-white/50" aria-label="Slide 3"
                            data-carousel-slide-to="2"></button>
                        <button type="button" class="w-3 h-3 rounded-full bg-white/50" aria-label="Slide 4"
                            data-carousel-slide-to="3"></button>
                    </div>

                    <!-- Slider controls -->
                    <button type="button"
                        class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-prev>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 6 10">
                                <path d="M5 1 1 5l4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span class="sr-only">Previous</span>
                        </span>
                    </button>
                    <button type="button"
                        class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-next>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 6 10">
                                <path d="m1 9 4-4-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span class="sr-only">Next</span>
                        </span>
                    </button>
                </div>
            </div>

            <!-- Text -->
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-primary mb-4">
                    Manfaat Magang di Witel Yogya Jateng Selatan
                </h2>
                <p class="text-gray-600 text-base sm:text-lg leading-relaxed">
                    Program Magang dan Kerja Praktik Witel Yogya Jateng Selatan mengundang para mahasiswa untuk terlibat
                    langsung dalam proyek-proyek industri, mengembangkan keterampilan digital, serta merasakan secara
                    langsung budaya kerja yang kolaboratif.
                </p>
            </div>
        </div>
    </section>

    <!-- Benefit Card -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-wrap sm:flex-nowrap justify-center sm:justify-between gap-4 sm:gap-6">
                @foreach ([['img' => 'benefit 1.png', 'title' => 'Eksplorasi pengetahuan dan kemampuan secara langsung', 'desc' => 'Bangun relasi dan jaringan yang luas tidak hanya dengan teman satu program studi atau universitas, tetapi juga dengan peserta dari berbagai latar belakang dan profesional di industri.'], ['img' => 'benefit 2.png', 'title' => 'Perluas koneksi profesional', 'desc' => 'Dapatkan pengalaman praktis dengan terlibat langsung dalam berbagai tantangan dan proyek di lapangan, sekaligus mengasah keterampilan yang relevan dengan kebutuhan industri.'], ['img' => 'benefit 3.png', 'title' => 'Belajar langsung dari para ahli dan mitra terpercaya', 'desc' => 'Dapatkan bimbingan dan wawasan eksklusif dari mitra industri Telkom Witel Yogya Jateng Selatan yang berpengalaman, profesional, dan diakui secara nasional maupun internasional.']] as $benefit)
                    <div
                        class="bg-[#f1f1f1] rounded-xl p-4 sm:p-6 text-center shadow-sm hover:-translate-y-2 transition w-[30%] min-w-[100px] sm:w-full">
                        <img src="{{ asset('images/' . $benefit['img']) }}" alt="benefit image"
                            class="mb-2 sm:mb-4 mx-auto w-10 sm:w-12">
                        <h3 class="text-[#ce1126] font-semibold text-xs sm:text-base">{{ $benefit['title'] }}</h3>
                        <!-- Deskripsi hanya muncul di sm ke atas -->
                        <p class="hidden sm:block text-[#555] text-xs sm:text-sm mt-2">{{ $benefit['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Count of Registee -->
    <section class="bg-gradient-to-r from-[#ED1E28] to-[#9c0b1a] text-white py-20 rounded-3xl mx-4 sm:mx-6 lg:mx-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <!-- Title -->
            <div class="text-center mb-12 text-white">
                <h2 class="text-2xl sm:text-3xl font-bold leading-tight text-white">
                    Langkah Awal Menuju <span class="text-yellow-300">Karier Impian ✨</span> Dimulai di Sini
                </h2>
                <p class="text-sm sm:text-base mt-3 text-gray-100">Program magang kami telah mendukung ribuan peserta
                    di seluruh Indonesia</p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10 text-center">
                <!-- Talenta Terdaftar -->
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/pendaftar.svg') }}" alt="pendaftar"
                        class="w-10 h-10 mb-3 filter invert brightness-0">
                    <p class="text-3xl font-bold">1.245</p>
                    <p class="text-sm mt-2 text-gray-100">Peserta Terdaftar</p>
                </div>

                <!-- Talenta Aktif Melamar -->
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/lamar.svg') }}" alt="pendaftar"
                        class="w-10 h-10 mb-3 filter invert brightness-0">
                    <p class="text-3xl font-bold">980</p>
                    <p class="text-sm mt-2 text-gray-100">Peserta Aktif Melamar</p>
                </div>

                <!-- Talenta Lulus Magang -->
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/role.svg') }}" alt="pendaftar"
                        class="w-10 h-10 mb-3 filter invert brightness-0">
                    <p class="text-3xl font-bold">12</p>
                    <p class="text-sm mt-2 text-gray-100">Divisi Tersedia</p>
                </div>

                <!-- Talenta Sedang Magang -->
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/partnership.svg') }}" alt="pendaftar"
                        class="w-10 h-10 mb-3 filter invert brightness-0">
                    <p class="text-3xl font-bold">8</p>
                    <p class="text-sm mt-2 text-gray-100">Peserta Selesai Magang</p>
                </div>
            </div>
        </div>
    </section>

    @php
        $testimonials = [
            [
                'name' => 'Mochamad Abel',
                'instansi' => 'Institut Teknologi Nasional Bandung',
                'image' => asset('images/profil1.jpg'),
                'quote' =>
                    'Pengalaman internship di Telkom Witel YJS sangat menyenangkan. Banyak belajar hal-hal baru terutama culture dari bagaimana telkom witel yogya jateng selatan bekerja.',
            ],
            [
                'name' => 'Intan Triasita Ayu Mardyasari',
                'instansi' => 'Universitas Negeri Yogyakarta',
                'image' => asset('images/profil2.jpeg'),
                'quote' => 'Senang banget bisa intern di Telkom, bagian SSGS Finance Collection. Dapat pengalaman baru, belajar soal collection dan kerja tim, 
                        plus ketemu orang-orang hebat. Thank you, Telkom!',
            ],
            [
                'name' => 'Regista Siti Jahara',
                'instansi' => 'Insitut Teknologi Nasional Bandung',
                'image' => asset('images/profil3.jpeg'),
                'quote' => 'Internship di telkom witel yogya jateng selatan kita bisa belajar banyak hal baru',
            ],
            [
                'name' => 'Bintang Ari Suwardi',
                'instansi' => 'Universitas Atma Jaya Yogyakarta',
                'image' => asset('images/profil4.jpeg'),
                'quote' =>
                    'Selama internship di Telkom saya mendapatkan pengalaman dan pengetahuan penting yang dapat membantu saya menjadi individu yang lebih baik lagi',
            ],
            [
                'name' => 'Nafisko Jaswayoga Prana',
                'instansi' => 'Universitas Negeri Yogyakarta',
                'image' => asset('images/profil5.jpeg'),
                'quote' => 'Selama internship di Divisi Human Capital Telkom Witel Yogya Jateng Selatan, saya mendapatkan banyak pengalaman berharga, 
                        mulai dari membantu proses rekrutmen, mengelola data karyawan hingga terlibat dalam kegiatan pelatihan dan pengembangan. 
                        Saya belajar langsung bagaimana pengelolaan SDM dilakukan secara profesional di perusahaan BUMN. Tim yang suportif dan budaya kerja yang positif membuat pengalaman internship ini sangat bermanfaat dan membekas.',
            ],
            [
                'name' => 'Zeda Kamila Akhyarv',
                'instansi' => 'Universitas Ahmad Dahlan',
                'image' => asset('images/profil6.jpeg'),
                'quote' => 'Internship di Telkom Yogyakarta benar-benar membuka mata saya tentang dunia kerja. Jauh dari bayangan menakutkan, lingkungan di sini justru sangat suportif dan penuh inspirasi. 
                        Banyak sekali ilmu baru yang saya dapatkan, ditambah kesempatan untuk berinteraksi dengan orang-orang hebat dan mentor-mentor yang sabar membimbing. 
                        Rasanya bersyukur sekali bisa menjadi bagian dari pengalaman ini!',
            ],
            [
                'name' => 'Umayra Lasto',
                'instansi' => 'Universitas Islam Indonesia',
                'image' => asset('images/profil7.jpeg'),
                'quote' =>
                    'Mendapatkan pengetahuan yang dapat membantu mengasah kemampuan, mempelajari problem solving',
            ],
        ];
        shuffle($testimonials);
    @endphp

    <!-- Testi Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold mb-8 text-gray-800">
                Their Stories, Their Experience
            </h2>

            <!-- wrapper relatif -->
            <div class="relative">

                <!-- wrapper scroll -->
                <div id="testimonialWrapper"
                    class="flex overflow-x-auto space-x-6 scrollbar-hide scroll-smooth snap-x snap-mandatory py-4 px-2">
                    @foreach ($testimonials as $item)
                        <div class="flex-shrink-0 snap-center w-[300px] bg-white rounded-xl shadow-md p-6">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                class="w-20 h-20 mx-auto rounded-full object-cover mb-4 border-4 border-red-500">
                            <h3 class="text-lg font-semibold text-red-600">{{ $item['name'] }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $item['instansi'] }}</p>
                            <p class="text-sm text-gray-500 italic">
                                “{{ \Illuminate\Support\Str::limit($item['quote'], 150, '...') }}”</p>
                        </div>
                    @endforeach
                </div>

                <!-- Navigasi -->
                <button id="prevBtn"
                    class="hidden md:flex items-center justify-center w-12 h-12 text-white bg-red-500 hover:bg-red-600 rounded-full absolute -left-20 top-1/2 transform -translate-y-1/2 shadow z-10">
                    &larr;
                </button>
                <button id="nextBtn"
                    class="hidden md:flex items-center justify-center w-12 h-12 text-white bg-red-500 hover:bg-red-600 rounded-full absolute -right-20 top-1/2 transform -translate-y-1/2 shadow z-10">
                    &rarr;
                </button>
            </div>
        </div>
    </section>

    <!-- footer -->
    <footer id="about" class="bg-black text-white border-t-8 border-[#ED1E28]">
        <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

            <!-- Kiri: Alamat & Kontak -->
            <div class="space-y-4">
                <div>
                    <h3 class="text-white text-base sm:text-lg font-bold">Witel Yogya Jateng Selatan</h3>
                    <p class="text-gray-300 mt-1 leading-snug text-sm">
                        Jl. Yos Sudarso No.9 001, Kotabaru, Kec. Gondokusuman, Kota Yogyakarta,<br>
                        Daerah Istimewa Yogyakarta 55224
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-1 text-sm sm:text-base">Contact Us</h4>
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/ig.svg') }}" class="w-4 h-4" alt="Instagram">
                        <span>@pioneer.witelyogyajatsel</span>
                    </div>
                    <div class="flex items-center gap-2 mt-1">
                        <img src="{{ asset('images/email.svg') }}" class="w-4 h-4" alt="Email">
                        <span>emailnyaapa@gmail.com</span>
                    </div>
                </div>
            </div>

            <!-- Kanan: Navigasi -->
            <div class="border-t md:border-t-0 md:border-l border-gray-600 pt-4 md:pt-0 md:pl-6">
                <h4 class="text-white font-bold mb-3 text-sm sm:text-lg">Profil Witel Yogya Jateng Selatan</h4>
                <ul class="space-y-2">
                    <li><a href="/" class="hover:underline">Beranda</a></li>
                    <li><a href="/faq" class="hover:underline">FAQ</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-6 text-center text-xs text-gray-400">
            &copy; 2025 Witel Yogya Jateng Selatan. All rights reserved.
        </div>
    </footer>



    <script>
        const wrapper = document.getElementById('testimonialWrapper');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        prevBtn?.addEventListener('click', () => {
            wrapper.scrollBy({
                left: -wrapper.clientWidth,
                behavior: 'smooth'
            });
        });

        nextBtn?.addEventListener('click', () => {
            wrapper.scrollBy({
                left: wrapper.clientWidth,
                behavior: 'smooth'
            });
        });
    </script>

</body>

</html>
