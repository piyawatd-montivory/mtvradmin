<div class="swiper-slide testimonial-card">
    {{-- {!! html_entity_decode($description) !!}
    <img alt="" src="{{ $image }}">
        <h3 class="testimonial-by-name">{{ $author }}</h3>
        <p class="testimonial-by-position">{{ $position }}</p> --}}
    <div class="testimonial-text">
        {!! html_entity_decode($description) !!}
    </div>
    <div class="testimonial-by">
        <img alt="" src="{{ $image }}">
        <h3 class="testimonial-by-name">{{ $author }}</h3>
        <p class="testimonial-by-position">{{ $position }}</p>
    </div>
</div>
