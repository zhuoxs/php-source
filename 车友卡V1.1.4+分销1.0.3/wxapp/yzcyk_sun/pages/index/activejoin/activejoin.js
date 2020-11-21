Page({
    data: {
        navTile: "活动报名",
        goods: {},
        baby: {},
        totalPrice: "0"
    },
    onLoad: function(n) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
    },
    onReady: function() {},
    onShow: function() {
        var n = wx.getStorageSync("baby") || {};
        console.log(n), this.setData({
            baby: n
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    formSubmit: function(n) {
        var o = n.detail.value.uname, t = n.detail.value.phone, a = "", e = !0;
        "" == o ? a = "请输入您的姓名" : /^1(3|4|5|7|8)\d{9}$/.test(t) ? e = "false" : a = "请正确输入手机号码", 
        1 == e && wx.showModal({
            title: "提示",
            content: a,
            showCancel: !1
        });
    },
    toBaby: function(n) {
        wx.navigateTo({
            url: "../../user/baby/baby?isback=1"
        });
    }
});