var app = getApp();

Page({
    data: {
        navTile: "拼团活动",
        showModalStatus: !0,
        num: 1
    },
    onLoad: function(o) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        }), app.get_imgroot().then(function(t) {
            e.setData({
                imgroot: t
            }), app.get_user_info().then(function(t) {
                var n = o.id;
                app.util.request({
                    url: "entry/wxapp/GetGroup",
                    fromcache: !1,
                    data: {
                        group_id: n,
                        user_id: t.id
                    },
                    success: function(t) {
                        var o = t.data.info;
                        o.group_id = n;
                        var i = t.data.list;
                        if (o.userNum - o.num) for (var r = 0; r < o.userNum - o.num; r++) i.push("../../../../style/images/nouser.png"); else o.status = 3;
                        e.setData({
                            goods: o,
                            user: i
                        });
                    }
                });
            });
        }), o.d_user_id && app.distribution.distribution_parsent(app, o.d_user_id);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = this.data.goods, o = wx.getStorageSync("users"), i = {};
        return i.title = t.title, i.path = "yzhyk_sun/pages/index/groupjoin/groupjoin?id=" + t.group_id + "&d_user_id=" + o.id, 
        i;
    },
    toGrouppro: function(t) {
        wx.navigateTo({
            url: "../groupPro/groupPro"
        });
    },
    toJoin: function(t) {
        var o = this.data.goods;
        app.group_cart_clear(), app.group_cart_add({
            id: o.id,
            price: o.price,
            src: o.img,
            num: 1,
            title: o.title
        }), wx.redirectTo({
            url: "../cforder3/cforder3?group=1&group_id=" + o.group_id
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "/yzhyk_sun/pages/index/index"
        });
    }
});