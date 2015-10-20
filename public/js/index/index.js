$(document).ready(function () {
    Qfast.add('widgets', {path: "/js/index/terminator2.2.min.js", type: "js", requires: ['fx']});
    Qfast(false, 'widgets', function () {
        K.tabs({
            id: 'fsD0',
            conId: "D1pic0",
            tabId: "D1fBt0",
            tabTn: "a",
            conCn: '.fcon',
            auto: 1,
            effect: 'scrollLeft',
            eType: 'click',
            interval: 3000
        })
    });
    Qfast(false, 'widgets', function () {
        K.tabs({
            id: 'fsD1',
            conId: "D1pic1",
            tabId: "D1fBt1",
            tabTn: "a",
            conCn: '.fcon',
            auto: 1,
            effect: 'scrollLeft',
            eType: 'click',
            interval: 3000
        })
    });
    Qfast(false, 'widgets', function () {
        K.tabs({
            id: 'fsD2',
            conId: "D1pic2",
            tabId: "D1fBt2",
            tabTn: "a",
            conCn: '.fcon',
            auto: 1,
            effect: 'scrollLeft',
            eType: 'click',
            interval: 3000
        })
    });
    Qfast(false, 'widgets', function () {
        K.tabs({
            id: 'fsD3',
            conId: "D1pic3",
            tabId: "D1fBt3",
            tabTn: "a",
            conCn: '.fcon',
            auto: 1,
            effect: 'scrollLeft',
            eType: 'click',
            interval: 3000
        })
    });
    Qfast(false, 'widgets', function () {
        K.tabs({
            id: 'fsD4',
            conId: "D1pic4",
            tabId: "D1fBt4",
            tabTn: "a",
            conCn: '.fcon',
            auto: 1,
            effect: 'scrollLeft',
            eType: 'click',
            interval: 3000
        })
    });
    Qfast(false, 'widgets', function () {
        K.tabs({
            id: 'fsD5',
            conId: "D1pic5",
            tabId: "D1fBt5",
            tabTn: "a",
            conCn: '.fcon',
            auto: 1,
            effect: 'scrollLeft',
            eType: 'click',
            interval: 3000
        })
    });
    Qfast(false, 'widgets', function () {
        K.tabs({
            id: 'fsD6',
            conId: "D1pic6",
            tabId: "D1fBt6",
            tabTn: "a",
            conCn: '.fcon',
            auto: 1,
            effect: 'scrollLeft',
            eType: 'click',
            interval: 3000
        })
    });

    $.each($('.fucked>.pin-head>ul>li'), function (index, item) {
        $(item).click(function () {
            $('.fucked>.pin-head>ul>li').removeClass('active');
            $(this).addClass('active');
            $('.fucked-img').removeClass('active');
            $('.fucked-img').eq(index).addClass('active');
        });
    });

    $.each($('.pin-head-1>ul>li'), function (index, item) {
        $(item).click(function () {
            $('.pin-head-1>ul>li').removeClass('active');
            $(this).addClass('active');
            $('.fuck1').removeClass('active');
            $('.fuck1').eq(index).addClass('active');
        });
    });

    $.each($('.pin-head-2>ul>li'), function (index, item) {
        $(item).click(function () {
            $('.pin-head-2>ul>li').removeClass('active');
            $(this).addClass('active');
            $('.fuck2').removeClass('active');
            $('.fuck2').eq(index).addClass('active');
        });
    });
});