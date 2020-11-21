var app = getApp();

Page({
    data: {
        tab: [ "已回答", "未回答" ],
        current: 0
    },
    tab: function(t) {
        var s = this, e = wx.getStorageSync("openid");
        1 == t.currentTarget.dataset.index && (console.log("未回答"), app.util.request({
            url: "entry/wxapp/mywquestion",
            data: {
                openid: e
            },
            success: function(t) {
                console.log(t);
                for (var e = t.data.data, a = 0; a < e.length; a++) {
                    var r = e[a];
                    r.user_picture = r.user_picture.split(";");
                }
                var n = r.user_picture;
                s.setData({
                    myquestionsss: e,
                    url: n
                });
            }
        })), this.setData({
            current: t.currentTarget.dataset.index
        });
    },
    questionsZan: function(t) {
        var e = this.data.wenda, a = t.currentTarget.dataset.index;
        1 == e[a].zan ? (wx.showToast({
            title: "点赞成功"
        }), e[a].zan = !1) : (wx.showToast({
            title: "已取消点赞"
        }), e[a].zan = !0), this.setData({
            wenda: e
        });
    },
    onLoad: function(t) {
        var s = this, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/myquestion",
            data: {
                openid: e
            },
            success: function(t) {
                console.log(t);
                for (var e = t.data.data, a = 0; a < e.length; a++) {
                    var r = e[a];
                    r.user_picture = r.user_picture.split(";");
                }
                var n = r.user_picture;
                s.setData({
                    myquestion: e,
                    url: n
                });
            }
        });
    },
    previewImage: function(t) {
        for (var e = t.currentTarget.dataset.src, a = t.currentTarget.dataset.qid, r = this.data.myquestion, n = [], s = 0; s < r.length; s++) r[s].qid == a && (n = r[s].user_picture);
        wx.previewImage({
            current: e,
            urls: n
        });
    },
    previewImages: function(t) {
        for (var e = t.currentTarget.dataset.src, a = t.currentTarget.dataset.qid, r = this.data.myquestionsss, n = [], s = 0; s < r.length; s++) r[s].qid == a && (n = r[s].user_picture);
        wx.previewImage({
            current: e,
            urls: n
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