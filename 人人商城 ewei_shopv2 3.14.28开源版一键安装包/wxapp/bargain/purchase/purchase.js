var a = getApp(), e = a.requirejs("core");

a.requirejs("jquery"), a.requirejs("foxui");

Page({
    data: {
        goods: {},
        mid: ""
    },
    onLoad: function(i) {
        var r = this;
        e.get("bargain/purchase", i, function(a) {
            r.setData({
                goods: a.goods,
                mid: a.mid
            });
        }), a.getCache("isIpx") ? r.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : r.setData({
            isIpx: !1,
            iphonexnavbar: ""
        });
    }
});