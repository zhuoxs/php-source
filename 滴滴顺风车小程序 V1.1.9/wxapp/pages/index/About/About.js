var n = getApp();

Page({
    data: {
        logintag: "",
        info: ""
    },
    onLoad: function(n) {
        var o = this;
        try {
            var t = wx.getStorageSync("session");
            t && (console.log("logintag:", t), o.setData({
                logintag: t
            }));
        } catch (n) {}
        o.notes();
    },
    notes: function(o) {
        var t = this, e = t.data.logintag;
        wx.request({
            url: n.data.url + "get_car_owner_notes",
            data: {
                logintag: e
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(n) {
                if (console.log("get_car_owner_notes => 车主须知页面详情信息数据"), console.log(n), "0000" == n.data.retCode) {
                    var o = n.data.info;
                    0 == o.nclass || 1 == o.nclass ? wx.setNavigationBarTitle({
                        title: "乘客须知"
                    }) : wx.setNavigationBarTitle({
                        title: "车主须知"
                    }), t.setData({
                        info: o
                    });
                } else wx.showToast({
                    title: n.data.retDesc,
                    icon: "none",
                    duration: 800
                });
            }
        });
    },
    phone: function(n) {
        var o = n.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: o,
            success: function(n) {
                console.log(n);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});