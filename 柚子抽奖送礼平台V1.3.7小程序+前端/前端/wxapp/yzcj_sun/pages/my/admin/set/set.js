var Page = require("../../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        switchShow: !0
    },
    onLoad: function(o) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    shangeSwich: function() {
        var o = this.data.switchShow;
        o = !o, this.setData({
            switchShow: o
        });
    },
    goOrdery: function() {
        wx.redirectTo({
            url: "../order/order"
        });
    },
    goWork: function() {
        wx.redirectTo({
            url: "../work/work"
        });
    }
});