var app = getApp();

Page({
    data: {
        curIndex: 0,
        nav: [ "全部", "待激活", "待使用", "已完成" ],
        status: [ 0, 1, 2, 3 ],
        page: [ 1, 1, 1, 1 ],
        orderlist: []
    },
    onLoad: function(t) {
        var a = this, e = t.tab ? t.tab : 0, n = a.data.status[e], o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/GetMyorder",
            data: {
                orderstatus: n,
                openid: o,
                m: app.globalData.Plugin_fission
            },
            success: function(t) {
                console.log(t), 2 == t.data ? a.setData({
                    orderlist: [],
                    curIndex: e
                }) : a.setData({
                    orderlist: t.data,
                    curIndex: e
                });
            }
        });
    },
    bargainTap: function(t) {
        var a = this, e = parseInt(t.currentTarget.dataset.index), n = a.data.status[e], o = wx.getStorageSync("openid"), r = [ 1, 1, 1, 1 ];
        app.util.request({
            url: "entry/wxapp/GetMyorder",
            data: {
                orderstatus: n,
                openid: o,
                m: app.globalData.Plugin_fission
            },
            success: function(t) {
                2 == t.data ? a.setData({
                    orderlist: [],
                    page: r
                }) : a.setData({
                    orderlist: t.data,
                    page: r
                });
            }
        }), this.setData({
            curIndex: e
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, n = e.data.curIndex, t = e.data.status[n], a = wx.getStorageSync("openid"), o = e.data.orderlist, r = e.data.page, s = r[n];
        app.util.request({
            url: "entry/wxapp/GetMyorder",
            cachetime: "10",
            data: {
                orderstatus: t,
                openid: a,
                page: s,
                m: app.globalData.Plugin_fission
            },
            success: function(t) {
                if (2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var a = t.data;
                    o = o.concat(a), r[n] = s + 1, console.log(r), e.setData({
                        orderlist: o,
                        page: r
                    });
                }
            }
        });
    },
    toOrderder: function(t) {
        var a = parseInt(t.currentTarget.dataset.fid), e = parseInt(t.currentTarget.dataset.bid);
        wx.navigateTo({
            url: "/mzhk_sun/plugin/fission/coupon/coupon?fid=" + a + "&bid=" + e
        });
    }
});