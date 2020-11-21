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
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
        var n = this, o = t.id, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Fquestion",
            data: {
                pid: o
            },
            success: function(t) {
                console.log(t), n.setData({
                    pinfo: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Fquestionoption",
            data: {
                pid: o
            },
            success: function(t) {
                n.setData({
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
                openid: e,
                goods_id: o
            },
            success: function(t) {
                2 == t.data ? (console.log("已经关注"), n.setData({
                    toastHidden3: !0,
                    toastHidden4: !1,
                    toastHidden31: !0,
                    toastHidden41: !1
                })) : 1 == t.data && (console.log("关注"), n.setData({
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
    onShareAppMessage: function() {},
    doctinfo: function(t) {
        var a = t.currentTarget.dataset.p_id;
        app.util.request({
            url: "entry/wxapp/Ifcunz",
            data: {
                zid: a
            },
            success: function(t) {
                0 == t.data.data ? wx.showToast({
                    title: "当前医生休息中"
                }) : wx.navigateTo({
                    url: "/hyb_yl/zhuanjiazhuye/zhuanjiazhuye?id=" + a,
                    success: function(t) {},
                    fail: function(t) {},
                    complete: function(t) {}
                });
            }
        });
    }
});