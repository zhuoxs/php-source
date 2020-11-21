/*www.lanrenzhijia.com   time:2019-06-01 22:11:53*/
var o = getApp();
o.Base({
    data: {
        flag: 0
    },
    onLoad: function(o) {
        this.setData({
            reload: !0
        })
    },
    onShow: function() {
        var o = this;
        this.data.reload && (this.setData({
            reload: !1
        }), this.checkLogin(function(e) {
            o.setData({
                user: e
            }), o.onLoadData(e)
        }, "/base/admin/admin"))
    },
    onLoadData: function(e) {
        var a = this;
        o.api.apiStoreCheckStoreUserPermission({
            user_id: e.id
        }).then(function(o) {
            a.setData({
                shop: o.data,
                imgRoot: o.other.img_root,
                show: !0
            })
        }).
        catch (function(e) {
            o.tips(e.msg)
        })
    },
    onDepositTap: function() {
        o.navTo("/base/deposit/deposit?page=1&id=" + this.data.shop.store.id)
    },
    onScanTap: function() {
        var e = this,
            a = this.data.shop.store.id;
        wx.scanCode({
            success: function(t) {
                var i = t.result,
                    n = /goods-/,
                    r = /coupon-/,
                    s = /spell-/,
                    d = /reserve-/;
                if (/panic-/.test(i)) {
                    var c = i.replace("panic-", "");
                    o.navTo("/plugin/panic/panicorderinfo/panicorderinfo?page=1&oid=" + c + "&sid=" + a)
                } else if (n.test(i)) {
                    var p = i.replace("goods-", "");
                    o.navTo("/base/goodsorderverification/goodsorderverification?order_no=" + p)
                } else if (d.test(i)) {
                    var u = i.replace("reserve-", "");
                    o.navTo("/base/reserveorderverification/reserveorderverification?order_no=" + u)
                } else if (s.test(i)) {
                    var f = i.replace("spell-", "");
                    o.navTo("/plugin/spell/orderinfo/orderinfo?page=1&oid=" + f + "&sid=" + a)
                } else if (r.test(i)) {
                    var h = i.replace("coupon-", ""),
                        l = {
                            order_no: h
                        };
                    o.api.apIcouponCouponDetails(l).then(function(a) {
                        e.data.shop.store.id == a.data.store_id ? e.setData({
                            order_no: h,
                            coupon: !0,
                            order: a.data,
                            imgRoot: a.other.img_root
                        }) : o.tips("您没有核销该优惠券的权限")
                    }).
                    catch (function(e) {
                        e.code, o.tips(e.msg)
                    })
                }
            }
        })
    },
    onConfirmTap: function() {
        var e = this,
            a = {
                type: 3,
                order_no: this.data.order_no,
                num: 1,
                user_id: this.data.user.id
            };
        o.api.apiStoreConfirmAllOrder(a).then(function(a) {
            e.setData({
                coupon: !1
            }), o.tips("核销成功！")
        }).
        catch (function(e) {
            e.code, o.tips(e.msg)
        })
    },
    onRenewTap: function() {
        o.navTo("/base/renew/renew")
    },
    onCloseTap: function() {
        this.setData({
            coupon: !1
        })
    }
});