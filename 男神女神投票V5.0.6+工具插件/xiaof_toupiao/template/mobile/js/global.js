// Extend the default Number object with a formatCurrency() method:
// usage: someVar.formatCurrency(decimalPlaces, symbol, thousandsSeparator, decimalSeparator)
// defaults: (2, '$', ',', '.')
Number.prototype.formatCurrency = function (places, symbol, thousand, decimal) {
    places = !isNaN(places = Math.abs(places)) ? places : 2;
    symbol = symbol !== undefined ? symbol : '&#165;';
    thousand = thousand || ',';
    decimal = decimal || '.';
    var number = this,
        negative = number < 0 ? '-' : '',
        i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + '',
        j = (j = i.length) > 3 ? j % 3 : 0;
    return symbol + negative + (j ? i.substr(0, j) + thousand : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, '$1' + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : '');
};
//自定义扩展函数
$.extend($, {
    wxMenu: {
        show: function() {
            wx.ready(function(){
                wx.showOptionMenu();
                wx.hideMenuItems({
                    menuList: [
                        'menuItem:copyUrl'
                    ]
                });
                wx.onMenuShareAppMessage(sharedata);
                wx.onMenuShareTimeline(sharedata);
                wx.onMenuShareQQ(sharedata);
                wx.onMenuShareWeibo(sharedata);
            });
        },
        hide: function() {
            wx.ready(function(){
                wx.hideOptionMenu();
            });
        },
        hideTimeline: function() {
            wx.ready(function(){
                wx.hideMenuItems({
                    menuList: ['menuItem:share:timeline']
                });
            });
        }
    },
    autoScrolling: function (wrapper, margin_top) {
        if($('.topline_wrap').length > 0) {
            $(wrapper).find('ul').animate({
                marginTop : margin_top
            }, 500, function(){
                $(this).css({marginTop : '0px'}).find('li').slice(0, 1).appendTo($(this));
            });
        }
    },
});
//默认隐藏微信菜单
$.wxMenu.hide();
