@extends('layouts.app')

@section('title', 'Contact us')

@section('content')
@include('partials.page-head', ['title' => 'Contact us', 'crumb' => 'Contact', 'subtitle' => 'Questions, catering or feedback. We reply within one working day.'])

<section class="section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="panel h-100">
                    <div class="info-tile mb-4"><i class="bi bi-geo-alt"></i><div><h6>Address</h6><p>{{ config('restaurant.address') }}</p></div></div>
                    <div class="info-tile mb-4"><i class="bi bi-telephone"></i><div><h6>Phone</h6><p><a href="tel:{{ config('restaurant.phone') }}">{{ config('restaurant.phone') }}</a></p></div></div>
                    <div class="info-tile mb-4"><i class="bi bi-whatsapp"></i><div><h6>WhatsApp</h6><p><a href="https://wa.me/{{ config('restaurant.whatsapp') }}">Chat with us</a></p></div></div>
                    <div class="info-tile mb-4"><i class="bi bi-envelope"></i><div><h6>Email</h6><p><a href="mailto:{{ config('restaurant.email') }}">{{ config('restaurant.email') }}</a></p></div></div>
                    <div class="ratio ratio-16x9 rounded-3 overflow-hidden border">
                        <iframe src="{{ config('restaurant.map_embed') }}" title="Map showing the restaurant location" loading="lazy" style="border:0"></iframe>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <form action="{{ route('contact.store') }}" method="POST" class="panel" novalidate>
                    @csrf
                    <h5 class="mb-3">Send us a message</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="name">Your name</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()?->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()?->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="e.g. Catering for an event">
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="message">Message</label>
                            <textarea id="message" name="message" rows="6" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg mt-4"><i class="bi bi-send me-2"></i>Send message</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
