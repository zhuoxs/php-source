var e = getApp(), t = e.requirejs("core"), a = e.requirejs("foxui"), i = e.requirejs("wxParse/wxParse");

Page({
    data: {
        id: 0,
        detail: {}
    },
    onLoad: function(e) {
        this.setData({
            id: e.id
        }), this.getDetail();
    },
    getDetail: function() {
        var e = this;
        t.get("sale/coupon/getdetail", {
            id: this.data.id
        }, function(t) {
            t.error > 0 ? wx.navigateBack() : (i.wxParse("wxParseData", "html", t.detail.desc, e, "5"), 
            e.setData({
                detail: t.detail,
                show: !0
            }));
        });
    },
    receive: function(e) {
        var i = this.data.detail, s = this;
        if (this.data.buying) a.toast(s, "正在执行请稍后"); else if (1 == i.canget) {
            var o = "确认使用";
            i.money > 0 && (o += i.money + "元", i.credit > 0 && (o += "+")), i.credit > 0 && (o += i.credit + "积分"), 
            o += i.gettypestr + "吗？", t.confirm(o, function() {
                s.setData({
                    buying: !0
                }), t.post("sale/coupon/pay", {
                    id: s.data.id
                }, function(e) {
                    if (e.error > 0) return a.toast(s, e.message), void s.setData({
                        buying: !1
                    });
                    s.setData({
                        logid: e.logid
                    }), e.wechat && e.wechat.success ? t.pay(e.wechat.payinfo, function(e) {
                        "requestPayment:ok" == e.errMsg && s.payResult();
                    }) : s.payResult(), s.setData({
                        buying: !1
                    });
                });
            });
        } else a.toast(s, i.getstr);
    },
    payResult: function() {
        var e = this;
        t.get("sale/coupon/payresult", {
            logid: this.data.logid
        }, function(i) {
            if (i.error > 0) a.toast(e, i.message); else if (0 != i.coupontype) {
                var s = "/pages/sale/coupon/my/index/index";
                1 == i.coupontype && (s = "/pages/member/recharge/index"), t.confirm(i.confirm_text, function() {
                    wx.redirectTo({
                        url: s
                    });
                }, function() {
                    wx.redirectTo({
                        url: "/pages/sale/coupon/my/index/index"
                    });
                });
            } else wx.redirectTo({
                url: "/pages/sale/coupon/my/showcoupons2/index?id=" + i.dataid
            });
        });
    }
});