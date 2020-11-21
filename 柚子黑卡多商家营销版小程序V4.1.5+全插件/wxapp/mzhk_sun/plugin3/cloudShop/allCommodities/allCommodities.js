/*   time:2019-08-09 13:18:48*/
var app = getApp();
Page({
    data: {
        curindex: 0
    },
    onLoad: function(o) {
        var t = wx.getStorageSync("openid");
        this.setData({
            openid: t
        });
        var a = wx.getStorageSync("url");
        console.log(a), this.setData({
            url: a
        }), this.getAllCloudGoods(), this.onCloudShopSet()
    },
    onTab: function(o) {
        if (console.log("----------------------"), o) {
            if (this.data.curindex == o.currentTarget.dataset.tabid) return !1;
            this.setData({
                curindex: o.currentTarget.dataset.tabid,
                page: 1
            }), this.getAllCloudGoods()
        }
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
                    var t = e.data.curindex,
                        a = o.data[t].goods;
                    e.setData({
                        allCloudGoods: o.data,
                        allCloudGoodsList: a
                    })
                }
            }
        })
    },
    onCloudShopSet: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/CloudShopSet",
            data: {
                m: app.globalData.Plugin_cloud
            },
            success: function(o) {
                console.log("平台首页是否显示"), console.log(o), t.setData({
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
    onReachBottom: function() {
        var a = this,
            e = a.data.curindex,
            n = a.data.page,
            l = a.data.allCloudGoodsList;
        console.log(l), app.util.request({
            url: "entry/wxapp/GetAllCloudGoods",
            data: {
                page: n,
                openid: a.data.openid,
                m: app.globalData.Plugin_cloud
            },
            success: function(o) {
                if (console.log(o.data), 0 < o.data.length) {
                    var t = o.data[e].goods;
                    l = l.concat(t), a.setData({
                        allCloudGoodsList: l,
                        page: n + 1
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