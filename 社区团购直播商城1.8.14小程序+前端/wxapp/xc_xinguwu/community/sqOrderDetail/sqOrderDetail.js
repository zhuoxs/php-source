function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page({
    data: {},
    callPhone: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.list.value.address.phone
        });
    },
    confirmReceipt: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/community",
            showLoading: !0,
            method: "POST",
            data: {
                op: "sureShouh",
                id: s.data.list.id
            },
            success: function(t) {
                var a;
                app.look.ok(t.data.message), s.setData((_defineProperty(a = {}, "list.status", 5), 
                _defineProperty(a, "list.community_status", 1), a));
                var n = getCurrentPages();
                n.forEach(function(t, o) {
                    "xc_xinguwu/pages/sqClaimOrder/sqClaimOrder" == t.route && t.data.list.forEach(function(t, a) {
                        var e;
                        t.id != s.data.list.id || n[o].setData((_defineProperty(e = {}, "list[" + a + "].status", 5), 
                        _defineProperty(e, "list[" + a + "].community_status", 1), _defineProperty(e, "num", n[o].data.num - 1), 
                        e));
                    });
                });
            }
        });
    },
    orderVerify: function() {
        var s = this;
        wx.scanCode({
            onlyFromCamera: !1,
            success: function(t) {
                console.log(t);
                var a = t.result;
                a = a.split("#"), app.util.request({
                    url: "entry/wxapp/community",
                    showLoading: !0,
                    method: "POST",
                    data: {
                        op: "scanHex",
                        hex: a[0],
                        order: a[1]
                    },
                    success: function(t) {
                        app.look.ok(t.data.message), s.setData(_defineProperty({}, "list.community_status", 2));
                        var n = getCurrentPages();
                        n.forEach(function(t, o) {
                            "xc_xinguwu/pages/sqClaimOrder/sqClaimOrder" == t.route && t.data.list.forEach(function(t, a) {
                                var e;
                                t.id != s.data.list.id || n[o].setData((_defineProperty(e = {}, "list[" + a + "].community_status", 2), 
                                _defineProperty(e, "num", n[o].data.num - 1), e));
                            });
                        });
                    },
                    fail: function(t) {
                        app.look.no(t.data.message);
                    }
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    onLoad: function(t) {
        var e = this;
        e.setData({
            options: t
        }), app.util.request({
            url: "entry/wxapp/community",
            showLoading: !1,
            method: "POST",
            data: {
                op: "getOrderDetail",
                id: e.data.options.id
            },
            success: function(t) {
                var a = t.data;
                a.data.list && (console.log(a.data.list), e.setData({
                    list: a.data.list
                }));
            }
        }), console.log(getCurrentPages());
    },
    contactToBuyer: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.list.value.address.phone
        });
    },
    onReady: function() {
        var t = {};
        t.sq_m_get = app.module_url + "resource/wxapp/community/sq-m-get.png", t.sq_call = app.module_url + "resource/wxapp/community/sq-call.png", 
        t.nor_pos = app.module_url + "resource/wxapp/community/nor-pos.png", t.sq_wait_get = app.module_url + "resource/wxapp/community/sq-wait-get.png", 
        t.wait_claim = app.module_url + "resource/wxapp/community/wait-claim.png", t.sq_get_state = app.module_url + "resource/wxapp/community/sq-get-state.png", 
        this.setData({
            images: t
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/community",
            showLoading: !0,
            method: "POST",
            data: {
                op: "getOrderDetail",
                id: e.data.options.id
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var a = t.data;
                a.data.list && (console.log(a.data.list), e.setData({
                    list: a.data.list
                }));
            }
        });
    },
    onReachBottom: function() {}
});