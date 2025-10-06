<div>
    <div class="min-h-screen">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Presensi Magang</h1>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        @if($alreadyCheckedIn)
                            <div class="inline-flex items-center px-4 py-2 bg-green-50 border border-green-200 rounded-lg">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse mr-2"></div>
                                <span class="text-sm font-medium text-green-700">Sudah Absen Hari Ini</span>
                            </div>
                        @else
                            <div class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-200 rounded-lg">
                                <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse mr-2"></div>
                                <span class="text-sm font-medium text-red-700">Belum Absen</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Informasi Pengguna -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Informasi Pengguna
                        </h2>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Nama</span>
                                <span class="text-sm text-gray-900">{{ $user->name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">NIM Magang</span>
                                <span class="text-sm text-gray-900">{{ $user->nim_magang ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Unit Magang</span>
                                <span class="text-sm text-gray-900">{{ $userUnit ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Tanggal</span>
                                <span class="text-sm text-gray-900">{{ $today ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-gray-600">Waktu</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $currentTime ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Lokasi -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Lokasi Saat Ini
                        </h2>
                        <div id="map" wire:ignore class="w-full h-64 bg-gray-100 rounded-lg border border-gray-200"></div>
                        <div class="mt-3 text-xs text-gray-500 text-center">
                            <span>Lat: {{ $latitude ?? 'Detecting...' }} | Lng: {{ $longitude ?? 'Detecting...' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Presensi -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Form Presensi
                    </h2>

                    <!-- Session Messages -->
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-green-800 font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="text-red-800 font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <form wire:submit.prevent="presensi" class="max-w-md mx-auto space-y-6">
                        <input type="hidden" wire:model="latitude">
                        <input type="hidden" wire:model="longitude">
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Presensi</label>
                            <select id="status" wire:model.live="status"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                required>
                                <option value="">Pilih Status Presensi</option>
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Tidak Hadir">Tidak Hadir</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                @if ($status === 'Izin')
                                    Alasan Izin
                                @elseif($status === 'Tidak Hadir')
                                    Alasan Tidak Hadir
                                @else
                                    Aktivitas Kegiatan
                                @endif
                            </label>
                            <textarea id="keterangan" wire:model="keterangan" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                placeholder="{{ $status === 'Izin' ? 'Jelaskan alasan izin Anda...' : ($status === 'Tidak Hadir' ? 'Jelaskan alasan tidak hadir...' : 'Deskripsikan aktivitas kegiatan hari ini...') }}"
                                required></textarea>
                            @error('keterangan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Submit Presensi
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let mapInitialized = false;
        let map, marker;

        function initMap() {
            // Pastikan elemen #map sudah ada di DOM
            const mapDiv = document.getElementById('map');
            if (!mapDiv || mapInitialized) return;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;

                    // Kirim koordinat ke Livewire
                    @this.set('latitude', lat);
                    @this.set('longitude', lng);

                    map = L.map('map').setView([lat, lng], 16);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);
                    marker = L.marker([lat, lng]).addTo(map)
                        .bindPopup('Lokasi Anda')
                        .openPopup();
                    mapInitialized = true;
                });
            } else {
                mapDiv.innerHTML = 'Geolocation tidak didukung browser Anda.';
            }
        }

        // Event listener untuk Livewire
        document.addEventListener('livewire:navigated', initMap);
        document.addEventListener('DOMContentLoaded', initMap);

        // Jika sudah ready
        if (document.readyState === 'complete') {
            initMap();
        }
    </script>
</div>