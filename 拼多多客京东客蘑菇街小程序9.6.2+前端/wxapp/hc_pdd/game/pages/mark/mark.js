var app = getApp();

Page({
    data: {
        indicatorDots: !1,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3,
        previousmargin: "137rpx",
        nextmargin: "137rpx",
        circular: !0,
        tuhight: 0,
        lable: !1,
        Mask: !1
    },
    onLoad: function(a) {
        var t = wx.getMenuButtonBoundingClientRect().top;
        this.setData({
            top: t
        }), this.Kouhonglist();
    },
    lablefor: function(a) {
        var t = this, i = a.currentTarget.dataset.index, e = t.data.imgUrls[i].goods_id;
        console.log(e);
        var n = t.data.lable;
        n = 0 == n, t.setData({
            lable: n,
            goods_id: e,
            autoplay: !t.data.autoplay
        });
    },
    Game: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Game",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                goods_id: e.data.goods_id
            },
            success: function(a) {
                var t = a.data.data.status, i = a.data.data;
                app.globalData.url = i, e.setData({
                    url: i
                }), console.log(i), 1 == t ? e.setData({
                    Mask: !0
                }) : 2 == t ? wx.showToast({
                    title: "您今日挑战次数已达上线",
                    icon: "none",
                    duration: 1e3
                }) : wx.navigateTo({
                    url: "../gamet/gamet"
                });
            }
        });
    },
    myzhia: function() {
        this.setData({
            Mask: !1
        });
    },
    bindchange: function(a) {
        var t = a.detail.current;
        this.data.imgUrls;
        this.setData({
            tuhight: t,
            lable: !1,
            autoplay: !0
        });
    },
    fan: function() {
        wx.switchTab({
            url: "../../../pages/index/index"
        });
    },
    Kouhonglist: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Kouhonglist",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list, i = a.data.data.peoplelist, e = a.data.data.pic, n = a.data.data.title;
                o.setData({
                    imgUrls: t,
                    peoplelist: i,
                    pic: e,
                    title: n
                });
            }
        });
    },
    game: function() {
        1 == this.data.lable ? this.Game() : wx.showToast({
            title: "请选择一个商品",
            icon: "none",
            duration: 1e3,
            mask: !0
        });
    },
    mall: function() {
        wx.switchTab({
            url: "../../../pages/index/index"
        });
    },
    onReady: function() {},
    onShow: function() {
        this.Kouhonglist();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(a) {
        var t = app.globalData.user_id;
        return console.log(t, "转发user_id"), {
            title: this.data.title,
            path: "hc_pdd/game/pages/gameinvite/gameinvite?user_id=" + app.globalData.user_id,
            imageUrl: this.data.pic,
            success: function(a) {},
            fail: function(a) {}
        };
    }
});