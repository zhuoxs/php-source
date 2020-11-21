var app = getApp();

Page({
    data: {},
    onLoad: function(n) {
        this.Headcolor(), this.tuandui(), this.Diyname();
        var o = app.globalData.Headcolor, a = app.globalData.title;
        this.setData({
            backgroundColor: o,
            titlehand: a
        });
    },
    onReady: function() {},
    onShow: function() {},
    tuandui: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Myteam",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(n) {
                var o = n.data.data.info, a = n.data.data.data;
                null == a.order && (a.order = 0), null == a.order_24 && (a.order_24 = 0), null == a.order_48 && (a.order_48 = 0), 
                null == a.ordermoney && (a.ordermoney = 0), null == a.ordermoney1 && (a.ordermoney1 = 0), 
                null == a.ordermoney2 && (a.ordermoney2 = 0), null == a.ordermoney3 && (a.ordermoney3 = 0), 
                null == a.son1_count && (a.son1_count = 0), null == a.son1_daili_count && (a.son1_daili_count = 0), 
                null == a.son1_huiyuan_count && (a.son1_huiyuan_count = 0), null == a.son1_huiyuan_count && (a.son1_huiyuan_count = 0), 
                null == a.son2_count && (a.son2_count = 0), null == a.son2_daili_count && (a.son2_daili_count = 0), 
                null == a.son2_huiyuan_count && (a.son2_huiyuan_count = 0), null == a.son3_daili_count && (a.son3_daili_count = 0), 
                null == a.son3_count && (a.son3_count = 0), null == a.son3_huiyuan_count && (a.son3_huiyuan_count = 0), 
                null == a.son_count && (a.son_count = 0), null == a.son_huiyuan_count && (a.son_huiyuan_count = 0), 
                null == a.son_daili_count && (a.son_daili_count = 0), t.setData({
                    yuca: a,
                    info: o
                });
            }
        });
    },
    Diyname: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Diyname",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(n) {
                var o = n.data.data.config;
                a.setData({
                    nufiome: o
                });
            }
        });
    },
    ttuna: function() {
        console.log(111), wx.navigateTo({
            url: "../team/team"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    Headcolor: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            success: function(n) {
                var o = n.data.data.config.search_color, a = n.data.data.config.share_icon;
                n.data.data.config.head_color;
                app.globalData.Headcolor = n.data.data.config.head_color;
                var t = n.data.data.config.title, u = n.data.data.yesno, l = n.data.data.config.loginbg;
                i.setData({
                    search_color: o,
                    share_icon: a,
                    yesno: u,
                    loginbg: l
                }), wx.setNavigationBarTitle({
                    title: t
                });
            },
            fail: function(n) {
                console.log("失败" + n), console.log(n);
            }
        });
    }
});