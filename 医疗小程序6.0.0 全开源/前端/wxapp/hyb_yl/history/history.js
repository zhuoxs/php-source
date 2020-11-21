var app = getApp();

Page({
    data: {
        symArr: [ "", "", "" ]
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        });
        var a = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Getallhis",
            data: {
                openid: n
            },
            success: function(t) {
                console.log(t), a.setData({
                    getallhis: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    checkClick: function(t) {
        var e = t.currentTarget.dataset.id, a = t.currentTarget.dataset.data;
        wx.navigateTo({
            url: "/hyb_yl/check/check?id=" + e + "&title=" + a
        });
    },
    delClick: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.index, a = t.currentTarget.dataset.id, n = this.data.getallhis;
        n.splice(e, 1), app.util.request({
            url: "entry/wxapp/Delnotes",
            data: {
                sl_id: a
            },
            success: function(t) {
                console.log(t);
            }
        }), this.setData({
            getallhis: n
        });
    },
    allDel: function() {
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Delallnotes",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t);
            }
        }), this.setData({
            getallhis: []
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