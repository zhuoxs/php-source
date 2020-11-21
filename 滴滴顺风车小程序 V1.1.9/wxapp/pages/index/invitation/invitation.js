var t = getApp();

Page({
    data: {
        navbar: [ "我的邀请", "我的车友" ],
        currentTab: 0,
        logintag: "",
        arr: [],
        info: []
    },
    onLoad: function(t) {
        var a = this;
        try {
            var n = wx.getStorageSync("session");
            n && (console.log("logintag:", n), a.setData({
                logintag: n
            }));
        } catch (t) {}
        a.my_share_list();
    },
    navbarTap: function(t) {
        console.log(t.currentTarget.dataset.idx), 0 == t.currentTarget.dataset.idx ? this.my_share_list() : (this.my_carfriend_list(), 
        console.log("我的车友")), this.setData({
            currentTab: t.currentTarget.dataset.idx
        });
    },
    my_share_list: function(a) {
        var n = this, e = n.data.logintag;
        wx.request({
            url: t.data.url + "my_share_list",
            data: {
                logintag: e
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("my_share_list => 我的邀请"), console.log(t), "0000" == t.data.retCode ? n.setData({
                    info: t.data.info
                }) : (wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), "没有记录" == t.data.retDesc && n.setData({
                    info: []
                }));
            }
        });
    },
    my_carfriend_list: function(a) {
        var n = this, e = n.data.logintag;
        wx.request({
            url: t.data.url + "my_carfriend_list",
            data: {
                logintag: e
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("my_carfriend_list => 我的车友"), console.log(t), "0000" == t.data.retCode ? n.setData({
                    arr: t.data.info
                }) : (wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), "没有记录" == t.data.retDesc && n.setData({
                    info: []
                }));
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});