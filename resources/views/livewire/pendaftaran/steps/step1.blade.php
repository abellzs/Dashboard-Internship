<div class="space-y-2 text-sm text-gray-700">
    <p>Selamat datang di halaman pendaftaran Kerja Praktik (PKL) Telkom Witel Yogyakarta – Jawa Tengah Selatan.</p>
    
    <p>Harap membaca dan memahami seluruh ketentuan berikut sebelum melanjutkan proses pendaftaran:</p>
    
    <ol class="list-decimal list-inside space-y-1">
        <li>Peserta wajib telah menyelesaikan seluruh mata kuliah teori dan praktikum, kecuali Tugas Akhir.</li>
        <li>Peserta harus memiliki akun <strong>Telegram</strong> aktif dengan menggunakan nomor <strong>Telkomsel</strong>.</li>
        <li>Setelah menyetujui tanggal pelaksanaan Kerja Praktik, peserta tidak diperkenankan mengubah atau mengurangi periode pelaksanaan.</li>
    </ol>
    
    <p><strong>Catatan:</strong> Pengurangan periode pelaksanaan Kerja Praktik akan mengakibatkan peserta tidak memperoleh sertifikat pelaksanaan magang.</p>
</div>

<div class="flex items-center space-x-2 pt-4">
    <input 
        type="checkbox" 
        id="agreement" 
        value="1"
        wire:model.live="agreement" 
        class="w-5 h-5 text-[#DA291C] border-gray-300 focus:ring-[#DA291C]">

    <label for="agreement" class="text-sm text-gray-800">
        Saya telah membaca dan menyetujui seluruh ketentuan di atas.
    </label>
</div>

@error('agreement')
    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
@enderror