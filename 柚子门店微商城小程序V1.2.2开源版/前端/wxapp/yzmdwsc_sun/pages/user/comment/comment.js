var app = getApp();

Page({
    data: {
        imgsrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15216861845.png",
        startnum: [ "../../../../style/images/stars.png", "../../../../style/images/stars.png", "../../../../style/images/stars.png", "../../../../style/images/stars.png", "../../../../style/images/stars.png" ],
        uploadPic: [],
        scores: 0,
        flag: !0
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var a = wx.getStorageSync("url"), o = wx.getStorageSync("openid"), n = t.order_id, s = t.order_detail_id;
        e.setData({
            order_id: n,
            order_detail_id: s,
            url: a
        }), app.util.request({
            url: "entry/wxapp/getOrderDetailComment",
            cachetime: "0",
            data: {
                order_id: n,
                order_detail_id: s,
                uid: o
            },
            success: function(t) {
                e.setData({
                    detail: t.data
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
    onShareAppMessage: function() {},
    stars: function(t) {
        for (var e = t.currentTarget.dataset.num, a = [], o = 0; o < e + 1; o++) a.unshift("../../../../style/images/starss.png");
        for (o = 0; o < 4 - e; o++) a.push("../../../../style/images/stars.png");
        console.log(e), this.setData({
            startnum: a,
            scores: e + 1
        });
    },
    uploadPic: function(t) {
        wx.chooseImage({
            count: 4,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                var e = t.tempFilePaths;
                wx.uploadFile({
                    url: "/style/upload",
                    filePath: e[0],
                    name: "file",
                    formData: {
                        user: "test"
                    },
                    header: {
                        "Content-Type": "multipart/form-data"
                    },
                    success: function(t) {
                        var e = t.data;
                        console.log(e);
                    }
                });
            }
        });
    },
    formSubmit: function(t) {
        var e = this, a = !0, o = "", n = e.data.scores, s = e.data.order_id, r = e.data.order_detail_id, i = t.detail.value.comment, c = wx.getStorageSync("openid");
        console.log(t.detail.value.comment.length), n <= 0 ? o = "您还未评分" : t.detail.value.comment.length <= 10 ? o = "评论内容至少10个字哦~" : (a = "false", 
        app.util.request({
            url: "entry/wxapp/setComment",
            cachetime: "0",
            data: {
                uid: c,
                order_id: s,
                order_detail_id: r,
                stars: n,
                content: i
            },
            success: function(t) {
                wx.showToast({
                    title: "评价成功",
                    icon: "success",
                    duration: 2e3,
                    success: function() {},
                    complete: function() {
                        wx.navigateTo({
                            url: "../myorder/myorder"
                        });
                    }
                });
            }
        })), 1 == a && wx.showModal({
            title: "提示",
            content: o,
            showCancel: !1
        });
    }
});