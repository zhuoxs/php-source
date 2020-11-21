// Extend the default Number object with a formatCurrency() method:
// usage: someVar.formatCurrency(decimalPlaces, symbol, thousandsSeparator, decimalSeparator)
// defaults: (2, '$', ',', '.')
Number.prototype.formatCurrency = function (places, symbol, thousand, decimal) {
    places = !isNaN(places = Math.abs(places)) ? places : 2;
    symbol = symbol !== undefined ? symbol : '';
    //symbol = symbol !== undefined ? symbol : '&#165;';
    thousand = thousand || ',';
    decimal = decimal || '.';
    var number = this,
        negative = number < 0 ? '-' : '',
        i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + '',
        j = (j = i.length) > 3 ? j % 3 : 0;
    return symbol + negative + (j ? i.substr(0, j) + thousand : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, '$1' + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : '');
};
Number.prototype.isCurrency = function(){
    var reg = /^[0-9]*(\.[0-9]{1,2})?$/;
    return reg.test(this)?true:false;
};
Number.prototype.formatCurrency2 = function (places, symbol, thousand, decimal) {
    places = !isNaN(places = Math.abs(places)) ? places : 2;
    symbol = symbol !== undefined ? symbol : '';
    //symbol = symbol !== undefined ? symbol : '&#165;';
    thousand = thousand || ',';
    decimal = decimal || '.';
    var number = this,
        negative = number < 0 ? '-' : '',
        i = parseInt(number = Math.abs(+number || 0), 10) + '',
        j = (j = i.length) > 3 ? j % 3 : 0;
    return symbol + negative + (j ? i.substr(0, j) + thousand : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, '$1' + thousand) + (places ? decimal + Math.abs(number - i).slice(2) : '');
};
//rgb(0,0,0)
String.prototype.rgb2Hex = function(prefix){
    var str = this.toLowerCase();
    var arr = str.replace('rgb(', '').replace(')', '').split(',');
    var r = arr[0], g = arr[1], b = arr[2];
    return (typeof(prefix)=='undefined'?'#':prefix)+((r << 16) | (g << 8) | b).toString(16);
};

superman.log = function (msg, type) {
    this.debug = window.superman.local_development || window.superman.online_development;
    switch (type) {
        case 'info':
            console.info(msg);break;
        case 'debug':
            if (this.debug) {
                console.debug(msg);
            }
            break;
        case 'warn':
            console.warn(msg);break;
        case 'error':
            console.error(msg);break;
        default:
            console.log(msg);break;
    }
};

$.extend({
    /*toast: function (text = '', icon = '', duration = 2000, extraClass = 'ui-toast') {
        var opt = {
            text: text,
            duration: duration,
        };
        if (icon == 'success') {
            opt.icon = window.sysinfo.siteroot+'addons/superman_creditmall/template/web/'+window.superman.web_template_style+'/images/check.png';
        } else if (icon == 'fail' || icon == 'error') {
            opt.icon = window.sysinfo.siteroot+'addons/superman_creditmall/template/web/'+window.superman.web_template_style+'/images/cross.png';
        }
        setTimeout(function () {
            iosOverlay(opt);
            $('.ui-ios-bg').addClass(extraClass);
            $('.ui-ios-overlay').css({
                'margin-left': -$('.ui-ios-overlay').width()/2,
                'margin-top': -$('.ui-ios-overlay').height()/2,
            });
        }, 10);
    },
    showLoading: function (text = '加载中...') {
        if ($('.ios-overlay-show')[0]) return;
        var opt = {
            text: text,
            spinner: new Spinner().spin(document.createElement('div'))
        };
        iosOverlay(opt);
    },
    hideLoading: function () {
        $('.ios-overlay-show').remove();
    },*/
});

$.fn.rowspan = function(colIdx) {
    return this.each(function(){
        var that, rowspan;
        $('tr', this).each(function(row) {
            $('td:eq('+colIdx+')', this).filter(':visible').each(function(col) {
                if (that != null && $(this).html() == $(that).html()) {
                    rowspan = $(that).attr("rowSpan");
                    if (rowspan == undefined) {
                        $(that).attr("rowSpan",1);
                        rowspan = $(that).attr("rowSpan");
                    }
                    rowspan = Number(rowspan)+1;
                    $(that).attr("rowSpan",rowspan);
                    $(this).hide();
                } else {
                    that = this;
                }
            });
        });
    });
};

$.fn.array2row = function() {
    var arr = this, len = arr.length;
    if (len>=2){
        var len1 = arr[0].length;
        var len2 = arr[1].length;
        var newlen = len1 * len2;
        var temp = new Array(newlen);
        var index = 0;
        for (var i=0; i<len1; i++) {
            for (var j=0; j<len2; j++) {
                temp[index] = arr[0][i] + ',' + arr[1][j];
                index++;
            }
        }
        var newarray = new Array(len-1);
        for (var i=2; i<len; i++) {
            newarray[i-1] = arr[i];
        }
        newarray[0] = temp;
        return $(newarray).array2row();
    } else {
        return arr[0];
    }
};

$(document).ready(function(){
    superman.log('Superman System loading', 'info');
    superman.log(window.superman, 'debug');
    $.extend($, {
        returnTop: function(){
            var obj = $('#return_top');
            if (!obj.length) {
                var html = '<a id="return_top" href="javascript:;"></a>';
                $(document.body).append(html);
                obj = $('#return_top');
            }
            obj.click(function () {
                superman.log('return top click', 'debug');
                $('body,html').animate({
                    scrollTop:0
                },300);
                return false;
            });
            $(window).scroll(function(){
                if ($(this).scrollTop() > 10) {
                    obj.show().animate({
                        bottom: 70
                    }, 50);
                } else if ($(this).scrollTop() == 0) {
                    obj.stop().animate({
                        bottom: -65
                    }, 200);
                }
            });
        }
    });
    $.returnTop();
});
require(['jquery', 'bootstrap'],function($){
    (function () {
        $('[data-toggle="tooltip"]').tooltip();
    })();
});
function base64_encode(str) {
    var c1, c2, c3;
    var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    var i = 0, len = str.length, string = '';
    while (i < len) {
        c1 = str.charCodeAt(i++) & 0xff;
        if (i == len) {
            string += base64EncodeChars.charAt(c1 >> 2);
            string += base64EncodeChars.charAt((c1 & 0x3) << 4);
            string += "==";
            break;
        }
        c2 = str.charCodeAt(i++);
        if (i == len) {
            string += base64EncodeChars.charAt(c1 >> 2);
            string += base64EncodeChars.charAt(((c1 & 0x3) << 4)
                | ((c2 & 0xF0) >> 4));
            string += base64EncodeChars.charAt((c2 & 0xF) << 2);
            string += "=";
            break;
        }
        c3 = str.charCodeAt(i++);
        string += base64EncodeChars.charAt(c1 >> 2);
        string += base64EncodeChars.charAt(((c1 & 0x3) << 4)
            | ((c2 & 0xF0) >> 4));
        string += base64EncodeChars.charAt(((c2 & 0xF) << 2)
            | ((c3 & 0xC0) >> 6));
        string += base64EncodeChars.charAt(c3 & 0x3F)
    }
    return string
}
function base64_decode(str) {
    var c1, c2, c3, c4;
    var base64DecodeChars = new Array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62,
        -1, -1, -1, 63, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1,
        -1, -1, -1, -1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,
        15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1, -1,
        26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42,
        43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1);
    var i = 0, len = str.length, string = '';
    while (i < len) {
        do {
            c1 = base64DecodeChars[str.charCodeAt(i++) & 0xff]
        } while (i < len && c1 == -1);
        if (c1 == -1)
            break;

        do {
            c2 = base64DecodeChars[str.charCodeAt(i++) & 0xff]
        } while (i < len && c2 == -1);

        if (c2 == -1)
            break;
        string += String.fromCharCode((c1 << 2) | ((c2 & 0x30) >> 4));
        do {
            c3 = str.charCodeAt(i++) & 0xff;
            if (c3 == 61)
                return string;
            c3 = base64DecodeChars[c3]
        } while (i < len && c3 == -1);
        if (c3 == -1)
            break;
        string += String.fromCharCode(((c2 & 0XF) << 4) | ((c3 & 0x3C) >> 2));
        do {
            c4 = str.charCodeAt(i++) & 0xff;
            if (c4 == 61)
                return string;
            c4 = base64DecodeChars[c4]
        } while (i < len && c4 == -1);
        if (c4 == -1)
            break;
        string += String.fromCharCode(((c3 & 0x03) << 6) | c4)
    }
    return string;
}