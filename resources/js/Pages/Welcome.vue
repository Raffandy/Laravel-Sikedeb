<template>
    <div class="bg-black min-h-screen text-white">
        <header class="flex overflow-hidden flex-col items-end pt-12 pb-32 pl-24 max-md:pb-28 max-md:pl-5">
            <nav data-layername="navbar" class="flex flex-wrap gap-10 items-center justify-between w-full text-base font-bold text-white bg-transparent max-w-[1458px] min-h-[80px] mx-auto max-md:max-w-full px-5">
                <!-- Logo & Brand -->
                <a href="/" class="flex gap-3 justify-center items-center text-2xl tracking-tight leading-tight whitespace-nowrap">
                    <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/40e02fd5b45d48cd9235b37b246a760e/37e2ba6f9ba1b5fc33d9469a96d2dfbabb141c33b1c4dd80d99424efad52fab2?apiKey=40e02fd5b45d48cd9235b37b246a760e&" alt="IKEDEB Logo" class="object-contain w-8 aspect-square" />
                    <h1 data-layername="$ikedeb" class="text-white">$IKEDEB</h1>
                </a>

                <!-- Menu Links -->
                <ul data-layername="menu" class="flex gap-10 items-center font-medium max-md:max-w-full">
                    <li><a href="/" class="hover:text-red-400 text-white">Home</a></li>
                    <li><a href="/dashboard/data" class="hover:text-red-400 text-white">Kelola Data</a></li>
                    <li><a href="/dashboard/data" class="hover:text-red-400 text-white">Penilaian Kelayakan Kredit</a></li>
                </ul>

                <!-- Login Button -->
                <a :href="route('login')" class="px-8 py-3 text-red-400 bg-black border-2 border-red-400 rounded-[64px] max-md:px-5 hover:bg-red-500 hover:text-black focus:outline-none focus:ring-2 focus:ring-red-500">
                    LOGIN
                </a>
            </nav>

            <main class="mt-18 w-full max-w-[1567px] max-md:pr-5 max-md:mt-10 max-md:max-w-full">
                <section class="flex gap-10 max-md:flex-col">
                    <article class="flex flex-col w-[72%] max-md:ml-0 max-md:w-full">
                        <div class="flex justify-between items-start mt-12 max-md:flex-col">
                            <div class="flex flex-col">
                                <h2 data-layername="$ikedebSistemKelayakanDebitur" class="text-7xl font-bold tracking-tighter leading-[70px] max-md:max-w-full max-md:text-5xl max-md:leading-[55px] text-white">
                                    $IKEDEB - Sistem Kelayakan Debitur
                                </h2>
                                <p data-layername="description" class="mt-10 text-xl leading-7 text-justify max-md:max-w-full text-white">
                                    Selamat datang di Sistem Kelayakan Debitur, platform yang dirancang untuk memudahkan evaluasi dan pengelolaan data nasabah. Di sini, Anda dapat melakukan berbagai fungsi, seperti melakukan penilaian kelayakan kredit secara akurat berdasarkan data nasabah, memastikan kelengkapan informasi, dan mengelola seluruh data nasabah dengan mudah.
                                </p>
                                <a href="/dashboard/data"class="flex gap-4 items-center self-start px-10 py-5 mt-10 text-lg font-medium bg-red-700 rounded-[64px] max-md:px-6 text-white hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-700" tabindex="0">
                                    <span>Get Started</span>
                                </a>
                            </div>
                        </div>
                    </article>
                </section>
            </main>
        </header>

        <section class="text-center my-6">
            <h2 class="text-4xl font-bold">What do we offer?</h2>
        </section>

        <section class="offer py-6">
            <div class="max-w-4xl mx-auto px-4">
                <h2 class="text-3xl font-bold mb-2 flex items-center text-white">
                    <img src="../../../public/assets/Frame.png" alt="Logo Penilaian Kelayakan" class="w-16 h-16 mr-2">
                    Penilaian Kelayakan
                </h2>
                <p class="text-gray-300 mb-4 text-justify">
                    Kami menyediakan solusi pengelolaan data yang terintegrasi dan efisien, memastikan bahwa setiap informasi nasabah disimpan, diorganisir, dan dikelola dengan baik. Sistem kami dirancang untuk menjaga keamanan dan privasi data, serta memudahkan akses informasi yang diperlukan untuk analisis dan laporan.
                </p>
            </div>
        </section>

        <section class="offer py-6">
            <div class="max-w-4xl mx-auto px-4">
                <h2 class="text-3xl font-bold mb-2 flex items-center text-white">
                    <img src="../../../public/assets/Frame.png" alt="Logo Penilaian Kelayakan" class="w-16 h-16 mr-2">
                    Pengelolaan Data
                </h2>
                <p class="text-gray-300 mb-4 text-justify">
                    Layanan penilaian kelayakan kami menggunakan metodologi yang tepat dan berbasis data untuk mengevaluasi kemampuan nasabah dalam memenuhi kewajiban finansial. Tim kami menganalisis berbagai faktor, termasuk riwayat kredit, penghasilan, dan kondisi keuangan saat ini.
                </p>
            </div>
        </section>

        <section class="offer py-6">
            <div class="max-w-4xl mx-auto px-4">
                <h2 class="text-3xl font-bold mb-2 flex items-center text-white">
                    <img src="../../../public/assets/Frame.png" alt="Logo Penilaian Kelayakan" class="w-16 h-16 mr-2">
                    Ambil Keputusan
                </h2>
                <p class="text-gray-300 mb-4 text-justify">
                    Kami membantu proses pengambilan keputusan yang lebih efektif dengan menyediakan analisis mendalam dan rekomendasi berbasis data. Sistem kami memungkinkan Anda untuk mempertimbangkan berbagai skenario dan dampak dari setiap pilihan yang diambil.
                </p>
            </div>
        </section>

        <section class="text-center my-6">
            <h2 class="text-4xl font-bold">About Us</h2>
        </section>

        <section class="testimonials py-4">
            <div class="max-w-4xl mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Testimonial 1 -->
                    <div class="bg-purple-800 p-4 rounded-lg shadow-lg">
                        <img src="../../../public/assets/Ellipse2.png" alt="Ervita Amelia" class="w-20 h-20 rounded-full mx-auto mb-2">
                        <h3 class="text-lg font-semibold text-center text-white">Ervita Amelia</h3>
                        <p class="text-gray-300 text-center italic">"Front End Developer"</p>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="bg-purple-800 p-4 rounded-lg shadow-lg">
                        <img src="../../../public/assets/Ellipse.png" alt="Muhammad Hafi" class="w-20 h-20 rounded-full mx-auto mb-2">
                        <h3 class="text-lg font-semibold text-center text-white">Muhammad Hafi Raffandy</h3>
                        <p class="text-gray-300 text-center italic">"Back End Developer"</p>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="bg-purple-800 p-4 rounded-lg shadow-lg">
                        <img src="../../../public/assets/Ellipse.png" alt="Muhammad Abdul Rosyid" class="w-20 h-20 rounded-full mx-auto mb-2">
                        <h3 class="text-lg font-semibold text-center text-white">Muhammad Abdul Rosyid</h3>
                        <p class="text-gray-300 text-center italic">"Designer"</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="flex flex-col bg-black py-10 px-5 md:px-20">
            <div class="flex flex-col items-start w-full max-w-[1240px] mx-auto">
                <div class="flex flex-wrap gap-8 items-start w-full">
                    <!-- Logo & Description -->
                    <div class="flex flex-col min-w-[240px] w-[392px] mb-6">
                        <div class="flex items-center text-xl font-bold text-white">
                            <img src="../../../public/assets/Exclude.png" alt="Logo" class="w-6 h-6 mr-2" />
                            <h2>$IKEDEB</h2>
                        </div>
                        <p class="mt-2 text-base leading-6 text-gray-300">Sistem Kelayakan Debitur Terintegrasi untuk Analisis Keuangan yang Lebih Baik.</p>
                    </div>

                    <!-- Links -->
                    <div class="flex flex-col min-w-[240px] w-[292px] mb-6">
                        <h3 class="text-xl font-semibold text-white mb-4">Useful Links</h3>
                        <ul class="flex flex-col gap-2">
                            <li><a href="/" class="hover:text-red-400 text-gray-300">Home</a></li>
                            <li><a href="/kelola-data" class="hover:text-red-400 text-gray-300">Kelola Data</a></li>
                            <li><a href="/penilaian" class="hover:text-red-400 text-gray-300">Penilaian Kelayakan Kredit</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div class="flex flex-col min-w-[240px] w-[240px] mb-6">
                        <h3 class="text-xl font-semibold text-white mb-4">Contact Us</h3>
                        <p class="text-gray-300">Email: info@$ikedeb.com</p>
                        <p class="text-gray-300">Phone: (021) 123-4567</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
