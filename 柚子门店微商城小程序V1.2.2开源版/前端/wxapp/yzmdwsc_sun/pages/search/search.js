var app = getApp();

Page({
    data: {},
    onLoad: function(e) {
        var t = e.keyword;
        null != t && "" != t || (t = "");
        var o = wx.getStorageSync("url");
        console.log(o), console.log("前缀"), console.log(t), this.setData({
            keyword: t,
            url: o
        });
    },
    toSearch: function(e) {
        var t = e.detail.value;
        this.setData({
            keyword: t
        }), this.getGoods();
    },
    searchSubmit: function(e) {
        var t = e.detail.value.searchText;
        this.setData({
            keyword: t
        }), this.getGoods();
    },
    toGoodsdet: function(e) {
        var t = e.currentTarget.dataset.gid, o = e.currentTarget.dataset.lid, a = "";
        1 == o ? a = "/yzmdwsc_sun/pages/index/goodsDet/goodsDet?gid=" + t : 2 == o ? a = "/yzmdwsc_sun/pages/index/bookDet/bookDet?gid=" + t : 3 == o ? a = "/yzmdwsc_sun/pages/index/goodDet/goodDet?gid=" + t : 4 == o ? a = "/yzmdwsc_sun/pages/index/groupDet/groupDet?gid=" + t : 5 == o ? a = "/yzmdwsc_sun/pages/index/bargain/bargain?gid=" + t : 6 == o ? a = "/yzmdwsc_sun/pages/index/limitDet/limitDet?gid=" + t : 7 == o && (a = "/yzmdwsc_sun/pages/index/shareDet/shareDet?gid=" + t), 
        wx.navigateTo({
            url: a
        });
    },
    onReady: function() {},
    onShow: function() {
        this.getGoods();
    },
    getGoods: function() {
        var t = this, e = (wx.getStorageSync("url"), t.data.keyword);
        app.util.request({
            url: "entry/wxapp/getGoods",
            cachetime: "0",
            data: {
                key: e
            },
            success: function(e) {
                console.log(e.data), t.setData({
                    goodList: e.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});