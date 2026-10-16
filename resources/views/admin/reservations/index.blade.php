@extends('layouts.admin')

@section('title', 'Reservations')

@section('content')
<div class="card-x">
    <div class="card-head">
        <div class="filter-tabs">
            <a href="{{ route('admin.reservations.index') }}" class="{{ ! $status ? 'active' : '' }}">All</a>
            @foreach (\App\Models\Reservation::STATUSES as $key => $s)
                <a href="{{ route('admin.reservations.index', ['status' => $key]) }}" class="{{ $status === $key ? 'active' : '' }}">{{ $s['label'] }}</a>
            @endforeach
        </div>
    </div>

    @if ($reservations->isEmpty())
        <div class="empty"><i class="bi bi-calendar2-x"></i>No reservations here.</div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Guest</th><th>Date & time</th><th>People</th><th>Request</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                @foreach ($reservations as $r)
                    <tr>
                        <td><span class="fw-semibold">{{ $r->name }}</span><br><small class="text-muted"><a href="tel:{{ $r->phone }}">{{ $r->phone }}</a></small></td>
                        <td class="text-nowrap">{{ $r->reservation_date->format('D, d M Y') }}<br><small class="text-muted">{{ \Carbon\Carbon::createFromFormat('H:i', $r->reservation_time)->format('h:i A') }}</small></td>
                        <td>{{ $r->guests }}</td>
                        <td class="small" style="max-width: 260px">{{ $r->message ?: '—' }}</td>
                        <td><span class="status status-{{ $r->status_color }}">{{ $r->status_label }}</span></td>
                        <td class="text-end text-nowrap">
                            @if ($r->status !== 'approved')
                                <form action="{{ route('admin.reservations.status', $r) }}" method="POST" class="d-inline">@csrf @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i> Approve</button>
                                </form>
                            @endif
                            @if ($r->status !== 'cancelled')
                                <form action="{{ route('admin.reservations.status', $r) }}" method="POST" class="d-inline">@csrf @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button class="btn btn-sm btn-light">Cancel</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.reservations.destroy', $r) }}" method="POST" class="d-inline" data-confirm="Delete this reservation?">@csrf @method('DELETE')
                                <button class="btn btn-light btn-icon text-danger" title="Delete" aria-label="Delete reservation"><i class="bi bi-trash3"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($reservations->hasPages())<div class="card-body border-top">{{ $reservations->links() }}</div>@endif
    @endif
</div>
@endsection
