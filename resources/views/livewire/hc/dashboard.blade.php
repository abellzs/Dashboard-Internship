<div class="p-4 space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
        <!-- Waiting Approval -->
        <div class="bg-white shadow-md rounded-xl p-6 transform transition duration-300 hover:scale-105 hover:shadow-lg">
            <div class="flex items-center space-x-4">
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i class="fas fa-hourglass-half text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Waiting Approval</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $waiting ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Approved (On Going) -->
        <div class="bg-white shadow-md rounded-xl p-6 transform transition duration-300 hover:scale-105 hover:shadow-lg">
            <div class="flex items-center space-x-4">
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Approved (On Going)</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $approved ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Peserta Masuk -->
        <div class="bg-white shadow-md rounded-xl p-6 transform transition duration-300 hover:scale-105 hover:shadow-lg">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fas fa-folder-open text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Total Peserta Masuk</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $total ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Distribusi Unit -->
        <div class="bg-white border border-gray-100 shadow rounded-xl p-5">
            <h3 class="text-sm font-semibold mb-4 text-[#E30613] tracking-wide">Distribusi Unit</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="unitChart"></canvas>
            </div>
        </div>

        <!-- Peserta per Bulan -->
        <div class="bg-white border border-gray-100 shadow rounded-xl p-5">
            <h3 class="text-sm font-semibold mb-4 text-[#E30613] tracking-wide">Jumlah Peserta per Bulan</h3>
            <div class="h-64">
                <canvas id="bulanChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Chart.js -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Unit Chart (Donut)
        new Chart(document.getElementById('unitChart'), {
            type: 'doughnut',
            data: {
                labels: @json($unitLabels),
                datasets: [{
                    label: 'Jumlah',
                    data: @json($unitCounts),
                    backgroundColor: [
                        '#E30613','#FF6B6B',
                        '#60A5FA','#34D399',
                        '#FBBF24','#9CA3AF'
                    ],
                    borderWidth: 3,
                    borderColor: '#fff',
                    hoverOffset: 8
                }]
            },
            options: {
                plugins: { 
                    legend: { 
                        position: 'right',
                        labels: { font: { size: 12 } } 
                    } 
                },
                cutout: '70%'
            }
        });

        // Peserta per Bulan (Line)
        new Chart(document.getElementById('bulanChart'), {
            type: 'line',
            data: {
                labels: @json($bulanLabels),
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: @json($bulanCounts),
                    borderColor: '#E30613',
                    backgroundColor: 'rgba(227,6,19,0.15)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#E30613',
                    pointHoverRadius: 6,
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 12 } }
                    },
                    y: {
                        ticks: { font: { size: 12 } },
                        grid: { color: '#f3f4f6' }
                    }
                }
            }
        });
    });
</script>
