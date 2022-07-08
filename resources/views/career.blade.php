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

    <section class="sc-career career-join bg-img" data-bgimg-src="{{ asset('images/frontend/career-hero.jpg') }}" data-bgimg-srcset="{{ asset('images/frontend/career-hero.jpg') }}">
        <div class="container">
            <div class="sc-inner">
                <div class="sc-heading animate fadeInUp">
                    <h2 class="sc-headline">Join<br>OurTeam</h2>
                </div>
            </div>
        </div>
    </section>

    <section class="sc-career career-why">
        <div class="container">
            <div class="sc-inner">
                <div class="sc-heading animate fadeInUp">
                    <h2 class="sc-headline">Why Montivory</h2>
                </div>
                <div class="career-content animate fadeInUp">
                    <p>Today, many organizations proudly tell us that they have successfully transformed themselves digitally. But no one shares the story of what they did before they were successful. So where should
                        we start?</p>
                    <p>And no one tells us that apart from implementing the technology, there’s still a very important phase that must be completed first. Before your organization can get up and set off on a real journey to success, you have to start by laying the foundation. At Montivory, we don't just provide you with the latest and best technology.</p>
                    <p>Our team are ready to listen to your specific needs and then share their in-depth knowledge, customer-oriented insights and hands-on experience to ensure we can achieve success together with you. We are the people you are looking for. We are the ones who will ask the right questions and then work with you to find the answer to what is most important to your success.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="sc-career career-benefit sc-white">
        <div class="container">
            <div class="sc-inner">
                <div class="sc-heading animate fadeInUp">
                    <h2 class="sc-headline">Our Benefit</h2>
                </div>
                <div class="career-content animate fadeInUp">
                    <p class="headline"><strong>Lifestyle at Montivory</strong></p>
                    <p>Montivory ensures our employees enjoy an excellent experience through working with us, from the welfare & benefits we provide to the activities we create to enhance their skills and knowledge and the career development opportunities we offer.</p>
                    <p class="headline"><strong>Work-Life Balance</strong></p>
                    <p>Through Montivory's group insurance scheme, all our employees receive life insurance, OPD, IPD, and dental cover, while we also manage the employees’ social security and workmen's compensation fund. To create opportunities for our employees to recharge and share ideas in the workplace, we also provide a snack bar and beverages. In addition, we host activities such as a New Year Party and company outings to celebrate special events and create unity among employees across the company.</p>
                    <p class="headline"><strong>We Value Our People</strong></p>
                    <p>To ensure that our employees can grow together with the company, we provide knowledge sharing classes and training courses to develop the expertise and enhance the potential of employees at all levels.
                        Because we want the best for our employees, we continue to work towards creating better benefits for everyone in our team.</p>
                </div>
                @if(count($benefitGallery) > 0)
                    <div class="swiper-container loop multiple center benefit animate fadeInUp">
                        <div class="swiper-wrapper">
                            @foreach ($benefitGallery as $gallery)
                                <div class="swiper-slide benefit-card">
                                    <div class="image object-fit"><img alt="" src="{{ asset($gallery->image)}}"></div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-navigation">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="sc-career career-skill">
        <div class="container">
            <div class="sc-inner">
                <div class="sc-heading animate fadeInUp">
                    <h2 class="sc-headline">Join Our Company</h2>
                </div>
                <div class="career-content animate fadeInUp">
                    <div class="skill-box">
                        <div class="skill-toggle" id="skilltoolbar">
                            <h3 class="skill-toggle-text skill-title">I have skill in</h3>
                        </div>
                        <div class="skill-panel">
                            <ul class="skill-list" id="skill-list">
                                @foreach ($skills as $skill)
                                    <li id="{{ $skill->id }}" name="{{ $skill->name }}">{{ $skill->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="skill-box">
                        <div class="skill-toggle" id="interesttoolbar">
                            <h3 class="skill-toggle-text interest-title">And I'm interest in</h3>
                        </div>
                        <div class="skill-panel">
                            <ul class="skill-list" id="interest-list">
                                @foreach ($interests as $interests)
                                    <li id="{{ $interests->id }}" name="{{ $interests->name }}">{{ $interests->name }}</li>
                                @endforeach
                            </ul>
                        <button type="button" class="btn" id="applybtn">APPLY</button>
                        </div>
                    </div>
                    <div class="skill-result d-none" id="skill-result-block">

                    </div>
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
                            <div class="field">
                                <div class="input select">
                                    <label class="label">Select position</label>
                                    <select data-placeholder="Please select" class="select2" id="position" name="position">
                                        <option value="none">Please select</option>
                                        @foreach ($positions as $position)
                                        <option value="{{$position->id}}">{{$position->position}}</option>
                                        @endforeach
                                        <option value="other">Other</option>
                                     </select>
                                     <div class="invalid-feedback">
                                        Incorrect field
                                    </div>
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
<script src="{{asset('/js/career.js')}}" type="text/javascript"></script>
<script>

    function searchJob(){
        //skill
        var data = {};
        var skill = [];
        var interest = [];
        $.each($('#skill-list li'),function(key,value){
            if($(value).attr('class') == 'clicked'){
                skill.push($(value).attr('id'));
            }
        });
        data.skill = skill;
        //interest
        $.each($('#interest-list li'),function(key,value){
            if($(value).attr('class') == 'clicked'){
                interest.push($(value).attr('id'));
            }
        });
        data.interest = interest;
        $( ".apply-job").unbind( "click" );
        $('#skill-result-block').html('');
        $('#position').html('');
        $('#position').append('<option value="none">Please select</option>');
        $.ajax({
            url:"{{route('apiposition')}}",
            method:"POST",
            data:data,
            success:function(response){
                $('#skill-result-block').append('<p class="total-result">'+response.total+' Results</p>');
                $.each(response.data,function(key,value){
                    var str = '<div class="skill-result-box fadeIn">';
                        str += '<h3 class="skill-result-position">'+value.position+'</h3>';
                        str += '<p class="skill-result-require">'+value.short_description+'</p>';
                        str += '<div class="skill-result-description">';
                        str += '<p>'+value.description+'</p>';
                        str += '</div>';
                        str += '<a href="#joinus" position="'+value.id+'" class="menu-scroll apply-job">APPLY NOW</a> <a href="{{url('/career')}}/'+value.alias+'" class="menu-scroll apply-job">DETAIL</a>';
                        str += '</div>';
                        $('#skill-result-block').append(str);
                        $('#position').append('<option value="'+value.id+'">'+value.position+'</option>').fadeIn(1000);
                });
                $('#position').append('<option value="other">Other</option>');
                var lastblock = '<div class="skill-result-remark"><p>Can\'t find the right one?</p><a href="#joinus" class="und und-blue apply-job" position="other">CONTACT US</a></div>';
                $('#skill-result-block').append(lastblock);
                $('.apply-job').on('click',function(){
                    $('#position').val($(this).attr('position')).change();
                });
            }
        });
        $('#skilltoolbar').attr('class','skill-edit choose');
        $('#interesttoolbar').attr('class','skill-edit choose');
        $('#applybtn').addClass('d-none');
        $('#skill-result-block').removeClass('d-none');

    }
</script>
@endsection
