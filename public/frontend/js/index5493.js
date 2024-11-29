$.fn.equivalent = function (){
    let $blocks = $(this);
    let maxH    = $blocks.eq(0).height();
    $blocks.each(function(){
        maxH = ( $(this).height() > maxH ) ? $(this).height() : maxH;
    });
    $blocks.height(maxH);
};

$.fn.isInViewport = function() {
    let elementTop = $(this).offset().top ;
    let elementBottom = elementTop + $(this).outerHeight();

    let viewportTop = $(window).scrollTop();
    let viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
};

function voAnimation (){
    let tl = gsap.timeline();

    let btnImg = '.button-img',
        cardImg = '.card-img',
        netWrap = '.network-wrap',
        shipLeads = '.ship-leads';

    tl.to(btnImg, {delay: 1, duration: .3, opacity: 1, scale: .8})
        .to(btnImg, {duration: .3, scale: 1.2})
        .to(btnImg, {duration: .3, scale: 1})
        .to(cardImg, {duration: .3, opacity: 1})
        .to(cardImg, {duration: .3, scale: 1.5})
        .to(netWrap, {duration: .5, x: -100, opacity: 0})
        .fromTo(shipLeads, 1, {x: 50, opacity: 0}, {x: 0, opacity: 1})
        .to('.lead1', {duration: .5, y: 0, opacity: 1})
        .to('.lead2', {duration: .5, y: 0, opacity: 1})
        .to('.lead3', {duration: .5, y: 0, opacity: 1})
        .to('.button-img, .card-img, .network-wrap, .ship-leads, .lead1, .lead2, lead3', 1, {opacity: 0}, "pause+=2");
    tl.repeat(-1)
}

function leAnimation (){
    let scrollEnabled = true;
    TweenLite.defaultEase = Linear.easeNone;
    let tl = gsap.timeline();
    let wrapperBlock = $(".wrapper-freight-marketplace");

    $(document).on('scroll', function () {
        if(wrapperBlock.isInViewport() && scrollEnabled ){
            scrollEnabled = false;

            tl.fromTo('.browser', .8, {opacity: 0, y: 20, scale: 0}, {opacity: 1, y: 0, scale: 1})
                .fromTo('.mail', .5, {opacity: 0, y: 20, scale: 0}, {opacity: 1, y: 0, scale: 1})
                .fromTo('.price', .5, {opacity: 0, y: -20}, {opacity: 1, y: 0})
                .fromTo('.rate1', .8, {x: 20, opacity: 0}, {x: 0, opacity: 1})
                .fromTo('.rate2', .8, {x: 20, opacity: 0}, {x: 0, opacity: 1})
                .fromTo('.map', .8, {y: -20, opacity: 0}, {y: 0, opacity: 1})
                .fromTo('.monitor', .8, {scale: 1, y: 0, x: 0}, {scale: 1.1, y: -10, x: -10})
                .fromTo('.monitor', 4, {scale: 1.1, y: -10, x: -10}, {scale: 1.1, y: -10, x: -10});
            tl.repeat(-1)
        }
    });
}

function lcAnimation(){
    let scrollEnabled = true;
    TweenLite.defaultEase = Linear.easeNone;
    let tl = gsap.timeline();
    let wrapperBlock = $(".wrapper-load-calculator");

    $(document).on('scroll', function () {
        if(wrapperBlock.isInViewport() && scrollEnabled ){
            scrollEnabled = false;

            function box_group_1() {
                let tl = gsap.timeline();
                tl
                    .fromTo('.box.box_blue_1', .5, {opacity: 0, y: -20}, {opacity: 1, y: 0})
                    .fromTo('.box.box_dark_4', .6, {opacity: 0, y: -20}, {opacity: 1, y: 0});
                return tl;
            }
            function box_group_2() {
                let tl = gsap.timeline();
                tl
                    .fromTo('.box.box_dark_1', .7, {opacity: 0, y: -20}, {opacity: 1, y: 0})
                    .fromTo('.box.box_dark_2', .4, {opacity: 0, y: -50}, {opacity: 1, y: 20});
                return tl;
            }
            function box_group_3() {
                let tl = gsap.timeline();
                tl
                    .fromTo('.box.box_blue_2', .4, {opacity: 0, y: -40}, {opacity: 1, y: 10})
                    .fromTo('.box.box_dark_5', .5, {opacity: 0, y: -30}, {opacity: 1, y: 0})
                    .fromTo('.box.box_dark_3', .4, {opacity: 0, y: -10}, {opacity: 1, y: 0});
                return tl;
            }
            function panels() {
                let tl = gsap.timeline();
                tl
                    .fromTo('.select_box_type', 1.2, {opacity: 0, y: -20}, {opacity: 1, y: 0})
                    .fromTo('.formulas', .6, {opacity: 0, x: -20}, {opacity: 1, x: 0})
                    .fromTo('.table', .5, {opacity: 0, y: 20}, {opacity: 1, y: 0})
                    .fromTo('.table', 4, {opacity: 1}, {opacity: 1});
                return tl;
            }
            tl.add(box_group_1(), 0)
                .add(box_group_2(), "-=1")
                .add(box_group_3(), "-=1")
                .add(panels(), "-=2");
            tl.repeat(-1)
        }
    });
}

function ctAnimation() {
    let scrollEnabled = true;
    TweenLite.defaultEase = Linear.easeNone;
    let tl = gsap.timeline();
    let wrapperBlock = $(".wrapper-container-tracking");

    $(document).on('scroll', function () {
        if(wrapperBlock.isInViewport() && scrollEnabled ){
            scrollEnabled = false;

            function box_group_1() {
                let tl = gsap.timeline();
                tl
                    .fromTo('.panel', .9, { left: '34%' }, { left: '32%'  })
                    .fromTo('.container_info', .1, { opacity: 0 }, {opacity: 1})
                    .fromTo('.container_info', .5, {  left: '37%', width: '24%', top: '23%' }, { width:"40%", left: "24%", top: "20%" })
                    .fromTo('.circle_small', .1, { opacity: 0 }, {opacity: 1})
                    .fromTo('.folder-name-box', .4, { opacity: 0 }, {opacity: 1})
                    .fromTo('.grey-line', .1, { opacity: 0 }, {opacity: 1})
                    .fromTo('.folder-icon', .1, { opacity: 0 }, {opacity: 1})
                    .fromTo('.folder-name', .6, { opacity: 0 }, {opacity: 1})
                    .fromTo('.folder-name', 4, { opacity: 1 }, {opacity: 1});
                return tl;
            }
            tl.add(box_group_1(), 0);
            tl.repeat(-1)
        }
    });
}

function maxHeight(el){
    let maxContHeight = 0;
    let contCount = el.length;

    el.each(function(){
        if ($(this).height() > maxContHeight) maxContHeight = $(this).height();
    });

    if (contCount <= 1 ){
        el.css('height', 'auto');
    } else {
        el.css('height', maxContHeight + 'px');
    }
}

let cookieCheck = () => {
    let getCookie = (name) => {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    };

    let currentCookie = getCookie('showpolicy');

    if(currentCookie !== 'hidden'){
        let cookiesBlock = $('.wrapper-cookies');

        cookiesBlock.addClass('active');

        cookiesBlock.find('.cookies-button a').on('click', () => {
            cookiesBlock.removeClass('active');
            document.cookie = 'showpolicy=hidden; expires=Fri, 19 Jun 2040 20:47:11 UTC; path=/'
        });
    }
};


$(document).ready(function(){
   /* start animation only on desktop version */
    if (!window.matchMedia("(max-width: 768px)").matches) {
        voAnimation();
        leAnimation();
        lcAnimation();
        ctAnimation();
       }


    cookieCheck();



    setTimeout(function(){
        $('.about-LogistiQuote .img-block').css('opacity', 1);
    }, 1000);

    $('.benefits .learn-more').on('click', function(){
        $(this).parents('.item').find('p').removeClass('hide-txt');
        $(this).remove();
    });

    $('.btn-bottom-nav a').click(function(e){
        e.preventDefault();
        $(this).hasClass('active');
        $('.btn-bottom-nav a').removeClass('active');
        $(this).addClass('active');
    });

    $('#rail-etngs').autocomplete(
        {
            minLength: 2,
            delay: 400,
            source: function (request, response) {
                $.ajax({
                    method: 'POST',
                    url: 'https://sirius.LogistiQuote.com/port/etng-search',
                    data: {search: request.term},
                    dataType: "json",

                    success: function (data) {
                        response($.map(data.SearchInRefResult, function (item) {
                            return { value: item.Name + " (" + item.Code + ")", data: item.Code }
                        }));
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        // alert(textStatus);
                    }
                })
            },
            select: function (event, ui) {
                $("#rail-etngs").val(ui.item.value);
                return false;
            }
        }
    ).each(function () {
        $(this).data("ui-autocomplete")._renderItem = function (ul, item) {
            $('.ui-autocomplete-input').removeClass('ui-autocomplete-loading');
            var htm = '<i></i><a>' + item.label + "</a>";
            return $("<li></li>").data("item.autocomplete", item).append(htm).appendTo(ul);
        };
    });


    $('.benefits').slick({
        infinite: true,
        dots: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        appendArrows: $('.benefits-arrow'),
        prevArrow: '<button id="prev" type="button"><span><i class="fa fa-chevron-left" aria-hidden="true"></i></span></button>',
        nextArrow: '<button id="next" type="button"><span><i class="fa fa-chevron-right" aria-hidden="true"></i></span></button>',
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 680,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });

    // $('.wrapper-freight-shipping .content').equivalent();
    $('.wrapper-how-it-works .content').equivalent();
    $('.wrapper-benefits-block .content').equivalent();


    // CANVAS BUBBLES
    maxHeight($('.our-apps-block .item p'));

    var pix_ratio = window.devicePixelRatio || 1;
    var canvas = document.getElementById('bubbles-canvas');
    var canvas_width = document.body.clientWidth;
    var canvas_height = 300;
    var orangeCircle = false;

    canvas.width = canvas_width * pix_ratio;
    canvas.height = canvas_height * pix_ratio;

    canvas.style.width = canvas_width + 'px';
    canvas.style.height = canvas_height + 'px';

    var ctx = canvas.getContext('2d'),
        bubblesArray = [];

    ctx.scale(pix_ratio,pix_ratio);

    function Bubble(x, y, dx, dy, radius, stroke, orange){
        this.x = x;
        this.y = y;
        this.dx = dx;
        this.dy = dy;
        this.radius = radius+2;
        this.color = 'rgba(236, 156, 9, 0.66)';
        this.stroke = stroke;
        this.orange = orange;

        this.draw = function(){
            ctx.beginPath();
            ctx.fillStyle = this.color;
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI*2, false);

            if(stroke){
                ctx.strokeStyle = 'rgba(0, 136, 255, 0.4)';
                 ctx.fillStyle = 'rgba(0, 136, 255, 0.4)';
                // ctx.stroke();
            } else {
                ctx.fill();
            }

            if (orange) {
                ctx.strokeStyle = 'rgba(0, 136, 255, 0.4)';
                ctx.fillStyle = 'rgba(0, 136, 255, 0.4)';
                ctx.fill();
            }
        };

        this.update = function(){
            if(this.x>canvas_width-this.radius || this.x-this.radius<0){
                this.dx = -this.dx;
            }
            if(this.y>canvas_height-this.radius || this.y-this.radius<0){
                this.dy = -this.dy;
            }

            this.x += this.dx;
            this.y += this.dy;

            this.draw();
        }
    }

    for (var i = 0; i < 30; i++){
        var x = Math.random()*(canvas_width-radius*2) + radius,
            y = Math.random()*(canvas_height-radius*2) + radius,
            dx = (Math.random() - 0.5)/3,
            dy = (Math.random() - 0.5)/3,
            radius = Math.random() * 4 + 1,
            stroke = Math.random(),
            orange = false;

        if(stroke > 0.5){
            stroke = true;
        } else {
            stroke = false;
        }

        if (orangeCircle == false ){
            orangeCircle = true;
            orange = true;
        }

        bubblesArray.push(new Bubble(x, y, dx, dy, radius, stroke, orange));
    }

    $(window).resize(function() {
        canvas.style.width = document.body.clientWidth;
    });

    function animate(){
        requestAnimationFrame(animate);
        ctx.clearRect(0, 0, canvas_width, canvas_height);

        for (var i = 0; i < bubblesArray.length; i++) {
            bubblesArray[i].update();
        }
    }

    animate();
    // CANVAS BUBBLES END


    var autodetectSealine = () => {
        var containerNumberInput = $('.filter-tracking input');
        var containerNumberSelect = $('.filter-tracking select');
        var containerNumber;
        var sealineNumber;

        containerNumberInput.on('change input copy paste cut', function () {
            containerNumber = $(this).val().toString().toUpperCase();

            if (typeof containerNumber === 'string' && containerNumber.length >= 3) {
                let prefix = containerNumber.trim().substr(0, 3).toUpperCase();
                let founded = false;

                for (let i = 0; i < PREFIXES.length; i++) {
                    if (PREFIXES[i].code.includes(prefix)) {
                        sealineNumber =  PREFIXES[i].tracking_id;
                        founded = true;
                    }
                }

                if(founded === true){
                    containerNumberSelect.val(sealineNumber);
                    containerNumberSelect.trigger('change');
                }else{
                    containerNumberSelect.val(0);
                    containerNumberSelect.trigger('change');
                }

            } else {
                containerNumberSelect.val(0);
                containerNumberSelect.trigger('change');
            }
        });
    };
    autodetectSealine();
});

$(window).ready( function () {
    animationDocument();
    animationTextHomePage();
});

function animationDocument() {
    let timerId = setTimeout(function animation() {
        $('.wrapper-documents-solutions .document.document_open').each( function () {
            $('.wrapper-documents-solutions .document').addClass('document_open');
            $(this).removeClass('document_open');
        });
        timerId = setTimeout(animation, 5000);
    }, 5000);

    let profileAnimation = setTimeout( function animation() {
        setTimeout( function () {
            $('.map-profile_wrapper .map-profile-one').addClass('animate');
        }, 2000);

        setTimeout( function () {
            $('.map-profile_wrapper .map-profile-two').addClass('show');
        }, 3500);

        setTimeout( function () {
            $('.card-elem_wrapper').addClass('blackout');
        }, 4500);

        setTimeout( function () {
            $('.card-elem_wrapper').removeClass('blackout');
            $('.map-profile_wrapper .map-profile-two').removeClass('show');
            $('.map-profile_wrapper .map-profile-one').removeClass('animate');
        }, 8000);

        profileAnimation = setTimeout(animation, 9000);
    }, 2000);
}



function animationTextHomePage() {
    let wrapperElem = $('.header-block-top');
        function textSvg(event) {
        let textAnim = $('.text-animation.active'),
            textTop = textAnim.offset().top,
            size = parseInt(textAnim.css('background-size'))/2;

        textAnim.css('background-position-x', (event.clientX - size));
        textAnim.css('background-position-y', (event.clientY - (size + textTop) ));
    }

        function positionTextHomePage() {
            let heightText = $('.text-animation.active span').height(),
                marginElem = parseInt($('.header-title').css('margin-top'));

            $('.header-title').css('margin-top', (heightText + marginElem));
        }
    if (window.matchMedia("(min-width: 769px)").matches) {
        wrapperElem.on('mousemove', textSvg);
        positionTextHomePage();
    }
}
