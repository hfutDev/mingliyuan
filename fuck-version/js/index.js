$(function () {
    var layers = $('.plaxify');
    $.each(layers, function (index, layer) {
        $(layer).plaxify({
            xRange: $(layer).data('xrange') || 0,
            yRange: $(layer).data('yrange') || 0,
            invert: $(layer).data('invert') || false
        });
    });
    $.plax.enable();

    var lis = $('.content li');
    $(window).scroll(function () {
        $.each(lis, function (index, li) {
            var obj = $(li);
            var top = li.getBoundingClientRect().top;
            var se = document.documentElement.clientHeight;
            if (se - top > 180) {
                if (!obj.hasClass('open')) {
                    obj.addClass('open');
                }
            } else {
                obj.removeClass('open');
            }
        });
    });
});