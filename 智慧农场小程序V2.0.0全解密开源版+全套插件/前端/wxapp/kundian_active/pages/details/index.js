var t = new getApp(), a = t.siteInfo.uniacid, e = require("../../../wxParse/wxParse.js"), i = t.util.url("entry/wxapp/class") + "m=kundian_farm_plugin_active";

Page({
    data: {
        sign: [],
        activeList: [],
        isShow: !1,
        selectNum: 1,
        total: 0,
        active: [],
        farmSetData: [],
        sign_order: [],
        isIphoneX: t.globalData.isIphoneX
    },
    onLoad: function(n) {
        var s = this, c = n.activeid, o = wx.getStorageSync("kundian_farm_uid"), r = wx.getStorageSync("kundian_farm_setData");
        wx.request({
            url: i,
            data: {
                action: "active",
                op: "getActiveDetail",
                uniacid: a,
                active_id: c,
                uid: o
            },
            success: function(t) {
                var a = t.data, i = a.active, n = a.spec, c = a.sign_user, o = a.sign_count, u = a.sign_order;
                s.setData({
                    active: i,
                    spec: n,
                    sign: c,
                    sign_count: o,
                    farmSetData: r,
                    sign_order: u
                }), "" != t.data.active.detail && e.wxParse("article", "html", t.data.active.detail, s, 5);
            }
        }), t.util.setNavColor(a);
    },
    call: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.active.phone.toString()
        });
    },
    gotomap: function() {
        var t = this.data.active;
        wx.openLocation({
            latitude: parseFloat(t.latitude),
            longitude: parseFloat(t.longitude),
            address: t.address,
            scale: 28
        });
    },
    preventDefault: function() {},
    selectItem: function(t) {
        var a = [ t.currentTarget.dataset.id, this.data.spec ], e = a[0], i = a[1];
        i.map(function(t) {
            t.select = !1, t.id == e && (t.select = !0);
        }), this.setData({
            spec: i
        }), this.sumPrice();
    },
    reduce: function() {
        var t = this.data.selectNum;
        t <= 1 || (t -= 1, this.setData({
            selectNum: t
        }), this.sumPrice());
    },
    add: function() {
        var t = this.data.selectNum;
        t += 1, this.setData({
            selectNum: t
        }), this.sumPrice();
    },
    sumPrice: function() {
        var t = [ this.data.selectNum, this.data.spec, 0 ], a = t[0], e = t[1], i = t[2];
        e.map(function(t) {
            t.select && (i = t.price * a);
        }), this.setData({
            total: i.toFixed(2)
        });
    },
    close: function() {
        this.setData({
            isShow: !1
        });
    },
    signUp: function() {
        this.setData({
            isShow: !0
        });
    },
    toPay: function(t) {
        var a = this;
        if (wx.getStorageSync("kundian_farm_uid")) {
            var e = a.data, i = e.selectNum, n = e.active, s = e.spec;
            if (n.count > 0 && n.count - n.person_count < i) return wx.showModal({
                title: "提示",
                content: "当前余票不足！剩余" + (n.count - n.person_count) + "张"
            }), !1;
            var c = [];
            if (s.map(function(t) {
                t.select && (c = t);
            }), 0 == c.length) wx.showToast({
                title: "请选择规格！"
            }); else {
                var o = a.data, r = o.active, u = o.total;
                wx.navigateTo({
                    url: "../signform/index?activeid=" + r.id + "&total=" + u + "&selectNum=" + i + "&spec=" + JSON.stringify(c)
                });
            }
        } else wx.navigateTo({
            url: "/kundian_farm/pages/login/index"
        });
    },
    goHome: function() {
        wx.reLaunch({
            url: "/kundian_farm/pages/HomePage/index/index?is_tarbar=true"
        });
    },
    intoSignInfo: function(t) {
        var a = t.currentTarget.dataset.activeid;
        wx.navigateTo({
            url: "../signInfo/index?active_id=" + a
        });
    },
    openQrcode: function(t) {
        var a = this.data.sign_order;
        wx.navigateTo({
            url: "../ticket/index?order_id=" + a.id
        });
    },
    onShareAppMessage: function(t) {
        var a = this.data.active;
        return {
            path: "kundian_active/pages/details/index?activeid=" + a.id,
            success: function(t) {},
            title: a.title
        };
    }
});