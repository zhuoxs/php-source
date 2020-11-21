var a = getApp(), e = a.requirejs("core");

a.requirejs("jquery"), a.requirejs("foxui");

Page({
    data: {
        goods: {},
        mid: ""
    },
    onLoad: function(i) {
        var t = this;
        e.get("bargain/act", i, function(a) {
            t.setData({
                goods: a.goods,
                mid: a.mid
            });
        }), a.getCache("isIpx") ? t.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : t.setData({
            isIpx: !1,
            iphonexnavbar: ""
        });
    }
});