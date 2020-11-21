var app = getApp();

Page({
    data: {
        balance: 0
    },
    onLoad: function() {
        var t = this, a = wx.getStorageSync("loading_img");
        a ? t.setData({
            loadingImg: a
        }) : t.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), app.util.request({
            url: "entry/wxapp/finance",
            data: {
                m: "superman_hand2"
            },
            fail: function(a) {
                console.log(a), t.setData({
                    completed: !0
                }), wx.showModal({
                    title: "系统提示",
                    content: a.data.errmsg + "(" + a.data.errno + ")"
                });
            },
            success: function(a) {
                console.log(a), 0 == a.data.errno && t.setData({
                    balance: a.data.data.balance,
                    completed: !0
                });
            }
        });
    },
    toGetcash: function() {
        "0.00" != this.data.balance && wx.redirectTo({
            url: "../getcash/index"
        });
    }
});