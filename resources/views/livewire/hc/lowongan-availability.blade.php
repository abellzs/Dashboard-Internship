<div
    x-data="{
        showToast: @entangle('showToast'),
        toastMessage: @entangle('toastMessage'),
        init() {
            $watch('showToast', value => {
                if (value) setTimeout(() => this.showToast = false, 3000);
            });
        }
    }"
    x-init="init()"
    class="relative"
>
    {{-- Toast Notification --}}
    <div
        x-show="showToast"
        x-transition:enter="transform transition duration-300"
        x-transition:enter-start="translate-x-10 opacity-0 scale-90"
        x-transition:enter-end="translate-x-0 opacity-100 scale-100"
        x-transition:leave="transform transition duration-300"
        x-transition:leave-start="translate-x-0 opacity-100 scale-100"
        x-transition:leave-end="translate-x-10 opacity-0 scale-90"
        class="fixed top-5 right-5 text-white px-5 py-3 rounded-xl shadow-2xl flex items-center gap-3 z-50 text-sm font-semibold bg-gradient-to-r from-[#DA291C] to-[#FF6D00]"
    >
        <svg class="h-5 w-5 text-white flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
        </svg>
        <span x-text="toastMessage"></span>
    </div>

    {{-- Bungkus CARD dan TABEL dalam satu container putih --}}
    <div class="bg-white rounded-lg shadow-md overflow-x-auto border my-1 relative p-6">

        {{-- Cards count --}}
        <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-green-100 text-green-800 rounded-lg shadow-md p-6 flex flex-col justify-center items-center">
                <div class="text-4xl font-extrabold">{{ $availableCount }}</div>
                <div class="mt-2 text-lg font-semibold">Unit Tersedia</div>
            </div>
            <div class="bg-red-100 text-red-800 rounded-lg shadow-md p-6 flex flex-col justify-center items-center">
                <div class="text-4xl font-extrabold">{{ $unavailableCount }}</div>
                <div class="mt-2 text-lg font-semibold">Unit Tidak Tersedia</div>
            </div>
        </div>

        {{-- Table --}}
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-base font-bold text-gray-700 uppercase tracking-wider">
                        Nama Unit
                    </th>
                    <th class="px-6 py-3 text-left text-base font-bold text-gray-700 uppercase tracking-wider">
                        Ketersediaan
                    </th>
                    <th class="px-6 py-3 text-center text-base font-bold text-gray-700 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($lowongans as $lowongan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $lowongan->nama_unit }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $lowongan->ketersediaan === 'Tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $lowongan->ketersediaan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:click="toggleAvailability({{ $lowongan->id }})"
                                    class="sr-only peer"
                                    {{ $lowongan->ketersediaan === 'Tersedia' ? 'checked' : '' }}>

                                <div class="relative w-11 h-6 bg-gray-200 rounded-full 
                                            peer peer-focus:ring-4 peer-focus:ring-green-300 
                                            dark:peer-focus:ring-green-800 dark:bg-gray-700 
                                            peer-checked:after:translate-x-full 
                                            rtl:peer-checked:after:-translate-x-full 
                                            peer-checked:after:border-white 
                                            after:content-[''] after:absolute after:top-0.5 after:start-[2px] 
                                            after:bg-white after:border-gray-300 after:border 
                                            after:rounded-full after:h-5 after:w-5 
                                            after:transition-all dark:border-gray-600 
                                            peer-checked:bg-green-600">
                                </div>
                            </label>


                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
