var app = getApp(), that = void 0;

Page({
    data: {
        curIndex: 0,
        curorder: [],
        orderlist: [],
        overOrder: [],
        showpaybox: !1,
        rstatus: "",
        the_id: 0,
        payprice: 0,
        paychoose: [ {
            name: "微信支付",
            value: "1",
            icon: "/style/images/wx.png"
        }, {
            name: "余额支付",
            value: "2",
            icon: "/style/images/local.png"
        } ],
        tab: 0,
        pages: [ 1, 1, 1 ],
        isclickpay: !1
    },
    onLoad: function(t) {
        var a;
        a = t.tab ? t.tab : 0, this.setData({
            tab: a
        });
    },
    onReady: function() {
        var a = this, t = wx.getStorageSync("openid"), e = wx.getStorageSync("build_id"), r = a.data.tab, s = {
            uid: t,
            build_id: e
        };
        1 == r ? (s.isdefault = 0, s.status = 20) : 0 == r ? (s.isdefault = 0, s.status = 10) : 2 == r && (s.isdefault = 1), 
        app.util.request({
            url: "entry/wxapp/GetMyOrder",
            cachetime: "0",
            data: s,
            success: function(t) {
                console.log(t), 2 != t.data ? a.setData({
                    orderlist: t.data,
                    curIndex: r
                }) : a.setData({
                    orderlist: [],
                    curIndex: r
                });
            }
        });
    },
    orderTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index), e = this, r = {
            uid: wx.getStorageSync("openid"),
            build_id: wx.getStorageSync("build_id")
        };
        1 == a ? (r.isdefault = 0, r.status = 20) : 0 == a ? (r.isdefault = 0, r.status = 10) : 2 == a && (r.isdefault = 1), 
        e.setData({
            orderlist: []
        }), app.util.request({
            url: "entry/wxapp/GetMyOrder",
            cachetime: "0",
            data: r,
            success: function(t) {
                console.log(t), 2 != t.data ? e.setData({
                    orderlist: t.data,
                    pages: [ 1, 1, 1 ],
                    curIndex: a
                }) : e.setData({
                    orderlist: [],
                    pages: [ 1, 1, 1 ],
                    curIndex: a
                });
            }
        });
    },
    onShow: function() {},
    comfOrder: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.index, a = t.currentTarget.dataset.id, r = this, s = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/comfOrder",
            cachetime: "0",
            data: {
                openid: s,
                id: a
            },
            success: function(t) {
                console.log(t), 1 == t.data && wx.showToast({
                    title: "确认成功！"
                });
                var a = r.data.orderlist;
                a[e].state = 60, a[e].isdefault = 1, r.setData({
                    orderlist: a
                });
            }
        });
    },
    showpay: function(t) {
        var a = t.currentTarget.dataset.payprice, e = t.currentTarget.dataset.id, r = t.currentTarget.dataset.index;
        this.setData({
            payprice: a,
            the_id: e,
            showpaybox: !0,
            whichone: r
        });
    },
    ClosePaybox: function() {
        this.setData({
            showpaybox: !1
        });
    },
    radioChange: function(t) {
        var a = t.detail.value;
        console.log(a), this.setData({
            rstatus: a
        });
    },
    submittopay: function() {
        var t = this, a = t.data.payprice, e = t.data.rstatus, r = t.data.the_id, s = t.data.orderlist, o = t.data.whichone, i = wx.getStorageSync("openid");
        if (s[o].state = 20, "" == e) return wx.showModal({
            title: "提示",
            content: "请选择支付方式",
            showCancel: !1
        }), !1;
        if (t.data.isclickpay) return console.log("重复点击"), !0;
        t.setData({
            isclickpay: !0
        });
        var d = {
            orderarr: {
                price: a,
                order_id: r,
                openid: i,
                ordertype: 1
            },
            payType: e,
            attrType: 1,
            orderType: 1,
            resulttype: 0,
            setdata: {
                orderlist: s,
                showpaybox: !1
            },
            PayredirectTourl: ""
        };
        app.func.orderarr(app, t, d);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, r = e.data.curIndex, t = wx.getStorageSync("openid"), a = wx.getStorageSync("build_id"), s = e.data.pages, o = s[r], i = {
            uid: t,
            build_id: a,
            page: o
        };
        1 == r ? (i.isdefault = 0, i.status = 20) : 0 == r ? (i.isdefault = 0, i.status = 10) : 2 == r && (i.isdefault = 1);
        var d = e.data.orderlist;
        app.util.request({
            url: "entry/wxapp/GetMyOrder",
            cachetime: "0",
            data: i,
            success: function(t) {
                if (console.log(t), 2 != t.data) {
                    var a = t.data;
                    d = d.concat(a), s[r] = o + 1, e.setData({
                        orderlist: d,
                        pages: s
                    });
                } else wx.showToast({
                    title: "没有更多内容了"
                });
            }
        });
    },
    onShareAppMessage: function() {},
    cancel: function(t) {
        var a = this, e = a.data.curorder, r = t.currentTarget.dataset.index, s = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "确定取消订单吗",
            success: function(t) {
                t.confirm ? (e.splice(r, 1), a.setData({
                    curorder: e
                }), app.util.request({
                    url: "entry/wxapp/cancelOrder",
                    cachetime: "0",
                    data: {
                        id: s
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "删除成功！"
                        }), a.onShow();
                    }
                })) : t.cancel && console.log("用户点击取消");
            }
        });
    }
});