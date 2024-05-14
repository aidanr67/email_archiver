
@extends('layouts.app')
@section('content')
<div class="container w-full mx-auto pt-20 ">
    <div class="w-full px-4 md:px-6 text-xl text-gray-800 leading-normal">
        <h1 class="text-3xl font-bold text-gray-800">Email Archival</h1>
    </div>
    <div class="border border-gray-200 rounded">
        <livewire:emails />
    </div>
</div>
@endsection

<style lang="scss">
    .fi-btn-label {
        color: #2d3748;
    }
    .fi-ta-search-field {
        border: #2d3748;
        border-style: solid;
    }
    .fi-modal-window {
        border: #2d3748;
        border-style: solid;
    }
</style>