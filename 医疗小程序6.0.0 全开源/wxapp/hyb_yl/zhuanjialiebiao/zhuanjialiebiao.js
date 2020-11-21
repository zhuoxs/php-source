var app = getApp();

Page({
    data: {
        search: {
            searchValue: "",
            showClearBtn: !1
        },
        searchResult: [],
        zhuanjia: [ {
            src: "/yiliao/images/jiang.png"
        } ],
        hidden: !0
    },
    fenlei: function() {
        this.setData({
            hidden: !this.data.hidden
        });
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading();
        var t = this;
        app.util.request({
            url: "entry/wxapp/Zhuanjia",
            cachetime: "0",
            success: function(a) {
                t.setData({
                    zhuanjia: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }), setTimeout(function() {
            wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
        }, 1500);
    },
    onLoad: function(a) {
        var t = a.id, e = this;
        t ? app.util.request({
            url: "entry/wxapp/Kszhuanjia",
            data: {
                id: t
            },
            success: function(a) {
                console.log(a), e.setData({
                    zhuanjia: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }) : app.util.request({
            url: "entry/wxapp/Zhuanjia",
            success: function(a) {
                e.setData({
                    zhuanjia: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    bindFocus: function() {
        wx.navigateTo({
            url: "./serch/serch"
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    searchActiveChangeinput: function(a) {
        var t = a.detail.value;
        this.setData({
            "search.showClearBtn": "" != t,
            "search.searchValue": t
        });
    },
    searchActiveChangeclear: function(a) {
        this.setData({
            "search.showClearBtn": !1,
            "search.searchValue": ""
        });
    },
    searchSubmit: function() {
        var a = this.data.search.searchValue;
        if (a) {
            var i = this, o = getApp();
            wx.showLoading({
                title: "搜索中"
            }), setTimeout(function() {
                wx.hideLoading();
            }, 2e3), o.util.request({
                url: "entry/wxapp/Activity",
                data: {
                    keywords: a
                },
                method: "GET",
                success: function(a) {
                    console.log(a);
                    for (var t = a.data, e = t.length, n = 0; n < e; n++) t[n].team_avator = o.globalData.STATIC_SOURCE + t[n].team_avator;
                    i.setData({
                        searchResult: t,
                        "search.showClearBtn": !1
                    });
                },
                fail: function() {},
                complete: function() {
                    wx.hideToast();
                }
            });
        }
    }
});