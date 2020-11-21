var app = getApp();

Page({
    data: {
        guahao: 255,
        tab1: !0,
        tab2: !0,
        tab3: !0
    },
    tab1: function(t) {
        var a = this;
        console.log("预约");
        var o = wx.getStorageSync("openid");
        console.log(o), app.util.request({
            url: "entry/wxapp/Selectord",
            data: {
                openid: o
            },
            success: function(t) {
                console.log(t), a.setData({
                    myvt: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), this.setData({
            tab1: !this.data.tab1,
            tab2: !0,
            tab3: !0
        });
    },
    tab2: function() {
        var a = this;
        console.log("课堂");
        var t = wx.getStorageSync("openid");
        console.log(t), app.util.request({
            url: "entry/wxapp/Allordersyi",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t), a.setData({
                    dingdan: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), this.setData({
            tab1: !0,
            tab2: !this.data.tab2,
            tab3: !0
        });
    },
    tab3: function() {
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/myquestion",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t), a.setData({
                    myquestion: t.data.data
                });
            }
        }), this.setData({
            tab1: !0,
            tab2: !0,
            tab3: !this.data.tab3
        });
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
        var o = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Selectordsum",
            data: {
                openid: n
            },
            success: function(t) {
                console.log(t), o.setData({
                    money: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Allordersyisum",
            data: {
                openid: n
            },
            success: function(t) {
                console.log(t), o.setData({
                    dingdanmoney: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/myquestionsum",
            data: {
                openid: n
            },
            success: function(t) {
                console.log(t), o.setData({
                    myquestionmoney: t.data.data
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
    onShareAppMessage: function() {}
});