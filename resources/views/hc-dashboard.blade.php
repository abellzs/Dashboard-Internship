@extends('components.layouts.hc.app')

@section('content')
<div class="p-4 md:p-6 bg-gray-50 rounded-lg shadow-md animate-fade-in duration-300 space-y-6">

    {{-- Sidebar sudah ada di layout, jadi ini konten dinamisnya saja --}}
    @if($page === 'dashboard')
        @include('hc.dashboard')
    @elseif($page === 'data-peserta')
        @include('hc.data-peserta')
    @elseif($page === 'tinjau-nanti')
        @include('hc.tinjau-nanti')
    @elseif($page === 'dokumen-peserta')
        @include('hc.dokumen-peserta')
    @elseif($page === 'export-laporan')
        @include('hc.export-laporan')
    @elseif($page === 'reminder')
        @include('hc.reminder')
    @else
        <p>Halaman tidak ditemukan.</p>
    @endif

</div>
@endsection
