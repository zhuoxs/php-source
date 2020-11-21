var app = getApp();

Page({
    data: {
        navTile: "商品搜索",
        hisword: [],
        hotword: [],
        keyword: ""
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var o = wx.getStorageSync("hisword") || [];
        e.setData({
            hisword: o
        }), app.util.request({
            url: "entry/wxapp/gethotsearch",
            cachetime: "0",
            success: function(t) {
                e.setData({
                    hotword: t.data
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
    del: function(t) {
        var e = this, o = e.data.hisword;
        o = [], wx.showModal({
            title: "提示",
            content: "确定删除历史记录吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && (e.setData({
                    hisword: o
                }), wx.setStorageSync("hisword", o));
            }
        });
    },
    chooseKeyword: function(t) {
        var e = t.currentTarget.dataset.keyword;
        this.setData({
            keyword: e
        }), this.toResult();
    },
    toResult: function(t) {
        var e = e = this.data.keyword;
        if ("" == e) wx.showModal({
            title: "提示",
            showCancel: !1,
            content: "商品名称不得为空"
        }); else {
            var o = wx.getStorageSync("hisword") || [];
            -1 == o.indexOf(e) && (o.push(e), wx.setStorageSync("hisword", o)), app.get_user_info().then(function(t) {
                app.util.request({
                    url: "entry/wxapp/addsearchrecord",
                    cachetime: "0",
                    data: {
                        user_id: t.id,
                        keyword: e
                    },
                    success: function(t) {}
                });
            }), wx.navigateTo({
                url: "../result/result?keyword=" + e
            });
        }
    },
    onKeywordInput: function(t) {
        this.setData({
            keyword: t.detail.value
        });
    },
    keyBoardClick: function(t) {
        console.log("点击了这个事件");
    }
});