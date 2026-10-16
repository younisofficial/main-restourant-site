@extends('layouts.app')

@section('title', 'Book a table')

@section('content')
@include('partials.page-head', ['title' => 'Book a table', 'subtitle' => 'Send us a request and we will call you to confirm your table.'])

<section class="section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                <form action="{{ route('reservation.store') }}" method="POST" class="panel" novalidate>
                    @csrf
                    <h5 class="mb-3">Your booking</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label" for="reservation_date">Date</label>
                            <input type="date" id="reservation_date" name="reservation_date" min="{{ date('Y-m-d') }}" class="form-control @error('reservation_date') is-invalid @enderror" value="{{ old('reservation_date', date('Y-m-d')) }}" required>
                            @error('reservation_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="reservation_time">Time</label>
                            <select id="reservation_time" name="reservation_time" class="form-select @error('reservation_time') is-invalid @enderror" required>
                                @for ($h = 12; $h <= 23; $h++)
                                    @foreach (['00', '30'] as $m)
                                        @php $val = sprintf('%02d:%s', $h, $m); @endphp
                                        <option value="{{ $val }}" @selected(old('reservation_time', '20:00') === $val)>{{ \Carbon\Carbon::createFromFormat('H:i', $val)->format('h:i A') }}</option>
                                    @endforeach
                                @endfor
                            </select>
                            @error('reservation_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="guests">Guests</label>
                            <select id="guests" name="guests" class="form-select @error('guests') is-invalid @enderror" required>
                                @for ($g = 1; $g <= 20; $g++)
                                    <option value="{{ $g }}" @selected((int) old('guests', 2) === $g)>{{ $g }} {{ \Illuminate\Support\Str::plural('person', $g) }}</option>
                                @endfor
                            </select>
                            @error('guests')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="name">Your name</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()?->name) }}" required autocomplete="name">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="phone">Phone number</label>
                            <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', auth()->user()?->phone) }}" placeholder="03XX-XXXXXXX" required autocomplete="tel">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="email">Email <span class="text-muted-2 fw-normal">(optional)</span></label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()?->email) }}" autocomplete="email">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="message">Special request <span class="text-muted-2 fw-normal">(optional)</span></label>
                            <textarea id="message" name="message" rows="3" class="form-control" placeholder="Birthday, high chair for a child, a quiet corner…">{{ old('message') }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg mt-4"><i class="bi bi-calendar2-check me-2"></i>Request booking</button>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="about-photo mb-4" style="aspect-ratio: 4/3; border-radius: var(--radius)">
                    <img src="{{ asset('images/reservation-bg.jpg') }}" alt="Burgers being served at the restaurant">
                </div>
                <div class="panel">
                    <div class="info-tile mb-3"><i class="bi bi-clock"></i><div><h6>Opening hours</h6><p>{{ config('restaurant.hours') }}</p></div></div>
                    <div class="info-tile mb-3"><i class="bi bi-people"></i><div><h6>Large groups</h6><p>For more than 20 guests, call us and we will arrange a private hall.</p></div></div>
                    <div class="info-tile"><i class="bi bi-telephone"></i><div><h6>Prefer to call?</h6><p><a href="tel:{{ config('restaurant.phone') }}">{{ config('restaurant.phone') }}</a></p></div></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
