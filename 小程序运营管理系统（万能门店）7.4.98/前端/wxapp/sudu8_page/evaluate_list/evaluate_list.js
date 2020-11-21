var app = getApp();

Page({
    data: {
        flag: 0,
        id: 0,
        protype: "",
        list: [],
        zan: 0,
        page: 1,
        user: ""
    },
    onLoad: function(a) {
        var t = this;
        wx.setNavigationBarTitle({
            title: "商品评价列表"
        }), a.user && t.setData({
            user: a.user
        }), a.id && t.setData({
            id: a.id
        }), a.protype && t.setData({
            protype: a.protype
        });
        var e = 0;
        a.fxsid && (e = a.fxsid, t.setData({
            fxsid: a.fxsid
        }));
        var s = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: s,
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
        }), app.util.getUserInfo(this.getinfos, e);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.setData({
            page: 1
        }), this.getlist(), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {
        var t = this, a = t.data.flag;
        t.setData({
            flag: a
        });
        var e = t.data.page;
        app.util.request({
            url: "entry/wxapp/evaluateList",
            data: {
                flag: a,
                id: t.data.id,
                protype: t.data.protype,
                page: e,
                openid: wx.getStorageSync("openid"),
                user: t.data.user
            },
            success: function(a) {
                t.setData({
                    page: e + 1,
                    list: 1 == e ? a.data.data : t.data.list.concat(a.data.data)
                });
            }
        });
    },
    onShareAppMessage: function() {},
    goevaluatecon: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/sudu8_page/evaluate_detail/evaluate_detail?id=" + t + "&protype=" + this.data.protype
        });
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                t.setData({
                    openid: a.data
                }), t.getlist();
            }
        });
    },
    getlist: function(a) {
        var t = this, e = t.data.page;
        if (null == a) {
            var s = t.data.flag;
            e = 1;
        } else {
            s = a.currentTarget.dataset.flag;
            e = 1;
        }
        t.setData({
            flag: s
        }), app.util.request({
            url: "entry/wxapp/evaluateList",
            data: {
                flag: s,
                id: t.data.id,
                protype: t.data.protype,
                page: e,
                openid: wx.getStorageSync("openid"),
                user: t.data.user
            },
            success: function(a) {
                t.setData({
                    list: a.data.data
                });
            }
        });
    },
    addLikes: function(a) {
        var t = this, e = a.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Evaluatelikes",
            data: {
                id: e,
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                1 == a.data.data.flag ? (1 == a.data.data.likes && (wx.showToast({
                    title: "点赞成功"
                }), wx.startPullDownRefresh(), t.data.page = 1, t.data.zan = 1, wx.stopPullDownRefresh()), 
                2 == a.data.data.likes && (wx.showToast({
                    title: "取赞成功"
                }), wx.startPullDownRefresh(), t.data.page = 1, t.data.zan = 0, wx.stopPullDownRefresh())) : wx.showModal({
                    title: "提示",
                    content: "点赞失败",
                    showCancel: !1
                });
            }
        });
    }
});