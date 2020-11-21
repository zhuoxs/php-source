var e = getApp(), a = e.requirejs("core"), t = e.requirejs("wxParse/wxParse");

Page({
    data: {},
    onLoad: function(e) {
        this.setData({
            id: e.id
        }), this.getDetail();
    },
    getDetail: function() {
        var e = this;
        a.get("sale/coupon/my/getdetail", {
            id: this.data.id
        }, function(a) {
            a.error > 0 ? wx.navigateBack() : (t.wxParse("wxParseData", "html", a.detail.desc, e, "5"), 
            e.setData({
                detail: a.detail,
                show: !0
            }));
        });
    },
    receive: function(e) {
        var a, t = this.data.detail;
        0 != t.coupontype ? (1 == t.coupontype ? a = "/pages/member/recharge/index" : 2 == t.coupontype && (a = "/pages/sale/coupon/my/index"), 
        wx.redirectTo({
            url: a
        })) : wx.switchTab({
            url: "/pages/index/index"
        });
    }
});