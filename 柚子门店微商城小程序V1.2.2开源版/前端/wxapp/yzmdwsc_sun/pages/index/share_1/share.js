Page({
    data: {
        navTile: "分享",
        classify: [ "综合", "最新", "推荐" ],
        curIndex: 0,
        shareList: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
            bgSrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162021.png",
            shareprice: "0.15"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
            bgSrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162021.png",
            shareprice: "0.15"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
            bgSrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162021.png",
            shareprice: "0.15"
        } ]
    },
    onLoad: function(t) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    navChange: function(t) {
        var n = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: n
        });
    },
    toSharedet: function(t) {
        wx.navigateTo({
            url: "../shareDet/shareDet"
        });
    }
});