<footer class="site-footer">
    <div class="ajrak-strip" aria-hidden="true"></div>
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <a class="d-flex align-items-center gap-2 mb-3 text-white" href="{{ route('home') }}">
                    <span class="brand-mark" aria-hidden="true"><span>ذ</span></span>
                    <span class="display-font fs-3">{{ config('restaurant.short_name') }}</span>
                </a>
                <p class="mb-3" style="max-width: 34ch">Biryani, karahi and fresh fast food from our kitchen to your table since 2012.</p>
                <div class="social">
                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="https://wa.me/{{ config('restaurant.whatsapp') }}" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h5>Explore</h5>
                <ul>
                    <li><a href="{{ route('menu') }}">Menu</a></li>
                    <li><a href="{{ route('reservation') }}">Book a table</a></li>
                    <li><a href="{{ route('about') }}">About us</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h5>Your account</h5>
                <ul>
                    <li><a href="{{ route('cart.index') }}">Cart</a></li>
                    @auth
                        <li><a href="{{ route('account') }}">My orders</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Log in</a></li>
                        <li><a href="{{ route('register') }}">Create account</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-lg-4">
                <h5>Visit us</h5>
                <ul>
                    <li><i class="bi bi-geo-alt me-2"></i>{{ config('restaurant.address') }}</li>
                    <li><i class="bi bi-telephone me-2"></i><a href="tel:{{ config('restaurant.phone') }}">{{ config('restaurant.phone') }}</a></li>
                    <li><i class="bi bi-envelope me-2"></i><a href="mailto:{{ config('restaurant.email') }}">{{ config('restaurant.email') }}</a></li>
                    <li><i class="bi bi-clock me-2"></i>{{ config('restaurant.hours') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container py-3 d-flex flex-wrap justify-content-between gap-2">
            <span>&copy; {{ date('Y') }} {{ config('restaurant.name') }}. All rights reserved.</span>
            <span>Built with Laravel &amp; Bootstrap</span>
        </div>
    </div>
</footer>
