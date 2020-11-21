var app = getApp();

Page({
    data: {
        a: !1,
        edit: !1,
        editCon: "编辑",
        none: []
    },
    onLoad: function(a) {
        var t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
    },
    checkboxChange: function(a) {
        console.log("checkbox发生change事件，携带value值为：", a.detail.value);
        if (0 == a.detail.value.length) var t = !1; else t = !0;
        this.setData({
            a: t
        });
    },
    del: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.historyArr;
        0 == e[t].checked ? e[t].checked = 1 : e[t].checked = 0, console.log(e), this.setData({
            historyArr: e
        });
    },
    subClick: function(a) {
        var t = this.data.historyArr;
        console.log(t);
        var e = a.detail.value.checkBox;
        app.util.request({
            url: "entry/wxapp/Deletinfo",
            data: {
                gid: e
            },
            success: function(a) {
                a.data.data;
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        });
        for (var o = 0, n = t.length; o < n; o++) console.log(t[o]), 1 == t[o].checked && (t.splice(o, 1), 
        o--, n--);
        this.setData({
            historyArr: t
        });
    },
    editClick: function() {
        var a = this;
        if (a.data.edit) ; else var t = !1;
        a.setData({
            edit: !a.data.edit,
            a: t
        });
    },
    onReady: function() {
        this.getHistoryArr();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getHistoryArr: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/HistoryArr",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                console.log(a);
                for (var t = 0; t < a.data.data.length; t++) a.data.data[t].checked = 0;
                e.setData({
                    historyArr: a.data.data
                });
            }
        });
    },
    pay: function(a) {
        var i = a.currentTarget.dataset.money, r = wx.getStorageSync("openid"), c = a.currentTarget.dataset.type, t = a.currentTarget.dataset.qid, s = a.currentTarget.dataset.data;
        app.util.request({
            url: "entry/wxapp/Inforquestion",
            data: {
                qid: t
            },
            success: function(a) {
                console.log(a);
                var t = a.data.data.p_id, e = a.data.data.user_openid, o = a.data.data.fromuser, n = a.data.data.qid;
                1 == c ? wx.navigateTo({
                    url: "/hyb_yl/zhuan_liao/zhuan_liao?zid=" + t + "&user_openid=" + e + "&q_category=" + s + "&qid=" + n + "&fromuser=" + o
                }) : app.util.request({
                    url: "entry/wxapp/Pay",
                    header: {
                        "Content-Type": "application/xml"
                    },
                    method: "GET",
                    data: {
                        openid: r,
                        z_tw_money: i
                    },
                    success: function(a) {
                        console.log(a), wx.requestPayment({
                            timeStamp: a.data.timeStamp,
                            nonceStr: a.data.nonceStr,
                            package: a.data.package,
                            signType: a.data.signType,
                            paySign: a.data.paySign,
                            success: function(a) {
                                app.util.request({
                                    url: "entry/wxapp/Goodsinfo",
                                    data: {
                                        money: i,
                                        qid: n,
                                        openid: r,
                                        type1: 1
                                    },
                                    header: {
                                        "content-type": "application/json"
                                    },
                                    success: function(a) {
                                        console.log(a), wx.navigateTo({
                                            url: "/hyb_yl/zhuan_liao/zhuan_liao?zid=" + t + "&user_openid=" + e + "&q_category=" + s + "&qid=" + n + "&fromuser=" + o
                                        });
                                    },
                                    fail: function(a) {
                                        console.log(a);
                                    }
                                });
                            }
                        });
                    },
                    fail: function(a) {
                        console.log(a);
                    }
                });
            }
        });
    }
});