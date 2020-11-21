var a = getApp();

Page({
    data: {
        showModal: !1,
        nclass: [],
        info: []
    },
    onLoad: function(t) {
        var n = this;
        try {
            var o = wx.getStorageSync("session");
            o && (console.log("logintag:", o), n.setData({
                logintag: o
            }));
        } catch (a) {}
        var e = n.data.logintag;
        wx.request({
            url: a.data.url + "revenue_detail_list",
            data: {
                logintag: e,
                nclass: 0
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(a) {
                console.log("资金明列表"), console.log(a), "0000" == a.data.retCode ? n.setData({
                    info: a.data.info,
                    nclass: a.data.nclass
                }) : (wx.showToast({
                    title: a.data.retDesc,
                    icon: "none",
                    duration: 2e3
                }), "没有记录" == a.data.retDesc && n.setData({
                    info: []
                }));
            }
        });
    },
    particulars: function(a) {
        console.log(a.currentTarget.dataset);
        var t = a.currentTarget.dataset.pid, n = a.currentTarget.dataset.nid, o = a.currentTarget.dataset.nclass;
        wx.navigateTo({
            url: "particulars/particulars?nid=" + n + "&pid=" + t + "&nclass=" + o
        });
    },
    all: function(t) {
        var n = this, o = n.data.logintag, e = n.data.loginopen, s = n.data.nclass, i = t.currentTarget.dataset.id;
        for (var c in s) if (s[c] == i) i = c;
        wx.request({
            url: a.data.url + "revenue_detail_list",
            data: {
                loginopen: e,
                logintag: o,
                nclass: i
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(a) {
                console.log("资金明列表"), console.log(a), "0000" == a.data.retCode ? n.setData({
                    info: a.data.info,
                    nclass: a.data.nclass
                }) : wx.showToast({
                    title: a.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), n.hideModal();
            }
        });
    },
    showDialogBtn: function() {
        this.setData({
            showModal: !0
        });
    },
    preventTouchMove: function() {},
    hideModal: function() {
        this.setData({
            showModal: !1
        });
    },
    onCancel: function() {
        this.hideModal();
    },
    onConfirm: function() {
        this.hideModal();
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});