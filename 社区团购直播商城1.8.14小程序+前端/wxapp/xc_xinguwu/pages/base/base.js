var app = getApp();

Page({
    data: {},
    setNav: function() {
        wx.setNavigationBarTitle({
            title: "加载失败"
        });
    },
    getWxappSet: function(l) {
        app.systeminfo = wx.getSystemInfoSync();
        app.util.request({
            url: "entry/wxapp/index",
            showLoading: !1,
            data: {
                op: "base",
                userid: l.userid,
                type: l.type
            },
            success: function(a) {
                var e = a.data;
                if (e || (console.log("登录错误"), console.log(e)), e.data.module_url && (app.module_url = e.data.module_url), 
                e.data.audit && e.data.audit == app.version) wx.redirectTo({
                    url: "../audit/audit"
                }); else {
                    if (e.data.accredit && (app.accredit = e.data.accredit), e.data.tabbar) {
                        var t = e.data.tabbar;
                        if (app.look.istrue(t.list)) {
                            var o = [], r = 0;
                            t.list.forEach(function(a, e) {
                                1 == a.status && (o[r] = a, r++);
                            }), app.tabBar.list = o;
                        }
                        "" != t.backgroundColor && (app.tabBar.backgroundColor = t.backgroundColor), "" != t.borderStyle && (app.tabBar.borderStyle = t.borderStyle), 
                        "" != t.color && (app.tabBar.color = t.color), "" != t.selectedColor && (app.tabBar.selectedColor = t.selectedColor);
                    }
                    if (e.data.theme && 2 == e.data.theme.theme_type && (app.globalData.theme = e.data.theme, 
                    app.globalData.theme && app.globalData.theme.blackhome ? app.globalData.blackhomeimg = app.globalData.theme.blackhome : app.globalData.blackhomeimg = ""), 
                    e.data.user && (app.globalData.userInfo = e.data.user), e.data.express && (app.globalData.express = e.data.express), 
                    e.data.user_set && (app.user_set = e.data.user_set), e.data.address && (app.address = e.data.address), 
                    e.data.webset) if (app.globalData.webset = e.data.webset, app.globalData.webset.vip || (app.globalData.webset.vip = -1), 
                    -1 == e.data.webset.status) wx.redirectTo({
                        url: "../closed/closed"
                    }); else if (!e.data.user || "小黑" != e.data.user.nickname && "" != e.data.user.nickname && "无" != e.data.user.nickname || (app.getUserInfo = !0), 
                    "" != l.share && null != l.share) {
                        var s = l.share;
                        wx.redirectTo({
                            url: s
                        });
                    } else wx.redirectTo({
                        url: "../index/index"
                    }); else wx.showModal({
                        title: "系统提示",
                        content: "联系管理员先设置小程序信息"
                    });
                }
            }
        });
    },
    onLoad: function(e) {
        if (app.look.istrue(e.scene)) {
            var a, t = [];
            1 == (a = (t = decodeURIComponent(e.scene).split("$"))[0].split("?"))[0] && (e.share = "../detail/detail?id=" + a[1]), 
            2 == a[0] && (e.share = "../limitDetail/limitDetail?id=" + a[1]), 3 == a[0] && (e.share = "../groupdetail/groupdetail?id=" + a[1] + "&style=" + a[2] + "&sponsor_id=" + a[3]), 
            4 == a[0] && (e.share = "../index/index"), 5 == a[0] && (e.share = "/xc_xinguwu/manage/staffapply/staffapply"), 
            6 == a[0] && (e.share = "/xc_xinguwu/lottery/Sudoku/Sudoku?id=" + a[1]), 6 == a[0] && (e.share = "/xc_xinguwu/lottery/lottery/lottery?id=" + a[1]), 
            e.userid = t[1];
        } else app.look.istrue(e.share) && (e.share = decodeURIComponent(e.share));
        var o = this;
        wx.getNetworkType({
            success: function(a) {
                "none" == a.networkType ? (o.setNav(), wx.showModal({
                    title: "系统提示",
                    content: "当前无网络,请连接后重试"
                })) : o.getWxappSet(e);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});