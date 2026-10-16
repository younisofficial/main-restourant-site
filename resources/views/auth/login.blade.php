@extends('layouts.app')

@section('title', 'Log in')

@section('content')
<section class="auth-wrap">
    <div class="container" style="max-width: 940px">
        <div class="auth-card row g-0">
            <div class="col-md-5 d-none d-md-block">
                <div class="auth-side">
                    <div class="urdu" lang="ur">ذائقہ</div>
                    <h2 class="h3">Welcome back</h2>
                    <p class="mb-0" style="color: rgba(255,255,255,.8)">Log in to reorder your favourites and track your deliveries.</p>
                </div>
            </div>
            <div class="col-md-7">
                <div class="auth-form">
                    <h1 class="h3 mb-1">Log in</h1>
                    <p class="text-muted-2 mb-4">New here? <a href="{{ route('register') }}">Create an account</a></p>

                    <form action="{{ route('login.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus autocomplete="email">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" @checked(old('remember'))>
                            <label class="form-check-label" for="remember">Keep me logged in</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg">Log in</button>
                    </form>

                    <div class="mt-4 p-3 rounded-3 small" style="background: var(--paper)">
                        <strong>Demo accounts</strong><br>
                        Admin: admin@zaiqa.com / admin123<br>
                        Customer: ali@example.com / password
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
