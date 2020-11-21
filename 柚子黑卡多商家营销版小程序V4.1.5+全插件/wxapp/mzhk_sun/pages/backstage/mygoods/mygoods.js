var app = getApp();

Page({
    data: {
        curIndex: 0,
        nav: [ "普通", "砍价", "拼团", "抢购", "优惠券" ],
        lids: [ 1, 2, 3, 5, 7 ],
        orderlist: [],
        page: [ 1, 1, 1, 1, 1, 1 ]
    },
    onLoad: function(a) {
        var t = this;
        if (a.index && t.setData({
            curIndex: a.index
        }), a.lid) var e = a.lid; else e = 1;
        app.util.request({
            url: "entry/wxapp/GetGoods",
            cachetime: "0",
            data: {
                lid: e,
                bid: wx.getStorageSync("brand_info").bid
            },
            success: function(a) {
                console.log(a.data), 2 != a.data ? t.setData({
                    orderlist: a.data
                }) : t.setData({
                    orderlist: []
                });
            }
        });
    },
    bargainTap: function(a) {
        var t = this, e = t.data.lids, n = parseInt(a.currentTarget.dataset.index), d = e[n];
        app.util.request({
            url: "entry/wxapp/GetGoods",
            cachetime: "0",
            data: {
                lid: d,
                bid: wx.getStorageSync("brand_info").bid
            },
            success: function(a) {
                console.log(a.data), 2 != a.data ? t.setData({
                    orderlist: a.data,
                    curIndex: n
                }) : t.setData({
                    orderlist: [],
                    curIndex: n
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var n = this, a = n.data.lids, d = parseInt(e.currentTarget.dataset.index), t = a[d], s = n.data.orderlist, i = n.data.page, r = i[d];
        app.util.request({
            url: "entry/wxapp/GetGoods",
            cachetime: "0",
            data: {
                lid: t,
                bid: wx.getStorageSync("brand_info").bid,
                page: r
            },
            success: function(a) {
                if (console.log(a.data), 2 != a.data) {
                    var t = a.data;
                    s = s.concat(t), i[d] = r + 1, n.setData({
                        orderlist: s,
                        page: i
                    });
                } else wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                });
            }
        });
    },
    goGoodsdetail: function(a) {
        var t = parseInt(a.currentTarget.dataset.gid), e = this.data.curIndex;
        console.log(t), wx.navigateTo({
            url: "/mzhk_sun/pages/backstage/release/release?gid=" + t + "&index=" + e
        });
    },
    toIndex: function(a) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/backstage/index2/index2"
        });
    },
    changeShelf: function(a) {
        var t = this, e = parseInt(a.currentTarget.dataset.gid), n = parseInt(a.currentTarget.dataset.isshelf), d = parseInt(a.currentTarget.dataset.index), s = t.data.orderlist, i = t.data.lids[t.data.curIndex];
        app.util.request({
            url: "entry/wxapp/changeShelf",
            cachetime: "0",
            data: {
                lid: i,
                gid: e,
                isshelf: n
            },
            success: function(a) {
                if (console.log(a.data), 2 != a.data) {
                    a.data;
                    s[d].isshelf = a.data.isshelf, s[d].isshelftext = a.data.isshelftext, t.setData({
                        orderlist: s
                    });
                }
            }
        });
    }
});