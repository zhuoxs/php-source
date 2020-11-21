Page({
    data: {
        list3: [ {
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
            name: "精美礼物礼品",
            num: 2,
            price: "167.00"
        } ]
    },
    onLoad: function(n) {
        var o = this;
        wx.getUserInfo({
            success: function(n) {
                o.setData({
                    userInfo: n.userInfo
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
    goSet: function() {
        wx.redirectTo({
            url: "../set/set"
        });
    },
    goOrdery: function() {
        wx.redirectTo({
            url: "../order/order"
        });
    },
    goSignout: function() {
        wx.reLaunch({
            url: "../../../ticket/ticketmy/ticketmy"
        });
    }
});