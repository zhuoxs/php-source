var app = getApp();

Page({
    data: {
        us: [ "全部", "已成团", "已确认收货", "审核成功", "审核失败" ],
        parameter: 0
    },
    onLoad: function(a) {
        var t = a.chshi, e = app.globalData.Headcolor, o = app.globalData.userInfo;
        this.setData({
            userInfo: o,
            chshi: t,
            backgroundColor: e
        }), this.Orderlist(t);
    },
    threeterminal: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            jingxu_index: t,
            parameter: t,
            pageNum: 0
        }), this.Orderlist("");
    },
    Headcolor: function() {
        var d = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.config.search_color, e = a.data.data.config.share_icon, o = a.data.data.config.shenhe, i = a.data.data.config, r = a.data.data.is_daili;
                a.data.data.config.head_color;
                app.globalData.Headcolor = a.data.data.config.head_color;
                a.data.data.config.title;
                app.globalData.title = a.data.data.config.title;
                var n = a.data.data.config.kaiguan;
                d.setData({
                    backgroundColor: a.data.data.config.head_color,
                    title: a.data.data.config.title,
                    search_color: t,
                    share_icon: e,
                    shenhe: o,
                    config: i,
                    is_daili: r,
                    kaiguan: n
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    qiehuan: function(a) {
        var t = this, e = (t.data.chshi, a.currentTarget.dataset.index);
        t.setData({
            chshi: a.currentTarget.dataset.index,
            Orderlist: []
        }), t.Orderlist(e);
    },
    Orderlist: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Orderlist",
            method: "POST",
            data: {
                order_status: a,
                user_id: app.globalData.user_id,
                parameter: e.data.parameter
            },
            success: function(a) {
                var t = a.data.data;
                e.setData({
                    Orderlist: t
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        this.Headcolor();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});