
@extends('layouts.app')
@section('content')
<div class="container w-full mx-auto pt-20 ">
    <div class="w-full px-4 md:px-6 text-xl text-gray-800 leading-normal">
        <h1 class="text-3xl font-bold text-gray-800">Email Archival</h1>
    </div>
    <div class="border border-gray-200 rounded">
        <livewire:emails-component />
    </div>
</div>
@endsection
