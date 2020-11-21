/// <reference path="jquery-1.10.1.min.js" />

var Com = {
    switchIndex: function (obj) {
        
        moreElem = $(obj);
        boxElem = moreElem.parents(".box");

        if (boxElem.hasClass("box_up")) {
            boxElem.removeClass("box_up");
            moreElem.html("<span>收起</span>");
        } else {
            boxElem.addClass("box_up");
            moreElem.html("<span>更多</span>");
        }
    }
}

function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}


var TopBox = {

    alert: function (content, succ) {
        if ($("#popTips").length > 0) $("#popTips").remove();

        box = '<div style="top: 20%; display: block;" id="popTips" class="pop_tips">' +
            '<div class="oval"></div>' +
            '<div class="pop_show">' +
                '<h4 id="tipsTitle">温馨提示</h4>' +
                '<div id="tipsMsg" class="pop_info">' + content + '</div>' +
                '<div class="pop_btns">' +
                '   <a id="tipsOK" href="javascript:void(0);">确定</a> <a style="display: none;" id="tipsCancel" href="javascript:void(0);">取消</a>' +
            '</div></div></div>';
        var $top = $(box).appendTo($("body"));
        $top.find("#tipsOK").click(function () { if ($("#popTips").length > 0) $("#popTips").remove(); if (typeof succ === "function") succ(); });
        $top.find("#tipsCancel").click(function () { if ($("#popTips").length > 0) $("#popTips").remove(); });
    }
}

var share = function () {
    if ($("#masklayer").length == 0) {

        var temp = "<div id=\"masklayer\" class=\"masklayer\" ontouchmove=\"return true;\" onclick=\"$(this).toggleClass('on');\">" +
	                "<img src=\"/images/share.png\" alt=\"\" style=\"width:260px;\">" +
                +"</div>";
        $(temp).appendTo($("body"));
    }
    $("#masklayer").toggleClass('on');
}

var mhbshare = function () {
    if ($("#succeed").length == 0) {

        var temp = "<div id=\"succeed\" class=\"succeed\" ontouchmove=\"return true;\" onclick=\"$(this).hide();\">" +
	                "<img src=\"images/penyou.png\">" +
                +"</div>";
        $(temp).appendTo($("body"));
    }
    else {
        $("#succeed").show();
    }
}