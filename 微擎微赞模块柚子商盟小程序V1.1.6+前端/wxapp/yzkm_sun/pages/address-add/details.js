Page({
    data: {
        addressData: [ {
            name: "余文乐",
            phone: 12345678901,
            address: "福建省 厦门市 集美区 杏林街道 我昂林湾营运中心1230号"
        }, {
            name: "段奕宏",
            phone: 12345678901,
            address: "福建省 厦门市 集美区 杏林街道 我昂林湾营运中心1230号"
        } ]
    },
    onLoad: function(n) {
        this.diyWinColor();
    },
    goAdd: function() {
        wx.navigateTo({
            url: "../address-add/index"
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    diyWinColor: function(n) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "添加收货地址"
        });
    }
});