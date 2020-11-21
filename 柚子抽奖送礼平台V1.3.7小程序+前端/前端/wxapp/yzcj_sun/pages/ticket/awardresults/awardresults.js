var Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        btn: !1,
        txt: !1
    },
    onLoad: function(t) {
        var a = this;
        setTimeout(function() {
            console.log(11), a.setData({
                txt: !0
            });
        }, 1500);
        a = this;
        var e = wx.getStorageSync("user_info");
        a.setData({
            userInfo: e
        });
    },
    open: function() {
        this.data.btn;
        this.setData({
            btn: !1
        });
    }
});