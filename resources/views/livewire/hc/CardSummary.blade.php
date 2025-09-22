<div class="p-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
        <!-- Waiting Approval -->
        <div class="bg-white shadow-md rounded-xl p-6 transform transition duration-300 hover:scale-105 hover:shadow-lg">
            <div class="flex items-center space-x-4">
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i class="fas fa-hourglass-half text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Waiting Approval</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $waitingApproval ?? 0 }}</p>
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
</div>

   