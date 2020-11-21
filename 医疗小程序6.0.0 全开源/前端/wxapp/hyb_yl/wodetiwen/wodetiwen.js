var app = getApp();

Page({
    data: {
        tab: [ "已回答", "未回答" ],
        current: 0
    },
    tab: function(t) {
        var a = this, e = wx.getStorageSync("openid");
        1 == t.currentTarget.dataset.index ? (console.log("未回答"), app.util.request({
            url: "entry/wxapp/mywquestion",
            data: {
                openid: e
            },
            success: function(t) {
                console.log(t);
                var e = t.data.data;
                a.setData({
                    myquestionsss: e
                });
            }
        })) : (console.log("已经回答"), app.util.request({
            url: "entry/wxapp/mywyiquestion",
            data: {
                openid: e
            },
            success: function(t) {
                console.log(t);
                var e = t.data.data;
                a.setData({
                    myquestion: e
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
    daihuida: function(t) {
        0 == parseInt(t.currentTarget.dataset.yuedu) && wx.showToast({
            image: "../images/err.png",
            title: "等待医生回答"
        });
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        });
        var a = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/myquestion",
            data: {
                openid: n
            },
            success: function(t) {
                console.log(t);
                var e = t.data.data;
                a.setData({
                    myquestion: e
                });
            }
        });
    },
    previewImage: function(t) {
        for (var e = t.currentTarget.dataset.src, a = t.currentTarget.dataset.qid, n = this.data.myquestion, r = [], o = 0; o < n.length; o++) n[o].qid == a && (r = n[o].user_picture);
        wx.previewImage({
            current: e,
            urls: r
        });
    },
    previewImages: function(t) {
        for (var e = t.currentTarget.dataset.src, a = t.currentTarget.dataset.qid, n = this.data.myquestionsss, r = [], o = 0; o < n.length; o++) n[o].qid == a && (r = n[o].user_picture);
        wx.previewImage({
            current: e,
            urls: r
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    answerDetailClick: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.zid, a = t.currentTarget.dataset.openid, n = t.currentTarget.dataset.qid, r = t.currentTarget.dataset.fromuser;
        wx.navigateTo({
            url: "/hyb_yl/myda/myda?zid=" + e + "&user_openid=" + a + "&qid=" + n + "&fromuser=" + r
        });
    }
});