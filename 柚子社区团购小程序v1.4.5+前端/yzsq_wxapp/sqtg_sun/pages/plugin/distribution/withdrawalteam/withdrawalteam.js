var app = getApp();

Page({
    data: {
        page: 1,
        limit: 10,
        olist: [],
        level: 1
    },
    onLoad: function(a) {
        console.log(a);
        var t = this, e = wx.getStorageSync("userInfo");
        a.user_id ? t.setData({
            user_id: a.user_id
        }) : t.setData({
            user_id: e.id
        }), a.level && t.setData({
            level: a.level
        }), t.baseset(), t.getTeamInfo(), t.getChilds();
    },
    getChilds: function() {
        var s = this, i = s.data.olist, o = s.data.limit, n = s.data.page, a = s.data.level, t = s.data.user_id;
        app.ajax({
            url: "Cdistribution|getChilds",
            data: {
                user_id: t,
                page: n,
                limit: o,
                level: a
            },
            success: function(a) {
                var t = a.data.length == o;
                if (a.data.length) {
                    if (1 == n) i = a.data; else for (var e in a.data) i.push(a.data[e]);
                    n += 1, s.setData({
                        olist: i,
                        show: !0,
                        hasMore: t,
                        page: n
                    });
                } else s.setData({
                    hasMore: !1,
                    show: !0,
                    nomore: !0
                });
            }
        });
    },
    getTeamInfo: function() {
        var t = this, a = t.data.user_id;
        app.ajax({
            url: "Cdistribution|getTeamInfo",
            data: {
                user_id: a
            },
            success: function(a) {
                t.setData({
                    teaminfo: a.data
                });
            }
        });
    },
    baseset: function() {
        var t = wx.getStorageSync("appConfig");
        t || app.ajax({
            url: "Csystem|getSetting",
            success: function(a) {
                t = a.data, wx.setStorageSync("appConfig", a.data);
            }
        }), this.setData({
            headerbg: t.personcenter_color_b ? t.personcenter_color_b : "#f87d6d"
        });
    },
    linkto: function(a) {
        var t = this.data.level + 1;
        app.navTo("../../distribution/withdrawalteam/withdrawalteam?user_id=" + a.currentTarget.dataset.userid + "&level=" + t);
    },
    onReachBottom: function() {
        var a = this;
        a.data.hasMore ? a.getChilds() : a.setData({
            nomore: !0
        });
    },
    onShareAppMessage: function() {}
});