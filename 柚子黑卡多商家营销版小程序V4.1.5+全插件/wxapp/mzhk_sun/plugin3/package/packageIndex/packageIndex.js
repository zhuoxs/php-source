/*   time:2019-08-09 13:18:46*/
function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a
}
var app = getApp();
Page({
    data: {
        nav: "",
        curIndex: 0,
        whichonetwo: 35,
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            none: !1,
            data: []
        }
    },
    onLoad: function(a) {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 8
            },
            showLoading: !1,
            success: function(a) {
                wx.setNavigationBarTitle({
                    title: a.data.navname ? a.data.navname : "套餐包"
                })
            }
        });
        var t = app.getSiteUrl();
        t ? (n.setData({
            url: t
        }), app.editTabBar(t)) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(a) {
                wx.setStorageSync("url", a.data), t = a.data, app.editTabBar(t), n.setData({
                    url: t
                })
            }
        }), app.util.request({
            url: "entry/wxapp/packagetype",
            data: {
                m: app.globalData.Plugin_package
            },
            success: function(e) {
                console.log(e), app.util.request({
                    url: "entry/wxapp/packagelist",
                    data: {
                        type: e.data[0].id,
                        page: 1,
                        m: app.globalData.Plugin_package
                    },
                    success: function(a) {
                        var t;
                        console.log(a), n.setData((_defineProperty(t = {}, "list.data", a.data), _defineProperty(t, "nav", e.data), _defineProperty(t, "imgLink", wx.getStorageSync("url")), _defineProperty(t, "type", e.data[0].id), t))
                    }
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
        var n = this,
            i = this,
            a = i.data.list.page;
        i.data.list.over && wx.showToast({
            title: "没有更多的套餐了",
            icon: "none",
            duration: 2e3
        }), app.util.request({
            url: "entry/wxapp/packagelist",
            data: {
                type: i.data.type,
                page: ++a,
                m: app.globalData.Plugin_package
            },
            success: function(a) {
                var t;
                if (a.data.length <= 0) return n.setData(_defineProperty({}, "list.over", !0)), wx.showToast({
                    title: "没有更多的套餐了",
                    icon: "none",
                    duration: 2e3
                }), !1;
                var e = i.data.list.data.concat(a.data);
                n.setData((_defineProperty(t = {}, "list.data", e), _defineProperty(t, "list.page", ++i.data.list.page), t))
            }
        })
    },
    onShareAppMessage: function() {},
    onItemTap: function(a) {
        wx.navigateTo({
            url: "../packageDetail/packageDetail?pid=" + a.currentTarget.dataset.id
        })
    },
    onNavTap: function(a) {
        var e = this,
            n = a.currentTarget.dataset.idx,
            i = a.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/packagelist",
            data: {
                type: i,
                page: this.data.list.page,
                m: app.globalData.Plugin_package
            },
            success: function(a) {
                var t;
                console.log(a), e.setData((_defineProperty(t = {}, "list.page", 1), _defineProperty(t, "list.data", a.data), _defineProperty(t, "type", i), _defineProperty(t, "curIndex", n), t))
            }
        })
    },
    gotoadinfo: function(a) {
        var t = a.currentTarget.dataset.tid,
            e = a.currentTarget.dataset.id;
        app.func.gotourl(app, t, e)
    }
});