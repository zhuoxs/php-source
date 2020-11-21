var app = getApp();

Page({
    data: {
        nav: [ "全部", "待打款", "已打款", "被拒绝" ],
        wdtype: [ "", "微信", "支付宝", "银行卡", "余额" ],
        status: [ 9, 0, 1, 2 ],
        statusstr: [ "待打款", "已打款", "被拒绝" ],
        curIndex: 0,
        page: [ 1, 1, 1, 1 ],
        list: []
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: a.fontcolor ? a.fontcolor : "#000000",
            backgroundColor: a.color ? a.color : "#ffffff",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {
        var a = this, t = wx.getStorageSync("openid"), e = a.data.curIndex, n = a.data.status[e];
        app.util.request({
            url: "entry/wxapp/GetWithdrawal",
            data: {
                status: n,
                openid: t
            },
            success: function(t) {
                console.log("订单数据"), console.log(t.data), 2 == t.data ? a.setData({
                    list: []
                }) : a.setData({
                    list: t.data
                });
            }
        });
    },
    onShow: function() {},
    onReachBottom: function() {
        var e = this, n = e.data.curIndex, t = e.data.status[n], a = wx.getStorageSync("openid"), o = e.data.page, s = o[n], i = e.data.list;
        app.util.request({
            url: "entry/wxapp/GetWithdrawal",
            data: {
                status: t,
                openid: a,
                page: s
            },
            success: function(t) {
                if (2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var a = t.data;
                    i = i.concat(a), o[n] = s + 1, e.setData({
                        list: i,
                        page: o
                    });
                }
            }
        });
    },
    bargainTap: function(t) {
        var a = this, e = parseInt(t.currentTarget.dataset.index), n = [ 1, 1, 1, 1 ], o = a.data.status[e], s = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/GetWithdrawal",
            data: {
                status: o,
                openid: s
            },
            success: function(t) {
                2 == t.data ? a.setData({
                    list: [],
                    curIndex: e,
                    page: n
                }) : a.setData({
                    list: t.data,
                    curIndex: e,
                    page: n
                });
            }
        });
    },
    toFxBilldet: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/mzhk_sun/plugin/distribution/fxBilldet/fxBilldet?id=" + a
        });
    }
});