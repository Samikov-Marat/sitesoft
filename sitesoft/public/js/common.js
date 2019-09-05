$(function () {

    // Отправка формы при клике по ссылке
    $('.js-logout-block-handler').click(function () {
        $(this).closest('.js-logout-block').find('form').submit();
        return false;
    })

});