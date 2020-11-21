var a = getApp(), e = a.requirejs("core"), t = a.requirejs("wxParse/wxParse");

Page({
    data: {
        approot: a.globalData.approot
    },
    onLoad: function(a) {
        this.setData({
            id: a.id
        }), this.getDetail();
    },
    getDetail: function(a) {
        var o = this;
        e.get("sale/coupon/my/showcoupon2", {
            id: this.data.id
        }, function(a) {
            a.error > 0 ? wx.redirectTo({
                url: "/pages/sale/coupon/my/index/index"
            }) : (t.wxParse("wxParseData", "html", a.detail.desc, o, "5"), o.setData({
                detail: a.detail,
                goods: a.goods,
                show: !0
            }));
        });
    }
});