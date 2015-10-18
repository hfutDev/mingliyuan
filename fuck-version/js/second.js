$(function () {

    function getQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) {
            return unescape(r[2])
        }
        return null;
    }

    var urlName = getQueryString('name') || 'hong';

    var urls = {
        hong: 'http://hsxd.hfutonline.net/',
        ping: 'http://xsdr.hfutonline.net/',
        li: 'http://gxszk.ahedu.gov.cn/',
        si: 'http://xcb.hfut.edu.cn/',
        de: [
            'http://news.hfut.edu.cn/list-4-1.html',
            'http://votesys.hfutonline.net/index/vote1415',
            'http://uzone.univs.cn/special/1/1304/index.html',
            'http://210.45.241.156/yjs/uploads/plus/list.php?tid=6'
        ],
        lian: 'http://jw.hfutonline.net/index.php',
        yi: 'http://mly.hfutonline.net/html/zhiyixingkong/',
        ai: 'http://dxsxlgh.hfut.edu.cn/welcome/'
    };

    $('#iframe').attr('src', urls[urlName]);


    function update(name) {
        var imgs = $('li > img');
        $.each(imgs, function (index, img) {
            var obj = $(img);
            if (obj.data('name') === name) {
                obj.addClass('active');
                var str = obj.next('p').html().replace(/<br>/g, '');
                $('.vertical-name').html('');
                for (var i = 0; i < str.length; i++) {
                    $('.vertical-name').html($('.vertical-name').html() + '<p>' + str[i] + '</p>');
                }
            }
            if (obj.hasClass('active') && obj.data('name') === 'de') {
                $('.plate').css('display', 'block');
            }
        });
    }

    update(urlName);

    var imgs = $('li > img');
    $.each(imgs, function (index, img) {
        var obj = $(img);
        obj.hover(function () {
            obj.addClass('logo-open').removeClass('logo-close');
        }, function () {
            if (!obj.hasClass('active')) {
                obj.addClass('logo-close').removeClass('logo-open');
            } else {
                obj.removeClass('logo-close').removeClass('logo-open');
            }

        });

        obj.click(function () {
            $.each(imgs, function (index, img) {
                var obj2 = $(img);
                obj2.removeClass('active');
            });
            obj.addClass('active');
            if (obj.data('name') === 'de') {
                $('#iframe').attr('src', urls.de[0]);
                $('.plate').css('display', 'block');

                $.each(ps, function (index, p) {
                    var obj2 = $(p);
                    obj2.removeClass('active');
                });
                ps.eq(0).addClass('active');
            } else {
                $('#iframe').attr('src', urls[obj.data('name')]);
                $('.plate').css('display', 'none');
            }
            update(obj.data('name'));
        });
    });

    var ps = $('.plate>p');
    $.each(ps, function (index, p) {
        var obj = $(p);
        obj.click(function () {
            $.each(ps, function (index, p) {
                var obj2 = $(p);
                obj2.removeClass('active');
            });
            obj.addClass('active');
            $('#iframe').attr('src', urls.de[index]);
        });
    });

    $('#index').click(function () {
        console.log(111);
        window.location.href = 'index.html';
    });

    $(window).resize(function () {
        $('.middle').css('width', document.body.offsetWidth - 230 + 'px');
    });

    $('.middle').css('width', document.body.offsetWidth - 230 + 'px');
});