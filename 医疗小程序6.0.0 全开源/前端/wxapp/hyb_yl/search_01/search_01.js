var app = getApp();

Page({
    data: {
        values: "",
        allArr: []
    },
    onLoad: function(n) {
        var o = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: o
        });
        var t = this;
        app.util.request({
            url: "entry/wxapp/Questionimgsingle",
            data: {
                id: ""
            },
            success: function(n) {
                console.log(n);
                var o = n.data.data;
                t.setData({
                    qusetiontype: o
                });
            },
            fail: function(n) {
                console.log(n);
            }
        });
    },
    inputClick: function(n) {
        var o = this, t = n.detail.value, e = o.data.qusetiontype;
        console.log(e);
        for (var a = [], i = 0, l = e.length; i < l; i++) o.find(t, e[i].question) && a.push(e[i]);
        o.setData({
            values: t,
            allArr: a
        });
    },
    find: function(n, o) {
        return -1 !== o.indexOf(n) || (console.log(n), !1);
    },
    delClick: function() {
        console.log(""), this.setData({
            values: ""
        });
    },
    zhuanLiaoClick: function(n) {
        console.log(n);
        var o = n.currentTarget.dataset.money, t = n.currentTarget.dataset.zid, e = n.currentTarget.dataset.qid, a = n.currentTarget.dataset.openid, i = wx.getStorageSync("openid"), l = n.currentTarget.dataset.fromuser;
        0 == o || null == o ? wx.navigateTo({
            url: "/hyb_yl/zhuan_liao/zhuan_liao?zid=" + t + "&user_openid=" + a + "&qid=" + e + "&fromuser=" + l
        }) : app.util.request({
            url: "entry/wxapp/Pay",
            header: {
                "Content-Type": "application/xml"
            },
            method: "GET",
            data: {
                openid: i,
                z_tw_money: o
            },
            success: function(n) {
                console.log(n), wx.requestPayment({
                    timeStamp: n.data.timeStamp,
                    nonceStr: n.data.nonceStr,
                    package: n.data.package,
                    signType: n.data.signType,
                    paySign: n.data.paySign,
                    success: function(n) {
                        wx.navigateTo({
                            url: "/hyb_yl/zhuan_liao/zhuan_liao?zid=" + t + "&user_openid=" + a
                        }), app.util.request({
                            url: "entry/wxapp/Goodsinfo",
                            data: {
                                money: o,
                                qid: e,
                                openid: i,
                                type1: 1
                            },
                            header: {
                                "content-type": "application/json"
                            },
                            success: function(n) {
                                console.log(n);
                            },
                            fail: function(n) {
                                console.log(n);
                            }
                        });
                    },
                    fail: function(n) {
                        app.util.request({
                            url: "entry/wxapp/Goodsinfo",
                            data: {
                                money: o,
                                qid: e,
                                openid: i,
                                type1: 0
                            },
                            header: {
                                "content-type": "application/json"
                            },
                            success: function(n) {
                                console.log(n);
                            },
                            fail: function(n) {
                                console.log(n);
                            }
                        });
                    }
                });
            },
            fail: function(n) {
                console.log(n);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});