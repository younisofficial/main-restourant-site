@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
<div class="card-x">
    <div class="card-head"><h2>Messages from the contact form</h2></div>
    @if ($messages->isEmpty())
        <div class="empty"><i class="bi bi-chat-left-text"></i>No messages yet.</div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>From</th><th>Subject</th><th>Received</th><th></th></tr></thead>
                <tbody>
                @foreach ($messages as $m)
                    <tr class="{{ $m->is_read ? '' : 'fw-bold' }}">
                        <td>@unless ($m->is_read)<span class="d-inline-block rounded-circle me-2" style="width:8px;height:8px;background:var(--madder)" title="Unread"></span>@endunless{{ $m->name }}<br><small class="text-muted fw-normal">{{ $m->email }}</small></td>
                        <td>{{ $m->subject ?: \Illuminate\Support\Str::limit($m->message, 50) }}</td>
                        <td class="small text-muted fw-normal text-nowrap">{{ $m->created_at->diffForHumans() }}</td>
                        <td class="text-end"><a href="{{ route('admin.messages.show', $m) }}" class="btn btn-light btn-sm">Read</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($messages->hasPages())<div class="card-body border-top">{{ $messages->links() }}</div>@endif
    @endif
</div>
@endsection
