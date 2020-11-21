var app = getApp();

Page({
    data: {
        nav: [ "/hyb_yl/images/hua1.png", "/hyb_yl/images/hua2.png", "/hyb_yl/images/hua1.png", "/hyb_yl/images/hua2.png" ]
    },
    questionsZan: function(t) {
        var a = this.data.wenda, e = t.currentTarget.dataset.index;
        1 == a[e].zan ? (wx.showToast({
            title: "点赞成功"
        }), a[e].zan = !1) : (wx.showToast({
            title: "已取消点赞"
        }), a[e].zan = !0), this.setData({
            wenda: a
        });
    },
    navbar: function(t) {
        var o = this, a = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Questionimgsingle",
            data: {
                id: a
            },
            success: function(t) {
                console.log(t);
                for (var a = t.data.data, e = 0; e < a.length; e++) {
                    var n = a[e];
                    n.user_picture = n.user_picture.split(";");
                }
                o.setData({
                    qusetiontype: a
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    onLoad: function(t) {
        wx.getStorageSync("userInfo");
        var s = this;
        app.util.request({
            url: "entry/wxapp/Qusetiontype",
            success: function(t) {
                for (var a = t.data.data, e = 0; e < a.length; e++) {
                    var n = a[e];
                    n.user_picture = n.user_picture.split(";");
                }
                s.setData({
                    qusetiontype: a
                });
                var o = s.data.qusetiontype;
                for (e = 0; e < o.length; e++) {
                    var i = o[e].user_picture;
                    s.setData({
                        imgs: i
                    });
                }
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Scurl",
            success: function(t) {
                console.log(t.data.data), s.setData({
                    scurl: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Questionimg",
            success: function(t) {
                s.setData({
                    questionimg: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    previewImage: function(t) {
        for (var a = t.currentTarget.dataset.src, e = t.currentTarget.dataset.qid, n = this.data.qusetiontype, o = [], i = 0; i < n.length; i++) n[i].qid == e && (o = n[i].user_picture);
        wx.previewImage({
            current: a,
            urls: o
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), setTimeout(function() {
            wx.stopPullDownRefresh(), wx.hideNavigationBarLoading();
        }, 1e3);
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});