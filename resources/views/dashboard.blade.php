@extends('components.layouts.app')

@section('content')
    @livewire('user-dashboard', ['magang' => $magang])
@endsection