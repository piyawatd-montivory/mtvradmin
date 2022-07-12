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
@section('stylesheet')
<style>

</style>
@endsection
@section('content')
<!-- Content -->
<main id="content">

    <section class="sc-hero bg-img" data-bgimg-src="{{ asset('/images/frontend/img01.jpg')}}" data-bgimg-srcset="{{ asset('/images/frontend/img01.jpg')}}">
        <div class="container">
            <div class="sc-inner">
                <h1 class="hero-title animate fadeInUp">Digital is your thing.<br>Making digital work is our thing.</h1>
            </div>
        </div>
    </section>

    <section class="sc-team bg-img" data-bgimg-src="{{ asset('/images/frontend/img02.jpg')}}" data-bgimg-srcset="{{ asset('/images/frontend/img02.jpg')}}">
        <div class="container">
            <div class="sc-inner">
                <div class="team-text animate fadeInUp">
                    <p>We, Team Montivory, hereby declare:<br>
                    We will lead our clients into this era of digital technology with their goals and needs in mind. We will work as a partner with our clients to co-create solutions that bring achievements to their organisations. We will use our combined strengths as an integral team to be an experience creator that makes a difference.</p>
                </div>
                <h5 class="team-by animate fadeInUp">The team of Montivory</h5>
            </div>
        </div>
    </section>

    <section class="sc-preprocess bg-img" data-bgimg-src="{{ asset('/images/frontend/img03.jpg')}}" data-bgimg-srcset="{{ asset('/images/frontend/img03.jpg')}}">
        <div class="container">
            <div class="sc-inner">
                <h1 class="preprocess-title animate fadeInUp">First Things First</h1>
                <div class="preprocess-text animate fadeInUp">
                    <p>Achieving the best results always begins with choosing the right process.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="sc-testimonial d-none">
        <div class="container">
            <div class="sc-inner">
                <div class="testimonial-heading animate fadeInUp">
                    <h2 class="sc-headline">Testimonial</h2>
                    <h4 class="sc-subhead">See what People are Saying</h4>
                </div>
                <div class="swiper-container loop multiple center testimonial animate fadeInUp">
                    <div class="swiper-wrapper">
                        @foreach ($testimonials as $testimonial)
                            <x-testimonial-card author="{{$testimonial->author}}" position="{{$testimonial->position}}" image="{{ asset($testimonial->image) }}" description="{{$testimonial->description}}" />
                        @endforeach
                    </div>
                    <div class="swiper-navigation">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="sc-partner">
        <div class="container">
            <div class="sc-inner">
                <div class="sc-heading animate fadeInUp">
                    <h2 class="sc-headline">Partner</h2>
                </div>
                <div class="partner-list animate fadeInUp">
                    @foreach ($partners as $partner)
                        @if(($loop->index % 4) == 0)
                        </div>
                        <div class="partner-list animate fadeInUp">
                        @endif
                    <a href="{{ $partner->url }}"><img alt="" src="{{ asset($partner->logo)}}"></a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="sc-provide sc-white">
        <div class="container">
            <div class="sc-inner">
                <div class="sc-heading animate fadeInUp">
                    <h2 class="sc-headline">What we provide</h2>
                    <p class="sc-subhead">We're offering services & solutions to help your business grow in digital age</p>
                </div>
                <ul class="provide-list animate fadeInUp">
                    <li>
                        <img alt="" src="{{asset('/images/frontend/provide-icon-01.png')}}">
                        <p>Business Consulting & Project Management</p>
                    </li>
                    <li>
                        <img alt="" src="{{asset('/images/frontend/provide-icon-02.png')}}">
                        <p>Data Privacy & Consulting</p>
                    </li>
                    <li>
                        <img alt="" src="{{asset('/images/frontend/provide-icon-03.png')}}">
                        <p>Experience Design</p>
                    </li>
                    <li>
                        <img alt="" src="{{asset('/images/frontend/provide-icon-04.png')}}">
                        <p>Operation Service</p>
                    </li>
                    <li>
                        <img alt="" src="{{asset('/images/frontend/provide-icon-05.png')}}">
                        <p>Technical Consultant</p>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="sc-people d-none">
        <div class="container">
            <div class="sc-inner">
                <div class="sc-heading animate fadeInUp">
                    <h2 class="sc-headline">Our Key People</h2>
                    <p class="sc-subhead">#TEAMMONTIVORY</p>
                </div>
                <div class="sc-grid-four cardgroup">
                    @foreach ($teams as $team)
                        <x-card-people image="{{asset($team->image)}}" fullname="{{$team->firstname}} {{$team->lastname}}" position="{{$team->job_position}}" linkedinurl="{{($team->linkedin_url)?$team->linkedin_url:'#'}}"/>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="sc-contact animate fadeInUp">
        <div class="container">
            <div class="sc-inner">
                <div class="sc-heading">
                    <h2 class="sc-headline">Contact us</h2>
                </div>
                <div class="contact-form">
                    <form class="form">
                        <fieldset>
                            <div class="field">
                                <div class="input select require">
                                    <label class="label">What can we help ?</label>
                                    <select data-placeholder="Please select topic" class="select2" id="contact-title">
                                        <option value="none">Please select topic</option>
                                        <option value="sales">Contact Sales</option>
                                        <option value="partner">Become Partner</option>
                                        <option value="job">Apply Job</option>
                                     </select>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset id="contact-fieldset">
                            <div class="field half-2">
                                <div class="input require">
                                    <label class="label anim">Full Name</label>
                                    <input type="text" name="contact-fullname" id="contact-fullname">
                                    <div class="invalid-feedback">
                                        Incorrect field
                                    </div>
                                </div>
                            </div>
                            <div class="field half-2">
                                <div class="input require">
                                    <label class="label anim">Company</label>
                                    <input type="text" name="company" id="company">
                                    <div class="invalid-feedback">
                                        Incorrect field
                                    </div>
                                </div>
                            </div>
                            <div class="field half-2">
                                <div class="input require">
                                    <label class="label anim">Phone</label>
                                    <input type="tel" name="contact-phone" id="contact-phone">
                                    <div class="invalid-feedback">
                                        Incorrect field
                                    </div>
                                </div>
                            </div>
                            <div class="field half-2">
                                <div class="input require">
                                    <label class="label anim">Email</label>
                                    <input type="email" name="contact-email" id="contact-email">
                                    <div class="invalid-feedback">
                                        Incorrect field
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <div class="input">
                                    <label class="label anim for-textarea">Message</label>
                                    <textarea name="contact-message" id="contact-message"></textarea>
                                    <div class="invalid-feedback">
                                        Incorrect field
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset id="cv-fieldset">
                            <div class="field" id="position-block">
                                <div class="input select require">
                                    <label class="label">Select position</label>
                                    <select class="select2" id="position">
                                        @foreach ($positions as $position)
                                            <option value="{{$position->id}}" @if($loop->first) selected @endif >{{$position->position}}</option>
                                        @endforeach
                                     </select>
                                </div>
                            </div>
                            <div class="field">
                                <div class="input require">
                                    <label class="label anim">Full Name</label>
                                    <input type="text" name="cv-fullname" id="cv-fullname">
                                    <div class="invalid-feedback">
                                        Incorrect field
                                    </div>
                                </div>
                            </div>
                            <div class="field half-2">
                                <div class="input require">
                                    <label class="label anim">Phone</label>
                                    <input type="tel" name="cv-phone" id="cv-phone">
                                    <div class="invalid-feedback">
                                        Incorrect field
                                    </div>
                                </div>
                            </div>
                            <div class="field half-2">
                                <div class="input require">
                                    <label class="label anim">Email</label>
                                    <input type="email" name="cv-email" id="cv-email">
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
                                    <textarea name="cv-message" id="cv-message"></textarea>
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
<div class="modal fadeIn" id="modal" tabindex="-1">
    <img src="{{asset('images/mtvr-lazy-load-logo.gif')}}"/>
</div>
</main>
@endsection
@section('script')
<script src="{{asset('/plugin/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugin/swiper/swiper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugin/wow/wow.min.js')}}" type="text/javascript"></script>

<!-- Custom Script -->
<script src="{{asset('/js/theme.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/home.js')}}" type="text/javascript"></script>
@endsection
