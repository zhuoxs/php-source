var app = getApp();

Page({
    data: {
        zan: !0,
        guanzhu: 0
    },
    questionsZan: function() {
        1 == this.data.zan ? (wx.showToast({
            title: "关注成功"
        }), this.setData({
            zan: !1
        })) : (wx.showToast({
            title: "关注点赞"
        }), this.setData({
            zan: !0
        }));
    },
    guanzhu: function() {
        0 == this.data.guanzhu ? (wx.showToast({
            title: "关注成功"
        }), this.setData({
            guanzhu: 1
        })) : (wx.showToast({
            title: "取消关注"
        }), this.setData({
            guanzhu: 0
        }));
    },
    onLoad: function(t) {
        var a = this, n = t.id, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Fquestion",
            data: {
                pid: n
            },
            success: function(t) {
                console.log(t), a.setData({
                    pinfo: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Fquestionoption",
            data: {
                pid: n
            },
            success: function(t) {
                a.setData({
                    fquestionoption: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/CheckCollect",
            headers: {
                "Content-Type": "application/json"
            },
            data: {
                openid: o,
                goods_id: n
            },
            success: function(t) {
                2 == t.data ? (console.log("已经关注"), a.setData({
                    toastHidden3: !0,
                    toastHidden4: !1,
                    toastHidden31: !0,
                    toastHidden41: !1
                })) : 1 == t.data && (console.log("关注"), a.setData({
                    toastHidden3: !1,
                    toastHidden4: !0,
                    toastHidden31: !1,
                    toastHidden41: !0
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