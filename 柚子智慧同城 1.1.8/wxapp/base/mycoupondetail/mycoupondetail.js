/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var a = getApp(),
    t = require("../../zhy/resource/js/index.js"),
    o = require("../../zhy/template/wxParse/wxParse.js");
a.Base({
    data: {},
    onLoad: function(a) {
        var t = this;
        this.checkLogin(function(o) {
            t.setData({
                id: a.id
            }), t.onLoadData(o)
        }, "/base/mycoupondetail/mycoupondetail")
    },
    onLoadData: function(e) {
        var n = this,
            i = this,
            c = {
                id: i.data.id
            };
        a.api.apIcouponOrderinfo(c).then(function(a) {
            var e = a.data.couponinfo.instructions;
            o.wxParse("detail", "html", e, n, 0), t.qrcode("qrcode", "coupon-" + a.data.order_no, 276, 276), i.setData({
                mydetail: a.data,
                show: !0,
                img_root: a.other.img_root
            })
        }).
        catch (function(t) {
            t.code, a.tips(t.msg)
        })
    },
    onGetcouponTap: function() {
        var t = this,
            o = t.data.detail.gettype,
            e = {
                user_id: t.data.user_id,
                cid: t.data.detail.id,
                help_uid: t.data.h_uid
            };
        t.data.ajax || (t.setData({
            ajax: !0
        }), a.api.apIcouponGetCoupon(e).then(function(e) {
            t.setData({
                ajax: !1
            }), 1 == o ? e.data && wx.requestPayment({
                appId: e.data.appId,
                nonceStr: e.data.nonceStr,
                package: e.data.package,
                paySign: e.data.paySign,
                prepay_id: e.data.prepay_id,
                signType: e.data.signType,
                timeStamp: e.data.timeStamp,
                success: function(o) {
                    console.log("success"), a.alert("去首页逛逛", function() {
                        a.lunchTo("/pages/home/home")
                    }, 0, "购买优惠券成功"), t.onLoadData()
                },
                fail: function(a) {
                    console.log(a)
                }
            }) : 2 == o ? a.alert("去首页逛逛", function() {
                a.lunchTo("/pages/home/home")
            }, 0, "帮领取优惠券成功") : 3 == o && a.alert("去首页逛逛", function() {
                a.lunchTo("/pages/home/home")
            }, 0, "优惠券领取成功")
        }).
        catch (function(o) {
            t.setData({
                ajax: !1
            }), o.code, a.tips(o.msg)
        }))
    },
    onTelTap: function(a) {
        wx.makePhoneCall({
            phoneNumber: a.currentTarget.dataset.tel
        })
    },
    onShareAppMessage: function(a) {
        var t = this;
        return {
            title: t.data.detail.couponinfo.title,
            path: "/base/coupondetail/coupondetail?id=" + t.data.id
        }
    },
    onTohomeTap: function() {
        a.lunchTo("/pages/home/home")
    },
    onTocouponlistTap: function() {
        a.reTo("/base/coupons/coupons")
    }
});