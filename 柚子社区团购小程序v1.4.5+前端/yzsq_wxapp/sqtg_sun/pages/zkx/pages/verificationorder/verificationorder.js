var app = getApp();

Page({
    data: {
        show: !1,
        padding: !1,
        editFlag: !1,
        onum: 0,
        protect: !0,
        currentTab: 0,
        typeArr: [ {
            id: 0,
            name: "普通",
            action: "loadDate"
        }, {
            id: 1,
            name: "拼团",
            action: "loadPindata"
        } ]
    },
    getPadding: function(t) {
        this.setData({
            padding: t.detail
        });
    },
    onLoad: function(t) {
        var a = t.id, e = t.leader_id;
        this.setData({
            code: a,
            leader_id: e
        }), this.loadDate();
    },
    onShow: function(t) {
        this.setData({
            check: {
                plat: !1,
                checkAll: !1
            }
        }), this.loadDate();
    },
    loadDate: function() {
        var a = this;
        app.ajax({
            url: "Cleader|getUserGoodses",
            data: {
                code: a.data.code,
                leader_id: a.data.leader_id,
                type: a.data.currentTab
            },
            success: function(t) {
                a.setData({
                    cart: t.data,
                    imgroot: t.other.img_root,
                    show: !0
                });
            }
        });
    },
    getSinglePlat: function(t) {
        var a = this, e = a.data.check, c = a.data.cart, i = t.currentTarget.dataset.index, o = 0;
        e.plat = !1, e.checkAll = !1, c[i].status = !c[i].status, c.forEach(function(t, a) {
            t.status && (o += t.num);
        }), a.setData({
            onum: o,
            check: e,
            cart: c
        });
    },
    getAllGoods: function(t) {
        var a = this, e = a.data.check, c = a.data.cart, i = 0;
        e.checkAll = !e.checkAll, e.plat = e.checkAll, c.forEach(function(t, a) {
            t.status = e.checkAll, t.status && (i += t.num);
        }), a.setData({
            onum: i,
            check: e,
            cart: c
        });
    },
    toOrder: function() {
        var a = this, t = a.data.cart, e = [], c = a.data.protect;
        t.forEach(function(t, a) {
            t.status && e.push(t.id);
        }), c && (a.setData({
            protect: !1
        }), app.ajax({
            url: "Cleader|confirmUserGoodses",
            data: {
                ids: e.join(","),
                leader_id: a.data.leader_id
            },
            success: function(t) {
                a.setData({
                    protect: !0
                }), setTimeout(function() {
                    app.tips("确认提货成功");
                }, 1e3), wx.navigateBack({
                    delta: 1
                });
            },
            fail: function(t) {
                a.setData({
                    protect: !0
                }), app.tips(t.msg);
            }
        }));
    },
    toPinorder: function() {
        var a = this, t = a.data.cart, e = [], c = a.data.protect;
        t.forEach(function(t, a) {
            t.status && e.push(t.id);
        }), e = e.join(), c && (a.setData({
            protect: !1
        }), app.ajax({
            url: "Cleader|receivePingoodses",
            data: {
                leader_id: a.data.leader_id,
                pinorder_id: e
            },
            success: function(t) {
                console.log(t), a.setData({
                    protect: !0
                }), setTimeout(function() {
                    app.tips("确认收货成功");
                }, 1e3), wx.navigateBack({
                    delta: 1
                });
            },
            fail: function(t) {
                a.setData({
                    protect: !0
                }), app.tips(t.msg);
            }
        }));
    },
    onLoadData: function(t) {
        t && (this.data.currentTab !== t.currentTarget.dataset.tabid && this.setData({
            currentTab: t.currentTarget.dataset.tabid
        }), this.loadDate(), this.setData({
            onum: 0
        }));
    },
    toOrderSwitch: function() {
        0 == this.data.currentTab ? this.toOrder() : 1 == this.data.currentTab && this.toPinorder();
    }
});