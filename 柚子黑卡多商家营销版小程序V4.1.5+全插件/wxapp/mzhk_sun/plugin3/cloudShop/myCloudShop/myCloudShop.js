/*   time:2019-08-09 13:18:48*/
var app = getApp();
Page({
    data: {
        curindex: 0
    },
    onLoad: function(o) {
        var a = wx.getStorageSync("openid");
        this.setData({
            openid: a
        });
        var t = wx.getStorageSync("url");
        console.log(t), this.setData({
            url: t
        }), this.getShopkeeper(), this.getAllCloudGoods(), this.onCloudShopSet()
    },
    onTab: function(o) {
        if (console.log("----------------------"), o) {
            if (this.data.curindex == o.currentTarget.dataset.tabid) return !1;
            this.setData({
                curindex: o.currentTarget.dataset.tabid
            }), this.getAllCloudGoods()
        }
    },
    getShopkeeper: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/CloudShopUser",
            data: {
                openid: a.data.openid,
                m: app.globalData.Plugin_cloud
            },
            success: function(o) {
                console.log("获取店主信息"), console.log(o), a.setData({
                    shopkeeper: o.data
                })
            }
        })
    },
    getAllCloudGoods: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/GetAllCloudGoods",
            data: {
                openid: e.data.openid,
                m: app.globalData.Plugin_cloud
            },
            success: function(o) {
                if (console.log("获取商品商品数据"), console.log(o), 2 != o.data) {
                    var a = e.data.curindex,
                        t = o.data[a].goods;
                    e.setData({
                        allCloudGoods: o.data,
                        allCloudGoodsList: t,
                        lid: o.data[a].lid
                    })
                }
            }
        })
    },
    onSearch: function(o) {
        var a = this;
        console.log(o), console.log(o.detail.value), console.log(a.data.shopkeeper.id), console.log(a.data.lid), app.util.request({
            url: "entry/wxapp/getcloudsearch",
            data: {
                keywords: o.detail.value,
                shopid: a.data.shopkeeper.id,
                lid: a.data.lid,
                m: app.globalData.Plugin_cloud
            },
            success: function(o) {
                console.log("搜索商品"), console.log(o), 2 == o.data ? a.setData({
                    allCloudGoodsList: []
                }) : a.setData({
                    allCloudGoodsList: o.data
                })
            }
        })
    },
    onCloudShopSet: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/CloudShopSet",
            data: {
                m: app.globalData.Plugin_cloud
            },
            success: function(o) {
                console.log("平台首页是否显示"), console.log(o), a.setData({
                    toindex_open: o.data.toindex_open
                })
            }
        })
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});