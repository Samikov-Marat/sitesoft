$(function () {

    $('.js-start').one('click', function () {

        //$(this).closest('.b345').addClass('b345_light');


        if (!$(this).closest('.b345').hasClass('b345_light')) {
            var i = 0;
            var sSet = $(this).data('set');
            var aImageList = [];

            var $progressBar = $(this).closest('.b345').find('.js-load-progress');

            $progressBar.removeClass('hidden');

            for (i = 0; i < 32; i++) {
                aImageList[i] = new Image();
                aImageList[i].src = sSet + (i + 1) + '.png';
                aImageList[i].addEventListener("load", function (event) {
                    var oldCount = $progressBar.data('count');
                    $progressBar.data('count', oldCount + 1);
                    var newCount = $progressBar.data('count');

                    var progressPercent = 100.0 * newCount / 32.0;
                    $progressBar.html(Math.floor(progressPercent).toString() + '%');
                    if (32 == newCount) {
                        $progressBar.addClass('hidden');
                    }
                });
                $(this).data('image_list', aImageList);
            }

        }

        $(this).closest('.b345').addClass('b345_light');
    });



    $('.js-handler').bind('dragstart onselectstart onmousedown', function (event) {
        return false;
    });


    $('body').on('touchmove', function (event) {
        event.preventDefault();
    });




    var iMaxScroll = $("body").width() / 32;
    var SPEED = 2;
    iMaxScroll /= SPEED;

    if (iMaxScroll < 1) {
        iMaxScroll = 1;
    }







    $('.js-handler').each(function () {
        $(this).data('scroll', 0);
        $(this).data('next_png', 4);
    })


    function Move3D(movementX, $ImageHandler) {

        var iScroll = $ImageHandler.data('scroll');
        var next_png = $ImageHandler.data('next_png');

        iScroll += movementX;
        while (iScroll > iMaxScroll) {
            iScroll -= iMaxScroll;
            next_png = (next_png + 1) % 32;
        }
        while (iScroll < iMaxScroll) {
            iScroll += iMaxScroll;
            next_png = (next_png + 32 - 1) % 32;
        }
        var aImageList = $ImageHandler.data('image_list');
        $ImageHandler.closest('.b345').find('.js-image').prop('src', aImageList[next_png].src);
        $ImageHandler.closest('.b345').find('.js-bg').css({
            backgroundPositionX: 5510 / 32 * next_png
        });

        $ImageHandler.data('scroll', iScroll);
        $ImageHandler.data('next_png', next_png);
    }

    $('.js-handler').mousemove(function (oEvent) {
        if ($(this).hasClass('mouse_start_move')) {
            Move3D(oEvent.originalEvent.movementX, $(this));
        }
    });


    var fTouchX = 0;

    $('.js-handler').on('mousedown', function () {
        $(this).addClass('mouse_start_move');
    });

    $('.js-handler').on('mouseup', function () {
        $(this).removeClass('mouse_start_move');
    });


    $('.js-handler').on('touchstart', function (oEvent) {
        fTouchX = oEvent.originalEvent.changedTouches[0].clientX;
    });

    $('.js-handler').on('touchmove', function (oEvent) {
        var movementX = oEvent.originalEvent.changedTouches[0].clientX - fTouchX;
        Move3D(movementX, $(this));
        fTouchX = oEvent.originalEvent.changedTouches[0].clientX;
    });


    $('.js-form').submit(function () {
        var sUrl = $(this).prop('action');
        var aData = $(this).serializeArray();
        var $Modal = $(this).closest('.modal');
        aData.push({ name: 'guard', value: 1 });
        $.post({ url: sUrl, data: aData })
            .done(function () {
                $('#message_modal_done').modal('show');
            })
            .fail(function () {
                $('#message_modal_fail').modal('show');
            })
            .always(function () {
                $Modal.modal('hide');
            });
        return false;
    });


    var menuAnchors = $('.js-menu-anchor')
    
    $(window).on('resize scroll', function () {
        var currentScroll = $(window).scrollTop();
        menuAnchors.removeClass('active');
        var activeMenuItem = null;
        menuAnchors.each(function(){
            var selector = $(this).attr('href');
            var offset = $(selector).offset();
            if(offset.top <= currentScroll){
                activeMenuItem = $(this);
            }
        });
        activeMenuItem.addClass('active');
    });


});

var map;

DG.then(function () {
    map = DG.map('map', {
        center: [54.98, 82.89],
        zoom: 13,
        scrollWheelZoom: false,
        zoomControl: false,
        fullscreenControl: false
    });
    DG.control.zoom({position: 'bottomleft'}).addTo(map);
});
