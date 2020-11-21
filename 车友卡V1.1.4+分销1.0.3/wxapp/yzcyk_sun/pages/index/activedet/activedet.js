Page({
    data: {
        navTile: "活动详情",
        viptype: 1,
        isReceive: 0,
        active: {
            title: "这就是标题啊啊啊这就是标题啊啊啊这就是标题啊啊啊这就是标题啊啊啊",
            imgUrls: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152810500034.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152810500043.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152810500034.png" ],
            num: 199,
            starttime: "2018-05-05",
            endtime: "2018-06-05",
            yearlimit: 3,
            remark: "仅限万达店使用",
            notes: "<p>活动须知</p>",
            detail: "<p>这是详情</p>"
        },
        shop: {
            shopname: "湖里万达",
            address: "厦门市湖里区",
            phone: "1300000000",
            opentime: "09:00-21:00"
        }
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
    toDialog: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.shop.phone
        });
    },
    toReceive: function(t) {
        var e = this;
        0 == e.data.isReceive ? wx.showToast({
            title: "领取成功",
            duration: 1e3,
            success: function(t) {
                e.setData({
                    isReceive: 1
                });
            }
        }) : wx.showToast({
            title: "你已领取过啦~",
            icon: "none",
            duration: 1e3
        });
    },
    toIndex: function(t) {
        wx.navigateTo({
            url: "../index"
        });
    }
});