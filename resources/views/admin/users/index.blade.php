@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="card-x">
    <div class="card-head">
        <h2>{{ $users->total() }} users</h2>
        <form method="GET" class="d-flex gap-2" role="search">
            <input type="search" name="q" value="{{ $search }}" class="form-control form-control-sm" style="width: 220px" placeholder="Name or email" aria-label="Search users">
            <button class="btn btn-indigo btn-sm">Search</button>
        </form>
    </div>
    @if ($users->isEmpty())
        <div class="empty"><i class="bi bi-people"></i>No users found.</div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Orders</th><th>Spent</th><th>Joined</th></tr></thead>
                <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td class="fw-semibold">{{ $u->name }} @if ($u->is_admin)<span class="status status-danger ms-1">Admin</span>@endif</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->phone ?: '—' }}</td>
                        <td>{{ $u->orders_count }}</td>
                        <td class="text-nowrap">{{ config('restaurant.currency') }} {{ number_format($u->spent ?? 0) }}</td>
                        <td class="small text-muted">{{ $u->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($users->hasPages())<div class="card-body border-top">{{ $users->links() }}</div>@endif
    @endif
</div>
@endsection
