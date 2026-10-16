@extends('layouts.admin')

@section('title', 'Message')

@section('content')
<a href="{{ route('admin.messages.index') }}" class="d-inline-block mb-3 text-decoration-none"><i class="bi bi-arrow-left me-1"></i>All messages</a>
<div class="card-x" style="max-width: 760px">
    <div class="card-head">
        <div>
            <h2>{{ $message->subject ?: 'No subject' }}</h2>
            <small class="text-muted">From {{ $message->name }} &lt;{{ $message->email }}&gt;, {{ $message->created_at->format('d M Y, h:i A') }}</small>
        </div>
    </div>
    <div class="card-body" style="white-space: pre-line">{{ $message->message }}</div>
    <div class="card-body border-top d-flex gap-2">
        <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject ?? 'Your message') }}" class="btn btn-primary"><i class="bi bi-reply me-1"></i>Reply by email</a>
        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" data-confirm="Delete this message?">
            @csrf @method('DELETE')
            <button class="btn btn-light text-danger"><i class="bi bi-trash3 me-1"></i>Delete</button>
        </form>
    </div>
</div>
@endsection
