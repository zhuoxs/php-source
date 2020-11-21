var app = getApp();

Page({
    data: {
        nubm: 1,
        parameter: 0,
        sort: 1
    },
    onLoad: function(a) {
        var t = this, e = app.globalData.Headcolor;
        t.xiangL(1), t.Headcolor(), t.setData({
            backgroundColor: e
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
                var t = a.data.data.list, e = a.data.data.money_count, n = a.data.data.menu;
                i.setData({
                    goodsist: t,
                    lejui: e,
                    menu: n
                });
            }
        });
    },
    threeterminal: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            jingxu_index: t,
            parameter: t,
            pageNum: 0
        }), this.xiangL(this.data.sort);
    },
    qir: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            nubm: t
        }), this.xiangL(t);
    },
    onShow: function() {},
    Headcolor: function() {
        var l = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: l.data.user_id
            },
            success: function(a) {
                var t = a.data.data.config, e = t.client_id, n = t.client_secret, i = t.pid, d = t.enable, o = a.data.data.config.shenhe, r = a.data.data.config.is_index, s = a.data.data.is_daili, u = t.zzappid, c = a.data.data.config.kaiguan;
                l.setData({
                    config: t,
                    client_id: e,
                    client_secret: n,
                    pid: i,
                    enable: d,
                    shenhe: o,
                    is_index: r,
                    appid: u,
                    is_daili: s,
                    kaiguan: c
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});