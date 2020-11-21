var app = getApp();

Page({
    data: {
        Commiss: [ "所有", "一级", "二级", "三级" ],
        nubm: 1
    },
    onLoad: function(a) {
        var t = this, o = app.globalData.Headcolor;
        t.xiangL(1), t.Headcolor(), t.setData({
            backgroundColor: o
        });
    },
    qir: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            nubm: t
        }), this.xiangL(t);
    },
    onReady: function() {},
    tixian: function() {
        wx.navigateTo({
            url: "../brokerage/brokerage?kenif=1"
        });
    },
    xiangL: function(a) {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Corder",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                sort: a
            },
            success: function(a) {
                var t = a.data.data.list, o = a.data.data.money_count;
                null == o && (o = 0);
                var n = a.data.data.menu;
                i.setData({
                    goodsist: t,
                    lejui: o,
                    menu: n
                });
            }
        });
    },
    Headcolor: function() {
        var r = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.config.tixiant_color, o = a.data.data.config.tixianb_color, n = a.data.data.config.bg_pic, i = a.data.data.info.fx_level, e = a.data.data.is_daili;
                r.setData({
                    tixianb_color: o,
                    tixiant_color: t,
                    bg_pic: n,
                    is_daili: e,
                    fx_level: i
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});