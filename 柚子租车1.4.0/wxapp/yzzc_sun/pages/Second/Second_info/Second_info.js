var _extends = Object.assign || function(e) {
    for (var n = 1; n < arguments.length; n++) {
        var t = arguments[n];
        for (var o in t) Object.prototype.hasOwnProperty.call(t, o) && (e[o] = t[o]);
    }
    return e;
}, _reload = require("../../../common/js/reload.js"), _api = require("../../../common/js/api.js"), app = getApp(), WxParse = require("../../../../we7/js/wxParse.js");

Page(_extends({}, _reload.reload, {
    data: {
        indicatorDots: !1,
        autoplay: !0,
        interval: 3e3,
        duration: 1e3
    },
    onLoad: function(e) {
        this.setData({
            id: e.id
        }), this.onloadData();
    },
    onShow: function() {},
    onloadData: function() {
        var t = this;
        this.getUrl().then(function(e) {
            var n = {
                id: t.data.id
            };
            return (0, _api.Userdcar)(n);
        }).then(function(e) {
            console.log(e), t.setData({
                info: e,
                content: unescape(e.content)
            }), WxParse.wxParse("content", "html", e.content, t, 10);
        });
    },
    onShareAppMessage: function() {},
    calling: function() {
        var n = this;
        wx.showModal({
            title: "提示",
            content: "预约看车",
            success: function(e) {
                e.confirm && wx.makePhoneCall({
                    phoneNumber: n.data.info.phone
                });
            }
        });
    },
    toHome: function() {
        wx.navigateTo({
            url: "../../home/home"
        });
    }
}));