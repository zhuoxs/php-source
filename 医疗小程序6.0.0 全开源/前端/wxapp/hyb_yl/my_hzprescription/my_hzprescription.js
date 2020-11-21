var app = getApp();

Page({
    data: {},
    look_detail: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.data, o = t.currentTarget.dataset.id, e = t.currentTarget.dataset.state;
        wx.navigateTo({
            url: "/hyb_yl/patient_detailhuanzhe/patient_detailhuanzhe?cid=" + o + "&z_name=" + a + "&utype=1&state=" + e
        });
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
        var o = this, e = (wx.getStorageSync("openid"), t.userid);
        console.log(e), e && app.util.request({
            url: "entry/wxapp/Selecthztordocid",
            data: {
                userid: e
            },
            success: function(t) {
                console.log(t), o.setData({
                    infos: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), o.setData({
            userid: e
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = a.data.userid;
        app.util.request({
            url: "entry/wxapp/Selecthztordocid",
            data: {
                userid: t
            },
            success: function(t) {
                console.log(t), a.setData({
                    infos: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});