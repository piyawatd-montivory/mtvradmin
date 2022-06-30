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
                <div class="swiper-container loop multiple center benefit animate fadeInUp">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide benefit-card">
                            <div class="image object-fit"><img alt="" src="{{ asset('images/frontend/preview.png')}}"></div>
                        </div>
                        <div class="swiper-slide benefit-card">
                            <div class="image object-fit"><img alt="" src="{{ asset('images/frontend/preview.png')}}"></div>
                        </div>
                        <div class="swiper-slide benefit-card">
                            <div class="image object-fit"><img alt="" src="{{ asset('images/frontend/preview.png')}}"></div>
                        </div>
                        <div class="swiper-slide benefit-card">
                            <div class="image object-fit"><img alt="" src="{{ asset('images/frontend/preview.png')}}"></div>
                        </div>
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
                                <li id="1">Data Analytic</li>
                                <li id="2">UI Design</li>
                                <li id="3">Search Engine Optimization</li>
                                <li id="4">E-Marketing</li>
                                <li id="5">Software Developer</li>
                                <li id="6">Sales Representative</li>
                                <li id="7">Data Visualize</li>
                            </ul>
                            <button type="button" class="btn" id="skillbtn">APPLY</button>
                        </div>
                    </div>
                    <div class="skill-box">
                        <div class="skill-toggle" id="interesttoolbar">
                            <h3 class="skill-toggle-text interest-title">And I'm interest in</h3>
                        </div>
                        <div class="skill-panel">
                            <ul class="skill-list" id="interest-list">
                                <li id="1">Data Analytic</li>
                                <li id="2">UI Design</li>
                                <li id="3">Search Engine Optimization</li>
                                <li id="4">E-Marketing</li>
                                <li id="5">Software Developer</li>
                                <li id="6">Sales Representative</li>
                                <li id="7">Data Visualize</li>
                            </ul>
                        <button type="button" class="btn" id="interestbtn">APPLY</button>
                        </div>
                    </div>
                    <div class="skill-result d-none" id="skill-result-block">
                        <p class="total-result">4 Results</p>
                        <x-career-item id="1" title="Position A" skill="Skill Require: Lorem Ipsum, Sme Osum" description="“Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua." />
                        <x-career-item id="2" title="Position B" skill="Skill Require: Lorem Ipsum, Sme Osum" description="“Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua." />
                        <div class="skill-result-remark">
                            <p>Can't find the right one?</p>
                            <a href="#" class="und und-blue">CONTACT US</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="sc-contact animate fadeInUp">
        <div class="container">
            <div class="sc-inner">
                <div class="sc-heading">
                    <h2 class="sc-headline">Join us</h2>
                </div>
                <div class="contact-form">
                    <form class="form">
                        <fieldset>
                            <div class="field">
                                <div class="input select">
                                    <label class="label">Select position</label>
                                    <select data-placeholder="Please select" class="select2">
                                        <option value="">Please select</option>
                                        <option value="option">Option 1</option>
                                        <option value="option">Option 2</option>
                                        <option value="option">Option 3</option>
                                     </select>
                                </div>
                            </div>
                            <div class="field">
                                <div class="input require">
                                    <label class="label anim">Full Name</label>
                                    <input type="text" name="">
                                </div>
                            </div>
                            <div class="field half-2">
                                <div class="input require">
                                    <label class="label anim">Phone</label>
                                    <input type="tel" name="">
                                </div>
                            </div>
                            <div class="field half-2">
                                <div class="input require">
                                    <label class="label anim">Email</label>
                                    <input type="email" name="">
                                </div>
                            </div>
                            <div class="field for-file">
                                <div class="input">
                                    <label class="label">Your CV</label>
                                    <input type="file" name="">
                                </div>
                                <span class="remark">Document, PDF or image files under 8MB accepted</span>
                            </div>
                            <div class="field">
                                <div class="input">
                                    <label class="label anim for-textarea">Message</label>
                                    <textarea name=""></textarea>
                                </div>
                            </div>
                        </fieldset>
                        <button type="submit" class="btn">SUBMIT</button>
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
<script>
    $(function(){
        $('#skillbtn').on('click',function(){
            searchJob();
        });
        $('#interestbtn').on('click',function(){
            searchJob();
        });
        $('.interest-title').on('click',function(){
            changetoolbar();
        });
        $('.skill-title').on('click',function(){
            changetoolbar();
        });

    })

    function changetoolbar(){
        var show = true;
        if($('#interesttoolbar').attr('class') == 'skill-edit choose'){
            show = false;
        }
        if($('#skilltoolbar').attr('class') == 'skill-edit choose'){
            show = false;
        }
        if(!show){
            $('#interesttoolbar').attr('class','skill-toggle');
            $('#interestbtn').removeClass('d-none');
            $('#skilltoolbar').attr('class','skill-toggle');
            $('#skillbtn').removeClass('d-none');
            $('#skill-result-block').addClass('d-none');
        }
    }

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
        $('#skilltoolbar').attr('class','skill-edit choose');
        $('#interesttoolbar').attr('class','skill-edit choose');
        $('#skillbtn').addClass('d-none');
        $('#interestbtn').addClass('d-none');
        $('#skill-result-block').removeClass('d-none');
    }
</script>
@endsection
