var app = getApp();

Page({
    data: {
        evaluate: 1,
        protype: ""
    },
    onLoad: function(a) {
        var t = this;
        a.id && t.setData({
            id: a.id
        }), a.protype && t.setData({
            protype: a.protype
        }), wx.setNavigationBarTitle({
            title: "商品评价详情"
        });
        var e = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: e,
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        }), app.util.getUserInfo(this.getinfos, 0);
    },
    onReady: function() {},
    onShow: function() {
        this.getinfos(), this.getinfo();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.getinfos(), this.getinfo(), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                t.setData({
                    openid: a.data
                });
            }
        });
    },
    getinfo: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/evaluateDetail",
            data: {
                id: e.data.id,
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                var t = e.data.openid;
                e.setData({
                    info: a.data.data,
                    order_id: a.data.data.orderid,
                    pid: a.data.data.pid
                }), null != a.data.data.append_content || a.data.data.openid != t ? e.setData({
                    evaluate: 1
                }) : e.setData({
                    evaluate: 2
                });
            }
        });
    },
    addevaluate: function() {
        var a = this;
        wx.navigateTo({
            url: "/sudu8_page/evaluate/evaluate?id=" + a.data.pid + "&type=" + a.data.protype + "&add=1&order_id=" + a.data.order_id
        });
    },
    addLikes: function(a) {
        var t = a.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Evaluatelikes",
            data: {
                id: t,
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                1 == a.data.data.flag ? (1 == a.data.data.likes && (wx.showToast({
                    title: "点赞成功"
                }), wx.startPullDownRefresh(), wx.stopPullDownRefresh()), 2 == a.data.data.likes && (wx.showToast({
                    title: "取赞成功"
                }), wx.startPullDownRefresh(), wx.stopPullDownRefresh())) : wx.showModal({
                    title: "提示",
                    content: "点赞失败",
                    showCancel: !1
                });
            }
        });
    }
});