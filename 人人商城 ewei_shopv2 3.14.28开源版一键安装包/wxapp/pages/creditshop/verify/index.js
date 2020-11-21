var e = getApp(), t = e.requirejs("core");

e.requirejs("icons"), e.requirejs("foxui"), e.requirejs("wxParse/wxParse"), e.requirejs("jquery");

Page({
    data: {
        eno: 0,
        qrcode: "",
        logid: 0,
        options: []
    },
    onLoad: function(e) {
        var t = this;
        e = e || {}, wx.getSystemInfo({
            success: function(e) {
                t.setData({
                    windowWidth: e.windowWidth,
                    windowHeight: e.windowHeight
                });
            }
        }), t.setData({
            options: e,
            logid: e.id
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this;
        e.getCache("isIpx") ? t.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : t.setData({
            isIpx: !1,
            iphonexnavbar: ""
        }), t.getDetail(), wx.getSetting({
            success: function(e) {
                var i = e.authSetting["scope.userInfo"];
                t.setData({
                    limits: i
                });
            }
        });
    },
    getDetail: function(e) {
        var i = this;
        t.get("creditshop/exchange/qrcode", {
            id: i.data.logid
        }, function(e) {
            i.setData({
                eno: e.eno,
                qrcode: e.qrcode
            });
        });
    }
});