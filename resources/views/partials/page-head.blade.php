<section class="page-head">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $crumb ?? $title }}</li>
            </ol>
        </nav>
        <h1>{{ $title }}</h1>
        @isset($subtitle)<p>{{ $subtitle }}</p>@endisset
    </div>
</section>
<div class="ajrak-strip" aria-hidden="true"></div>
