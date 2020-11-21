Page({
    data: {
        navTile: "商品搜索",
        hisword: [],
        hotword: []
    },
    onLoad: function(o) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
        var t = wx.getStorageSync("hisword") || [];
        this.setData({
            hisword: t
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    formSubmit: function(o) {
        var t = o.detail.value.keyword;
        this.searchKeyWord(t);
    },
    searchKeyWord: function(o) {
        if ("" == o) wx.showModal({
            title: "提示",
            showCancel: !1,
            content: "商品名称不得为空"
        }); else {
            var t = wx.getStorageSync("hisword") || [];
            t.push(o), wx.setStorageSync("hisword", t), wx.navigateTo({
                url: "../result/result?keyword=" + o
            });
        }
    },
    toSearch: function(o) {
        var t = o.currentTarget.dataset.keyword;
        console.log(t), wx.navigateTo({
            url: "../result/result?keyword=" + t
        });
    },
    searchConfirmTap: function(o) {
        var t = o.detail.value;
        this.searchKeyWord(t);
    },
    del: function(o) {
        var t = this, e = t.data.hisword;
        e = [], wx.showModal({
            title: "提示",
            content: "确定删除历史记录吗",
            showCancel: !0,
            success: function(o) {
                o.confirm && (t.setData({
                    hisword: e
                }), wx.setStorageSync("hisword", {}));
            }
        });
    }
});