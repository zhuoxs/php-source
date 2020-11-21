var WxParse = require("../wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        message: {},
        zan_num: 0,
        pinglun_num: 2,
        status: !1,
        pinglun: []
    },
    zan: function(t) {
        var a = parseInt(t.currentTarget.dataset.value), n = this.data.status;
        n ? a-- : a++, n = !n, this.setData({
            zan_num: a,
            status: n
        });
    },
    pageScrollToBottom: function() {
        wx.createSelectorQuery().select("#j_page").boundingClientRect(function(t) {
            wx.pageScrollTo({
                scrollTop: t.bottom
            });
        }).exec();
    },
    open_map_chonse: function() {
        var a = this;
        wx.chooseLocation({
            success: function(t) {
                a.setData({
                    loc_lon: t.longitude,
                    loc_lat: t.latitude,
                    accuracy: t.address
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    inputfocus: function() {
        this.setData({
            inputfocus: !0
        }), this.pageScrollToBottom();
    },
    textblur: function() {
        this.setData({
            inputfocus: !1
        });
    },
    textblur2: function(t) {
        var a = t.currentTarget.dataset.ida, n = this.data.pinglun;
        n[a].reply_focus = !1, this.setData({
            pinglun: n
        });
    },
    replay: function(t) {
        for (var a = t.currentTarget.dataset.index, n = this.data.pinglun, e = 0; e < n.length; e++) n[e].reply_focus = !1;
        n[a].reply_focus = !0, this.setData({
            pinglun: n
        });
    },
    onLoad: function(t) {
        var a = t.hz_id;
        console.log(a);
        var n = t.hz_name;
        wx.setNavigationBarTitle({
            title: n
        }), this.setData({
            hz_id: a
        });
    },
    onReady: function() {
        this.getFwlistnew();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getFwlistnew: function() {
        var a = this, t = a.data.hz_id;
        app.util.request({
            url: "entry/wxapp/Zzhzxq",
            data: {
                hz_id: t
            },
            success: function(t) {
                console.log(t), a.setData({
                    hzxq: t.data.data
                }), WxParse.wxParse("articles", "html", t.data.data.hz_count, a, 5);
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    onPullDownRefresh: function() {
        this.getFwlistnew();
        var t = wx.getStorageSync("title");
        wx.setNavigationBarTitle({
            title: t
        }), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
    }
});