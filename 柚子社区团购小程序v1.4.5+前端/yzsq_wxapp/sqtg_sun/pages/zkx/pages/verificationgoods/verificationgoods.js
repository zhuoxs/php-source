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
            name: "普通"
        }, {
            id: 1,
            name: "拼团"
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
            url: "Cleader|getSendingUserGoodses",
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
        var a = this, e = a.data.check, o = a.data.cart, c = t.currentTarget.dataset.index, s = 0;
        e.plat = !1, e.checkAll = !1, o[c].status = !o[c].status, o.forEach(function(t, a) {
            t.status && (s += t.num);
        }), a.setData({
            onum: s,
            check: e,
            cart: o
        });
    },
    getAllGoods: function(t) {
        var a = this, e = a.data.check, o = a.data.cart, c = 0;
        e.checkAll = !e.checkAll, e.plat = e.checkAll, o.forEach(function(t, a) {
            t.status = e.checkAll, t.status && (c += t.num);
        }), a.setData({
            onum: c,
            check: e,
            cart: o
        });
    },
    toOrder: function() {
        var a = this, t = a.data.cart, e = [], o = a.data.protect;
        t.forEach(function(t, a) {
            t.status && e.push({
                goods_id: t.goods_id,
                attr_ids: t.attr_ids,
                attr_name: t.attr_name,
                num: t.num
            });
        }), e = JSON.stringify(e), o && (a.setData({
            protect: !1
        }), app.ajax({
            url: "Cleader|receiveGoodses",
            data: {
                leader_id: a.data.leader_id,
                goodses: e
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
    toPinorder: function() {
        var a = this, t = a.data.cart, e = [], o = a.data.protect;
        t.forEach(function(t, a) {
            t.status && e.push(t.id);
        }), e = e.join(), o && (a.setData({
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
    toOrderSwitch: function() {
        0 == this.data.currentTab ? this.toOrder() : 1 == this.data.currentTab && (console.log("拼团商品团长收货"), 
        this.toPinorder());
    },
    onLoadData: function(t) {
        t && this.data.currentTab !== t.currentTarget.dataset.tabid && this.setData({
            currentTab: t.currentTarget.dataset.tabid
        }), this.setData({
            onum: 0
        }), this.loadDate();
    }
});