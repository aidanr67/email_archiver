@extends('layouts.app')
@section('content')
    <div class="container w-full md:max-w-3xl mx-auto pt-20">
        <span class="w-full px-4 text-xl text-gray-800 leading-normal">
            <label for="subject">Subject:</label>
            <span id="subject" class="text-xl font-semibold mb-8">{{ $email->subject }}</span>
        </span>
        <div class="text-gray-700 pt-10">
            <label for="sender">Sender:</label>
            <span id="sender">{{ $email->sender_address }}</span>
        </div>
        <div class="text-gray-700 pt-10">
            <label for="recipient">Recipient:</label>
            <span id="recipient">{{ $email->recipient_address }}</span>
        </div>
        <div class="text-gray-700 pt-10">
            <label for="body">Body:</label>
            <div id="body">{{ $email->body }}</div>
        </div>
    </div>

@endsection
