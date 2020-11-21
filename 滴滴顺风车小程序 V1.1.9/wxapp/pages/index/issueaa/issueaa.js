var t = getApp();

Page({
    data: {
        navbar: [ "我是乘客", "我是车主" ],
        currentTab: 0,
        logintag: "",
        info: [],
        ntype: "1",
        refresh: "",
        p: 1
    },
    onLoad: function(t) {
        var a = this;
        try {
            var e = wx.getStorageSync("session");
            e && (console.log("logintag:", e), a.setData({
                logintag: e
            }));
        } catch (t) {}
        console.log("options:", t), 2 == t ? (a.my_travel_list(2), a.setData({
            currentTab: 1
        })) : a.my_travel_list(1);
    },
    my_travel_list: function(a) {
        var e = this, n = a, o = e.data.logintag;
        wx.request({
            url: t.data.url + "my_travel_list",
            data: {
                logintag: o,
                ntype: n
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("my_travel_list => 我的发布列表"), console.log(t), "0000" == t.data.retCode ? e.setData({
                    info: t.data.info
                }) : (wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), "没有记录" == t.data.retDesc && e.setData({
                    info: []
                }));
            }
        });
    },
    navbarTap: function(t) {
        console.log(t.currentTarget.dataset.idx);
        var a = this;
        0 == t.currentTarget.dataset.idx ? (a.my_travel_list(1), a.setData({
            ntype: "1",
            p: 1
        })) : (a.my_travel_list(2), a.setData({
            ntype: "2",
            p: 1
        })), a.setData({
            currentTab: t.currentTarget.dataset.idx
        });
    },
    coordinate: function(t) {
        var a = t.currentTarget.dataset.nid, e = t.currentTarget.dataset.ntype;
        wx.setStorage({
            key: "Bid",
            data: a
        }), wx.setStorage({
            key: "Bntype",
            data: e
        }), wx.navigateTo({
            url: "/pages/index/journey/coordinate/coordinate"
        });
    },
    Schedule: function(t) {
        var a = this, e = t.currentTarget.dataset.id, n = a.data.ntype;
        wx.setStorage({
            key: "Fid",
            data: e
        }), wx.setStorage({
            key: "Fntype",
            data: n
        }), wx.navigateTo({
            url: "Release/Release"
        });
    },
    onReady: function() {},
    onShow: function() {
        this.onLoad(), this.setData({
            currentTab: 0
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var a = this, e = a.data.logintag, n = a.data.ntype, o = (o = a.data.p) + 1;
        a.setData({
            p: o
        }), console.log(o), console.log(n), wx.request({
            url: t.data.url + "my_travel_list",
            data: {
                p: o,
                ntype: n,
                logintag: e
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            method: "GET",
            success: function(t) {
                console.log(t);
                var e = t.data.info, n = a.data.info;
                if ("0000" == t.data.retCode) if ("0" == e.length) wx.showToast({
                    title: "没有数据",
                    icon: "none",
                    duration: 1e3,
                    mask: !0
                }); else {
                    wx.showToast({
                        title: "加载中...",
                        icon: "loading",
                        duration: 1e3,
                        mask: !0
                    }), console.log(e);
                    for (var o = 0; o < e.length; o++) n.push(e[o]);
                    console.log("拼接数据:", n), a.setData({
                        info: n
                    });
                } else if (wx.showToast({
                    title: "没有数据",
                    icon: "none",
                    duration: 1e3,
                    mask: !0
                }), "账号已冻结" == t.data.retDesc) return void wx.navigateTo({
                    url: "/pages/index/index"
                });
            }
        });
    },
    onShareAppMessage: function() {}
});