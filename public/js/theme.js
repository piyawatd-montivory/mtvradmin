/* Page Loading
======================================================= */
jQuery(document).ready(function ($) {
    'use strict';
    setTimeout(function () {
        jQuery(window).trigger('resize').trigger('scroll');
    }, 100);
});







/* HTML Scroll Function
======================================================= */
(function (jQuery, window, document) {
    'use strict';

    let elSelector      = '',
        $element        = jQuery(elSelector),
        elHeight        = 0,
        elTop           = 0,
        $document       = jQuery(document),
        dHeight         = 0,
        $window         = jQuery(window),
        wHeight         = 0,
        wScrollCurrent  = 0,
        wScrollBefore   = 0,
        wScrollDiff     = 0;

    $window.on('scroll', function () {

        elHeight        = $element.outerHeight();
        dHeight         = $document.height();
        wHeight         = $window.height();
        wScrollCurrent  = $window.scrollTop();
        wScrollDiff     = wScrollBefore - wScrollCurrent;
        elTop           = parseInt($element.css('top')) + wScrollDiff;

        if ( wScrollCurrent <= 0 )
        {
            jQuery('html').removeClass("page-scrolling scroll-up scroll-down");
        }
        else if( wScrollDiff > 0 )
        {
            jQuery('html').addClass("page-scrolling");
            jQuery('html').addClass("scroll-up").removeClass("scroll-down");
        }
        else if( wScrollDiff < 0 )
        {
            jQuery('html').addClass("page-scrolling");
            jQuery('html').removeClass("scroll-up").addClass("scroll-down");
        }

        wScrollBefore = wScrollCurrent;
    });

})( jQuery, window, document );






/* Detect OS
======================================================= */
jQuery(function($){

    let isDevice = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isDevice.Android() || isDevice.BlackBerry() || isDevice.iOS() || isDevice.Opera() || isDevice.Windows());
        }
    };

    if( isDevice.any() ) {
        jQuery('html').addClass('is-device');
    } else {
        jQuery('html').removeClass('is-device');
    }

});

/* Detect IE & Edge
======================================================= */
jQuery(function($){
    let version = detectIE();

    if (version === false) {
        jQuery('html').removeClass("ie-edge");
        jQuery('html').removeClass("edge");
        jQuery('html').removeClass("ie");
    } else if (version >= 12) {
        jQuery('html').addClass("ie-edge");
        jQuery('html').addClass("edge");
    } else {
        jQuery('html').addClass("ie-edge");
        jQuery('html').addClass("ie");
    }

    function detectIE() {
        let ua = window.navigator.userAgent;

        let msie = ua.indexOf('MSIE ');
        if (msie > 0) {
            // IE 10 or older => return version number
            return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
        }

        let trident = ua.indexOf('Trident/');
        if (trident > 0) {
            // IE 11 => return version number
            let rv = ua.indexOf('rv:');
            return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
        }

        let edge = ua.indexOf('Edge/');
        if (edge > 0) {
            // Edge (IE 12+) => return version number
            return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
        }

        // other browser
        return false;
    }
});




/* Window Resize
======================================================= */
jQuery(function($){
    function viewportHeight() {
        if( !(jQuery("html").hasClass("ie")) ) {
            let vh = window.innerHeight * (0.01);
            document.documentElement.style.setProperty('--vh', vh + 'px');
        }
    }

    function pageStyle() {
        if( jQuery('.header-fixed').length ){
            jQuery('#page').css('padding-top', jQuery('.header-fixed').outerHeight());
        }
    }

    function bgChange(Obj) {
        bgImg = jQuery(Obj);
        bgImgSrc = jQuery(Obj).data('bgimg-src');
        bgImgSrcset = typeof jQuery(Obj).data('bgimg-srcset') != 'undefined' ? jQuery(Obj).data('bgimg-srcset') : '';

        let width = jQuery(document).width();
        if (width < 768 && bgImgSrcset != '' ) {
            bgImg.css({ "background-image": 'url(' + bgImgSrcset + ')' });
        } else {
            bgImg.css({ "background-image": 'url(' + bgImgSrc + ')' });
        }
    }
    function bgChangeInit() {
        jQuery('.bg-img').each(function(){
            let Obj = jQuery(this);
            bgChange( Obj );
        });
    }

    function imgChange(Obj) {
        img = jQuery(Obj);
        imgSrc = jQuery(Obj).data('img-src');
        imgSrcset = typeof jQuery(Obj).data('img-srcset') != 'undefined' ? jQuery(Obj).data('img-srcset') : '';

        let width = jQuery(document).width();
        if (width < 768 && imgSrcset != '' ) {
            img.attr("src", imgSrcset);
        } else {
            img.attr("src", imgSrc);
        }
    }
    function imgChangeInit() {
        jQuery('.img-change').each(function(){
            let Obj = jQuery(this);
            imgChange( Obj );
        });
    }

    setTimeout(function(){
        pageStyle();
    },100);

    viewportHeight();
    bgChangeInit();
    imgChangeInit();

    jQuery(window).resize(function(){
        viewportHeight();
        pageStyle();
        bgChangeInit();
        imgChangeInit();
    });
});






/* Form
======================================================= */
jQuery(function($){

    let formElement = jQuery('input, textarea, select');

    // Blur Input
    jQuery(document).ready(function($){
        formElement.blur();
        jQuery('.search-form input').blur();
    });

    formElement.each(function(){
        if( !jQuery(this).val() ) {
            jQuery(this).closest('.input').removeClass('filled');
        } else {
            jQuery(this).closest('.input').addClass('filled');
        }
    });
    formElement.focusin(function(){
        jQuery(this).closest('.input').addClass('filled');
    });
    formElement.focusout(function(){
        if( !jQuery(this).val() ) {
            jQuery(this).closest('.input').removeClass('filled');
        }
    });


    // Select
    jQuery(".select").each(function(){
        let selectParent = jQuery(this),
            select = jQuery(this).find(".select2"),
            selectFilter = jQuery(this).find(".select2-filter");

        let query = {};
        function markMatch (text, term) {
            let match = text.toUpperCase().indexOf(term.toUpperCase());

            let jQueryresult = jQuery('<span></span>');

            if (match < 0) {
                return jQueryresult.text(text);
            }

            jQueryresult.text(text.substring(0, match));

            let jQuerymatch = jQuery('<span class="select2-rendered__match"></span>');
            jQuerymatch.text(text.substring(match, match + term.length));

            jQueryresult.append(jQuerymatch);

            jQueryresult.append(text.substring(match + term.length));

            return jQueryresult;
        }

        select.select2({
            width: '100%',
            minimumResultsForSearch: -1,
            dropdownParent: selectParent,
            templateResult: function (item) {
                if (item.loading) {
                    return item.text;
                }

                let term = query.term || '';
                let jQueryresult = markMatch(item.text, term);

                return jQueryresult;
            },
            language: {
                searching: function (params) {
                    query = params;
                    return 'Searching...';
                }
            }
        }).on("select2:select", function(e) {
            selectParent.closest('.input').addClass('filled');
        }).on("select2:unselect", function(e) {
            selectParent.closest('.input').removeClass('filled');
        });

        selectFilter.select2({
            width: '100%',
            allowClear: true,
            dropdownParent: selectParent,
            templateResult: function (item) {
                if (item.loading) {
                    return item.text;
                }

                let term = query.term || '';
                let jQueryresult = markMatch(item.text, term);

                return jQueryresult;
            },
            language: {
                searching: function (params) {
                    query = params;
                    return 'Searching...';
                }
            }
        }).on("select2:unselecting", function(e) {
            jQuery(this).data('state', 'unselected');
        }).on("select2:open", function(e) {
            if (jQuery(this).data('state') === 'unselected') {
                jQuery(this).removeData('state');
                let self = jQuery(this);
                self.select2('close');
            }
        });

        select.parent(".select").addClass("select2-parent");
        selectFilter.parent(".select").addClass("select2-parent");


        jQuery(this).find('select').click(function(){
            if (jQuery(this)[0].selectedIndex < 0) {
                selectParent.closest('.input').removeClass('filled');
            }
            else {
                selectParent.closest('.input').addClass('filled');
            }
        });
    });


    jQuery('<button type="button" class="decrease">-</button>').insertBefore( jQuery('input[name="quantity"]')   );
    jQuery('<button type="button" class="increase">+</button>').insertAfter( jQuery('input[name="quantity"]')   );

    jQuery('.increase').click(function () {
        if (jQuery(this).prev().val() < 10) {
            jQuery(this).prev().val(+jQuery(this).prev().val() + 1);
        }
    });
    jQuery('.decrease').click(function () {
        if (jQuery(this).next().val() > 1) {
            if (jQuery(this).next().val() > 1) jQuery(this).next().val(+jQuery(this).next().val() - 1);
        }
    });

});








/* Animate
======================================================= */
jQuery(function($){
    jQuery('.entry .entry-header, .entry .entry-content > *').addClass('animate fadeIn');

    if(jQuery(".animate").length){
        let wow = new WOW({
            boxClass: 'animate'
        });
        wow.init();
    }
});






/* Slide
======================================================= */
jQuery(function(){

    if(jQuery('.swiper-container.default').length){
        jQuery(".swiper-container.default").each(function(){
            let sliderWrapper = jQuery(this).find(".swiper-wrapper"),
                sliderPagination = jQuery(this).find(".swiper-pagination"),
                sliderButtonPrev = jQuery(this).find(".swiper-button-prev"),
                sliderButtonNext = jQuery(this).find(".swiper-button-next"),
                sliderScrollbar = jQuery(this).find(".swiper-scrollbar");

            // Option
            let sliderFade = jQuery(this).hasClass("fade"),
                sliderLoop = jQuery(this).hasClass("loop"),
                sliderAutoplay = jQuery(this).hasClass("autoplay"),
                sliderFraction = jQuery(this).hasClass("fraction");


            let swiper = new Swiper(jQuery(this), {
                pagination: {
                    el: ( (sliderPagination.length) ? sliderPagination : '' ),
                    type: ( (sliderFraction) ? 'fraction' : 'bullets' ),
                    clickable: true,
                },
                navigation: {
                    prevEl: ( (sliderButtonPrev.length) ? sliderButtonPrev : '' ),
                    nextEl: ( (sliderButtonNext.length) ? sliderButtonNext : '' ),
                },
                scrollbar: {
                    el: ( (sliderScrollbar.length) ? sliderScrollbar : '' ),
                    clickable: true,
                    draggable: true,
                    snapOnRelease: true,
                },
                effect: ( (sliderFade) ? 'fade' : 'slide' ),
                loop: sliderLoop,
                speed: 1000,
                longSwipesMs: 1000,
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                },
                watchOverflow: true,
            });

            if( !sliderAutoplay ) {
                swiper.autoplay.stop();
            } else {
                swiper.autoplay.start();
            }

        });
    }



    if(jQuery(".swiper-container.multiple").length){
        jQuery(".swiper-container.multiple").each(function(){
            let sliderWrapper = jQuery(this).find(".swiper-wrapper"),
                sliderPagination = jQuery(this).find(".swiper-pagination"),
                sliderButtonPrev = jQuery(this).find(".swiper-button-prev"),
                sliderButtonNext = jQuery(this).find(".swiper-button-next");

            // Option
            let sliderLoop = jQuery(this).hasClass("loop"),
                sliderAutoplay = jQuery(this).hasClass("autoplay"),
                slideCenter = jQuery(this).hasClass("center"),
                slideClicked = jQuery(this).hasClass("clicked");

            let swiper = new Swiper(jQuery(this), {
                pagination: {
                    el: ( (sliderPagination.length) ? sliderPagination : '' ),
                    type: 'fraction',
                    clickable: true,
                },
                navigation: {
                    prevEl: ( (sliderButtonPrev.length) ? sliderButtonPrev : '' ),
                    nextEl: ( (sliderButtonNext.length) ? sliderButtonNext : '' ),
                },
                effect: 'slide',
                loop: sliderLoop,
                speed: 1000,
                longSwipesMs: 1000,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                slidesPerView: 'auto',
                spaceBetween: 0,
                watchOverflow: true,
                observer: true,
                observeParents: true,
                centerInsufficientSlides: true,
                centeredSlides: slideCenter,
                slideToClickedSlide: slideClicked,
                breakpoints: {
                    1025: {
                    centeredSlides: false,
                  }
                }
            });

            if( !sliderAutoplay ) {
                swiper.autoplay.stop();
            } else {
                swiper.autoplay.start();
            }

        });
    }



    if(jQuery('.thumb-gallery-slider').length){
        jQuery('.thumb-gallery-slider').each(function(){
            let sliderButtonPrev = jQuery(this).find(".swiper-button-prev"),
                sliderButtonNext = jQuery(this).find(".swiper-button-next");

            // Option
            let sliderAutoplay = jQuery(this).hasClass("autoplay"),
                slideClicked = jQuery(this).hasClass("clicked");

            let galleryThumb = jQuery(this).find('.gallery-thumb'),
                galleryPreview = jQuery(this).find('.gallery-preview');

            let sliderThumb = new Swiper( galleryThumb , {
                spaceBetween: 0,
                slidesPerView: 'auto',
                loop: false,
                freeMode: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                watchOverflow: true,
                centerInsufficientSlides: true,
            });

            let sliderPreview = new Swiper( galleryPreview , {
                spaceBetween: 0,
                loop: true,
                navigation: {
                    prevEl: ( (sliderButtonPrev.length) ? sliderButtonPrev : '' ),
                    nextEl: ( (sliderButtonNext.length) ? sliderButtonNext : '' ),
                },
                thumbs: {
                    swiper: sliderThumb,
                },
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                },
                speed: 1000,
                longSwipesMs: 1000,
                watchOverflow: true,
                slideToClickedSlide: slideClicked,
            });

            if( !sliderAutoplay ) {
                swiper.autoplay.stop();
            } else {
                swiper.autoplay.start();
            }

        });
    }

});





/* Location Hash
======================================================= */
jQuery(function($){
    jQuery('.menu-scroll[href*="#"]').on('click', function(e) {
        e.preventDefault();
        var headerHeight = jQuery("#header").outerHeight(),
            position = jQuery(jQuery(this).attr("href")).offset().top - headerHeight;

        jQuery('html, body').animate({
            scrollTop: position
        }, 1000 )
    });
});

// function onScroll(event){
//     var menu = jQuery('.menu-scroll'),
//         scrollPos = jQuery(document).scrollTop();

//     menu.each(function(){
//         var currLink = jQuery(this),
//             refElement = jQuery(currLink.attr('href')),
//             nav = jQuery('#header').outerHeight(),
//             h = nav;

//         if(refElement.length){
//             if (refElement.position().top-h <= scrollPos && refElement.position().top-h + refElement.height() > scrollPos) {
//                 menu.removeClass('active');
//                 currLink.addClass('active');
//             }
//             else{
//                 currLink.removeClass('active');
//             }
//         }
//     });
// }

jQuery(function($){
    // jQuery(document).on('scroll', onScroll);
});






// Career Skill
$('.skill-panel').slideToggle();
// jQuery('.skill-toggle').click(function(e){
//     jQuery(this).next('.skill-panel').slideToggle();
//     jQuery(this).toggleClass('open');
// });

jQuery('.skill-list li').click(function(e){
    jQuery(this).toggleClass('clicked');
});

jQuery('.skill-edit').click(function(e){
    jQuery(this).next('.skill-panel').find('li').toggle();
    jQuery(this).next('.skill-panel').find('li.clicked').toggle(true);
    j
});
