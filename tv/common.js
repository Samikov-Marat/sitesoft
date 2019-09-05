
/*
$(function () {
    $('.js-popover').on('mouseover', function () {
        if ($(this).hasClass('open')) {
            $(this).trigger('click');
        }
    })
})
*/

$(function () {
    $('[data-toggle="popover"]').popover();
    //$('[data-toggle="dropdown"]').dropdown();
    $('.dropdown-toggle').dropdown();
  })