@extends('layouts.template')
@section('title')
Montivory
@endsection
@section('meta')
    <meta property="og:title" content="Montivory">
    <meta property="og:description" content="">
    <meta property="og:image" content="{{ asset('/images/frontend/og.jpg')}}">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="" />
    <meta property="fb:pages" content="">
    <meta property="fb:app_id" content="">
    <meta property="twitter:image" content="{{ asset('/images/frontend/og.jpg')}}">
@endsection
@section('content')
<!-- Content -->
<main id="content">

    <section class="sc-career career-office-logo bg-img" data-bgimg-src="{{ asset('images/frontend/logo-long.png') }}" data-bgimg-srcset="{{ asset('images/frontend/logo-long.png') }}">

    </section>

    <section class="sc-career career-why">
        <div class="container">
            <div class="sc-inner">
                <div class="sc-heading animate fadeInUp">
                    <h2 class="sc-headline">{{ $position->position }}</h2>
                </div>
                <div class="career-content animate fadeInUp">
                    {!! html_entity_decode($position->description) !!}
                    {{-- <h1>Header title h1</h1>
                    <h2>Header title h2</h2>
                    <h3>Header title h3</h3>
                    <h4>Header title h4</h4>
                    <h5>Header title h5</h5>
                    <h6>Header title h6</h6>
                    <p>Paragraph</p>
                    <strong>Strong</strong>
                    <p>Our team are ready to listen to your specific needs and then share their in-depth knowledge, customer-oriented insights and hands-on experience to ensure we can achieve success together with you. We are the people you are looking for. We are the ones who will ask the right questions and then work with you to find the answer to what is most important to your success.</p> --}}
                </div>
            </div>
        </div>
    </section>
    <section class="sc-contact animate fadeInUp" id="joinus">
        <div class="container">
            <div class="sc-inner">
                <div class="sc-heading">
                    <h2 class="sc-headline">Join us</h2>
                </div>
                <div class="contact-form">
                    <form class="form" id="contactform">
                        <fieldset>
                            <div class="field d-none">
                                <div class="input select">
                                    <select data-placeholder="Please select" class="select2" id="position" name="position">
                                        <option value="{{$position->id}}" selected>{{$position->position}}</option>
                                     </select>
                                </div>
                            </div>
                            <div class="field">
                                <div class="input require">
                                    <label class="label anim">Full Name</label>
                                    <input type="text" name="fullname" id="fullname">
                                    <div class="invalid-feedback">
                                        Incorrect field
                                    </div>
                                </div>
                            </div>
                            <div class="field half-2">
                                <div class="input require">
                                    <label class="label anim">Phone</label>
                                    <input type="tel" name="phone" id="phone">
                                    <div class="invalid-feedback">
                                        Incorrect field
                                    </div>
                                </div>
                            </div>
                            <div class="field half-2">
                                <div class="input require">
                                    <label class="label anim">Email</label>
                                    <input type="email" name="email" id="email">
                                    <div class="invalid-feedback">
                                        Incorrect field
                                    </div>
                                </div>
                            </div>
                            <div class="field for-file" id="file-block">
                                <div class="input">
                                    <label class="label">Your CV</label>
                                    <input type="file" name="cv" id="cv">
                                    <div class="invalid-feedback">
                                        Incorrect field
                                    </div>
                                </div>
                                <span class="remark">Document, PDF or image files under 8MB accepted</span>
                            </div>
                            <div class="field">
                                <div class="input">
                                    <label class="label anim for-textarea">Message</label>
                                    <textarea name="message" id="message"></textarea>
                                    <div class="invalid-feedback">
                                        Incorrect field
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <button type="button" class="btn" id="sendContactBtn">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
@section('script')
<script src="{{asset('/plugin/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugin/swiper/swiper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugin/wow/wow.min.js')}}" type="text/javascript"></script>

<!-- Custom Script -->
<script src="{{asset('/js/theme.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/positiondetail.js')}}" type="text/javascript"></script>
<script>

</script>
@endsection
