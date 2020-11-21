Page({
    data: {
        navTile: "免费特权",
        operation: [ {
            title: "免费特权",
            src: "../../../../style/images/opear1.png",
            bind: "toPrivilege"
        }, {
            title: "亲子活动",
            src: "../../../../style/images/opear5.png",
            bind: "toParenting"
        }, {
            title: "教育培训",
            src: "../../../../style/images/opear4.png",
            bind: "toParenting"
        }, {
            title: "宝宝游泳",
            src: "../../../../style/images/opear2.png",
            bind: "toParenting"
        }, {
            title: "儿童摄影",
            src: "../../../../style/images/opear3.png",
            bind: "toParenting"
        } ],
        list: []
    },
    onLoad: function(e) {
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
    toFreePrivileges: function(e) {
        wx.navigateTo({
            url: "../freePrivileges/freePrivileges"
        });
    },
    toPrivilege: function(e) {
        wx.navigateTo({
            url: "/yzqzk_sun/pages/index/privilege/privilege"
        });
    },
    toParenting: function(e) {
        wx.navigateTo({
            url: "/yzqzk_sun/pages/index/parenting/parenting"
        });
    }
});