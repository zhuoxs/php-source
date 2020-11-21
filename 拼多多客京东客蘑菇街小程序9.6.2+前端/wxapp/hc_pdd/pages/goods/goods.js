function _toConsumableArray(a) {
    if (Array.isArray(a)) {
        for (var t = 0, e = Array(a.length); t < a.length; t++) e[t] = a[t];
        return e;
    }
    return Array.from(a);
}

var app = getApp(), us0 = [ "全部", "已成团", "已确认收货", "审核成功", "审核失败" ], us1 = [ "全部", "已支付", "已完成", "最终完成", "无效订单" ], us2 = [ "全部", "已支付", "已完成", "已结算", "无效订单" ], point = 0;

Page({
    data: {
        parameter: 0,
        pageNum: 1,
        Orderfal: !1,
        status: []
    },
    onLoad: function(a) {
        var t = a.chshi, e = app.globalData.Headcolor, r = app.globalData.userInfo, o = us0;
        this.setData({
            userInfo: r,
            chshi: t,
            backgroundColor: e,
            status: o
        }), this.Orderlist(t), console.log(app.globalData.user_id);
    },
    threeterminal: function(a) {
        var t = a.currentTarget.dataset.index, e = us0;
        point = 0, 1 == t ? e = us1 : 2 == t && (e = us2), this.setData({
            jingxu_index: t,
            parameter: t,
            pageNum: 1,
            status: e,
            chshi: 0
        }), this.Orderlist(0);
    },
    Headcolor: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.config.search_color, e = a.data.data.config.share_icon, r = a.data.data.config.shenhe, o = a.data.data.config, i = a.data.data.is_daili;
                a.data.data.config.head_color;
                app.globalData.Headcolor = a.data.data.config.head_color;
                a.data.data.config.title;
                app.globalData.title = a.data.data.config.title;
                var n = a.data.data.config.kaiguan;
                s.setData({
                    backgroundColor: a.data.data.config.head_color,
                    title: a.data.data.config.title,
                    search_color: t,
                    share_icon: e,
                    shenhe: r,
                    config: o,
                    is_daili: i,
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
        point = e, t.setData({
            chshi: a.currentTarget.dataset.index,
            pageNum: 1
        }), console.log(t.data.pageNum), t.Orderlist(e);
    },
    Orderlist: function(a) {
        var e = this;
        e.setData({
            Orderlist: [],
            Orderfal: !1
        }), wx.showLoading({
            title: "加载中"
        }), setTimeout(function() {
            wx.hideLoading();
        }, 500), app.util.request({
            url: "entry/wxapp/Orderlist",
            method: "POST",
            data: {
                order_status: a,
                user_id: app.globalData.user_id,
                parameter: e.data.parameter
            },
            success: function(a) {
                console.log(a), console.log(e.data.parameter);
                var t = a.data.data;
                "" == a.data.data || null == a.data.data ? e.setData({
                    Orderfal: !0,
                    Orderlist: []
                }) : e.setData({
                    Orderlist: t,
                    Orderfal: !1
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
    jaizai: function(a, t) {
        var e = this;
        console.log(a, t), app.util.request({
            url: "entry/wxapp/Orderlist",
            method: "POST",
            data: {
                pageNum: a,
                user_id: app.globalData.user_id,
                parameter: e.data.parameter,
                order_status: t
            },
            success: function(a) {
                var t;
                console.log(a), (t = e.data.Orderlist).push.apply(t, _toConsumableArray(a.data.data)), 
                console.log(e.data.Orderlist), e.setData({
                    Orderlist: e.data.Orderlist,
                    loding: !0
                });
            }
        });
    },
    onReachBottom: function() {
        var a = this, t = a.data.pageNum;
        t++, a.jaizai(t, point), a.setData({
            loding: !1,
            pageNum: t
        });
    },
    onUnload: function() {},
    onPullDownRefresh: function() {}
});