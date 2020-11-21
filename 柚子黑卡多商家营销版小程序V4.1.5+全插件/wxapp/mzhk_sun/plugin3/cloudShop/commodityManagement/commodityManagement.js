/*   time:2019-08-09 13:18:48*/
var app = getApp();
Page({
    data: {
        curindex: 0,
        page: 1
    },
    onLoad: function(a) {
        a.lid && a.curindex && this.setData({
            lid: a.lid,
            curindex: a.curindex
        });
        var t = wx.getStorageSync("openid");
        this.setData({
            openid: t
        });
        var o = wx.getStorageSync("url");
        console.log(o), this.setData({
            url: o
        }), 0 == a.curindex && this.getGoodsPage(), 1 == a.curindex && this.getCloudGoods()
    },
    getGoodsPage: function(a) {
        var t = this;
        if (a) {
            if (this.data.curindex == a.currentTarget.dataset.tabid) return !1;
            this.setData({
                curindex: a.currentTarget.dataset.tabid,
                page: 1
            })
        }
        console.log(t.data.lid), app.util.request({
            url: "entry/wxapp/AddGoodsPage",
            data: {
                lid: t.data.lid,
                openid: t.data.openid,
                m: app.globalData.Plugin_cloud
            },
            success: function(a) {
                console.log("添加商品页面"), console.log(a), 2 == a.data ? t.setData({
                    goodsPage: []
                }) : t.setData({
                    goodsPage: a.data
                })
            }
        })
    },
    getCloudGoods: function(a) {
        var t = this;
        if (a) {
            if (this.data.curindex == a.currentTarget.dataset.tabid) return !1;
            this.setData({
                curindex: a.currentTarget.dataset.tabid,
                page: 1
            })
        }
        console.log(t.data.lid), app.util.request({
            url: "entry/wxapp/GetCloudGoods",
            data: {
                lid: t.data.lid,
                openid: t.data.openid,
                m: app.globalData.Plugin_cloud
            },
            success: function(a) {
                console.log("添加商品页面"), console.log(a), 2 == a.data ? t.setData({
                    goodsPage: []
                }) : t.setData({
                    goodsPage: a.data
                })
            }
        })
    },
    onAddGoodsCloud: function(a) {
        var t = this;
        console.log(t.data.lid), console.log(a.currentTarget.dataset.gid), console.log(a.currentTarget.dataset.index), console.log(t.data.goodsPage.splice(a.currentTarget.dataset.index, 1)), console.log(t.data.goodsPage), app.util.request({
            url: "entry/wxapp/AddGoodsCloud",
            data: {
                lid: t.data.lid,
                openid: t.data.openid,
                gid: a.currentTarget.dataset.gid,
                m: app.globalData.Plugin_cloud
            },
            success: function(a) {
                console.log("上架"), console.log(a), t.setData({
                    goodsPage: t.data.goodsPage
                }), wx.showToast({
                    title: "上架成功",
                    icon: "success",
                    duration: 3e3
                })
            }
        })
    },
    onLowerShelf: function(a) {
        var t = this;
        console.log(t.data.lid), console.log(a.currentTarget.dataset.cgid), console.log(a.currentTarget.dataset.index), console.log(t.data.goodsPage.splice(a.currentTarget.dataset.index, 1)), console.log(t.data.goodsPage), app.util.request({
            url: "entry/wxapp/SetGoodsStatus",
            data: {
                gid: a.currentTarget.dataset.cgid,
                m: app.globalData.Plugin_cloud
            },
            success: function(a) {
                console.log("下架"), console.log(a), t.setData({
                    goodsPage: t.data.goodsPage
                }), wx.showToast({
                    title: "下架成功",
                    icon: "success",
                    duration: 3e3
                })
            }
        })
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var o = this,
            e = o.data.page,
            d = o.data.goodsPage;
        0 == o.data.curindex ? app.util.request({
            url: "entry/wxapp/AddGoodsPage",
            data: {
                page: e,
                lid: o.data.lid,
                openid: o.data.openid,
                m: app.globalData.Plugin_cloud
            },
            success: function(a) {
                if (console.log(a.data), 0 < a.data.length) {
                    var t = a.data;
                    d = d.concat(t), o.setData({
                        goodsPage: d,
                        page: e + 1
                    })
                } else wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                })
            }
        }) : app.util.request({
            url: "entry/wxapp/GetCloudGoods",
            data: {
                page: e,
                lid: o.data.lid,
                openid: o.data.openid,
                m: app.globalData.Plugin_cloud
            },
            success: function(a) {
                if (console.log(a.data), 0 < a.data.length) {
                    var t = a.data;
                    d = d.concat(t), o.setData({
                        goodsPage: d,
                        page: e + 1
                    })
                } else wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                })
            }
        })
    },
    onShareAppMessage: function() {}
});