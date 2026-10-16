@extends('layouts.app')

@section('title', 'Create account')

@section('content')
<section class="auth-wrap">
    <div class="container" style="max-width: 940px">
        <div class="auth-card row g-0">
            <div class="col-md-5 d-none d-md-block">
                <div class="auth-side">
                    <div class="urdu" lang="ur">ذائقہ</div>
                    <h2 class="h3">Join the family</h2>
                    <p class="mb-0" style="color: rgba(255,255,255,.8)">Save your address once, see every order you have placed, and book tables faster.</p>
                </div>
            </div>
            <div class="col-md-7">
                <div class="auth-form">
                    <h1 class="h3 mb-1">Create your account</h1>
                    <p class="text-muted-2 mb-4">Already registered? <a href="{{ route('login') }}">Log in</a></p>

                    <form action="{{ route('register.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="name">Full name</label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="phone">Phone <span class="text-muted-2 fw-normal">(optional)</span></label>
                                <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" autocomplete="tel">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@else<div class="form-text">At least 6 characters.</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="password_confirmation">Confirm password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg mt-4">Create account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
