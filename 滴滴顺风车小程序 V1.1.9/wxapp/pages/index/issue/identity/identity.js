var t = getApp();

Page({
    data: {
        logintag: ""
    },
    onLoad: function(t) {
        var o = this;
        try {
            var n = wx.getStorageSync("session");
            n && (console.log("logintag:", n), o.setData({
                logintag: n
            }));
        } catch (t) {}
    },
    Selectthe: function(o) {
        var n = this, e = o.currentTarget.dataset.id;
        console.log(o.currentTarget.dataset.id);
        var a = n.data.logintag;
        wx.request({
            url: t.data.url + "choose_identity",
            data: {
                logintag: a,
                nclass: e,
                form_id: 0
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("choose_identity => 会员选择身份"), console.log(t), "0000" == t.data.retCode ? (wx.setStorage({
                    key: "nclass",
                    data: e
                }), 1 == e ? (wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), setTimeout(function() {
                    console.log("延迟调用 => home"), wx.navigateTo({
                        url: "/pages/index/issue/issue"
                    });
                }, 1e3)) : wx.showModal({
                    title: "提示",
                    content: "车主发布任务，需要认证身份。",
                    success: function(t) {
                        t.confirm ? wx.navigateTo({
                            url: "/pages/index/authentication/authentication"
                        }) : console.log("弹框后点取消");
                    }
                })) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 800
                });
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