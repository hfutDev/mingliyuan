   //实例化编辑器
    UE.getEditor('editor');

    function createEditor(){
        enableBtn();
        UE.getEditor('editor')
    }
    function getAllHtml() {
        alert( UE.getEditor('editor').getAllHtml() )
    }
    function getContent() {
        var arr = [];
        arr.push( "使用editor.getContent()方法可以获得编辑器的内容" );
        arr.push( "内容为：" );
        arr.push(  UE.getEditor('editor').getContent() );
        alert( arr.join( "\n" ) );
    }
    function getPlainTxt() {
        var arr = [];
        arr.push( "使用editor.getPlainTxt()方法可以获得编辑器的带格式的纯文本内容" );
        arr.push( "内容为：" );
        arr.push(  UE.getEditor('editor').getPlainTxt() );
        alert( arr.join( '\n' ) )
    }
    function setContent() {
        var arr = [];
        arr.push( "使用editor.setContent('欢迎使用ueditor')方法可以设置编辑器的内容" );
        UE.getEditor('editor').setContent( '欢迎使用ueditor' );
        alert( arr.join( "\n" ) );
    }
    function setDisabled() {
        UE.getEditor('editor').setDisabled( 'fullscreen' );
        disableBtn( "enable" );
    }

    function setEnabled() {
        UE.getEditor('editor').setEnabled();
        enableBtn();
    }

    function getText() {
        //当你点击按钮时编辑区域已经失去了焦点，如果直接用getText将不会得到内容，所以要在选回来，然后取得内容
        var range =  UE.getEditor('editor').selection.getRange();
        range.select();
        var txt =  UE.getEditor('editor').selection.getText();
        alert( txt )
    }

    function getContentTxt() {
        var arr = [];
        arr.push( "使用editor.getContentTxt()方法可以获得编辑器的纯文本内容" );
        arr.push( "编辑器的纯文本内容为：" );
        arr.push(  UE.getEditor('editor').getContentTxt() );
        alert( arr.join( "\n" ) );
    }
    function hasContent() {
        var arr = [];
        arr.push( "使用editor.hasContents()方法判断编辑器里是否有内容" );
        arr.push( "判断结果为：" );
        arr.push(  UE.getEditor('editor').hasContents() );
        alert( arr.join( "\n" ) );
    }
    function setFocus() {
        UE.getEditor('editor').focus();
    }
    function deleteEditor() {
        disableBtn();
        UE.getEditor('editor').destroy();
    }
    function disableBtn( str ) {
        var div = document.getElementById( 'btns' );
        var btns = domUtils.getElementsByTagName( div, "input" );
        for ( var i = 0, btn; btn = btns[i++]; ) {
            if ( btn.id == str ) {
                domUtils.removeAttributes( btn, ["disabled"] );
            } else {
                btn.setAttribute( "disabled", "true" );
            }
        }
    }
    function enableBtn() {
        var div = document.getElementById( 'btns' );
        var btns = domUtils.getElementsByTagName( div, "input" );
        for ( var i = 0, btn; btn = btns[i++]; ) {
            domUtils.removeAttributes( btn, ["disabled"] );
        }
    }
    $(".btn").eq(0).click(function(){
        if(<?php if ($this->session->type == 1) echo "($(\".dept\").val() ==-1) || ";?>($(".column").val() ==0) || ($(".text-input").eq(0).val() == "") || ($(".text-input").eq(1).val() == "") || ($("iframe").eq(0).contents().find("body").text() == "")){
            <?php if ($this->session->type == 1) echo "if ($(\".dept\").val() ==-1) {alert(\"亲，请选择学院\"); return false;}";?>
            if ($(".column").val() ==0) {alert("亲，请选择栏目"); return false;}
            if ($(".text-input").eq(0).val() == "") {alert("亲，请填写标题"); return false;}
            if ($(".text-input").eq(1).val() == "") {alert("亲，请填写作者"); return false;}
            if ($("iframe").eq(0).contents().find("body").text() == "") {alert("亲，请填写文章内容"); return false;}
        }
        else if(($(".text-input").eq(0).val().length) > 40 ){
            alert("亲，文章标题不能多于40字符");
            return false;
        }
        else if(($(".text-input").eq(1).val().length) > 20 ){
            alert("亲，文章来源不能多于20字符");
            return false;
        }
        else 
        {
            return true;
        }   
    });
    
    $(".articletitle").keyup(function(){
        var checkit = $(".articletitle").val();
        $.ajax({
            type:"POST",
            url:'/admin/checkarticletitle',
            data:"checkit="+checkit,
            success:function(data){
                if (data==0) {
                    $("#res").html("&nbsp&nbsp*已经存在相同标题！");
                };
            }
        });
    });

    jQuery(function($){
        $.datepicker.regional['zh-cn'] = {
            closeText: '关闭',
            prevText: '&#x3C;上月',
            nextText: '下月&#x3E;',
            currentText: '今天',
            monthNames: ['一月','二月','三月','四月','五月','六月',
            '七月','八月','九月','十月','十一月','十二月'],
            monthNamesShort: ['一月','二月','三月','四月','五月','六月',
            '七月','八月','九月','十月','十一月','十二月'],
            dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
            dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
            dayNamesMin: ['日','一','二','三','四','五','六'],
            weekHeader: '周',
            dateFormat: 'yy-mm-dd',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: true,
            yearSuffix: '年'};
        $.datepicker.setDefaults($.datepicker.regional['zh-cn']);
    });

    $("#timepicker").datetimepicker({
        timeOnlyTitle: '选择时间',
        timeText: '　时间',
        hourText: '　时',
        minuteText: '　分',
        secondText: '　秒',
        currentText: '现在',
        closeText: '完成',
        dateFormat: "yy-mm-dd",
        timeFormat: 'HH:mm:ss',
        stepHour: 1,
        stepMinute: 1,
        stepSecond: 1,
    });