@unless (request()->routeIs('publicacoes'))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
@endunless
<script src="{{ asset('pingo-decor/js/script.js') }}" defer></script>
