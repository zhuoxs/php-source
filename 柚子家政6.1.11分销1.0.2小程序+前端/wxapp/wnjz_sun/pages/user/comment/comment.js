var app = getApp();

Page({
    data: {
        imgsrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15216861845.png",
        startnum: [ "../../../../style/images/stars.png", "../../../../style/images/stars.png", "../../../../style/images/stars.png", "../../../../style/images/stars.png", "../../../../style/images/stars.png" ],
        uploadPic: [],
        scores: 0,
        flag: !0,
        i: 0,
        uimg: ""
    },
    onLoad: function(t) {
        this.getUrl();
        var a = t.oid;
        wx.setStorageSync("oid", a), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("oid"), e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/evaluateOrder",
            cachetime: "0",
            data: {
                oid: t,
                openid: e
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    goodData: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    stars: function(t) {
        for (var a = t.currentTarget.dataset.num, e = [], o = 0; o < a + 1; o++) e.unshift("../../../../style/images/starss.png");
        for (o = 0; o < 4 - a; o++) e.push("../../../../style/images/stars.png");
        this.setData({
            startnum: e,
            scores: a + 1
        });
    },
    uploadPic: function(t) {
        var e = this;
        wx.chooseImage({
            count: 4,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                var a = t.tempFilePaths;
                e.uploadimg(a), e.setData({
                    uploadPic: a
                });
            }
        });
    },
    formSubmit: function(t) {
        var a = this, e = !0, o = "", s = wx.getStorageSync("openid"), n = a.data.scores, i = a.data.img;
        console.log(t.detail.value.comment.length), n <= 0 ? o = "您还未评分" : (e = "false", 
        app.util.request({
            url: "entry/wxapp/SaveComtemt",
            data: {
                comment: t.detail.value.comment,
                scores: n,
                img: i,
                oid: a.data.goodData.oid,
                openid: s,
                gid: a.data.goodData.gid
            },
            success: function(t) {
                console.log(t.data), 1 == t.data ? wx.showToast({
                    title: "评价成功！",
                    icon: "success",
                    success: function(t) {
                        wx.navigateTo({
                            url: "../service/service"
                        });
                    }
                }) : wx.showToast({
                    title: "评价失败！",
                    icon: "none",
                    duration: 3e3
                });
            }
        })), 1 == e && wx.showModal({
            title: "提示",
            content: o,
            showCancel: !1
        });
    },
    uploadimg: function(a) {
        var e = this, t = a, o = a.length, s = e.data.i, n = app.util.url("entry/wxapp/Toupload") + "&m=wnjz_sun";
        wx.uploadFile({
            url: n,
            filePath: t[s],
            name: "file",
            success: function(t) {
                console.log(t.data), s++, e.data.uimg += t.data + ",", e.setData({
                    i: s,
                    uimg: e.data.uimg
                }), s < o ? e.uploadimg(a) : e.setData({
                    img: e.data.uimg
                });
            }
        });
    }
});