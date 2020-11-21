var app = getApp();

Page({
    data: {
        id: "",
        url: "",
        images: ""
    },
    del: function(t) {
        var a = t.currentTarget.dataset.date;
        app.util.request({
            url: "entry/wxapp/Selecthxstate",
            data: {
                zy_id: a
            },
            success: function(t) {
                1 == t.data.data.zy_zhenzhuang ? wx.showModal({
                    title: "温馨提示",
                    content: "订单已核销无法取消预约"
                }) : app.util.request({
                    url: "entry/wxapp/Delzjyy",
                    data: {
                        zy_id: a
                    },
                    success: function(t) {
                        console.log(t), wx.showToast({
                            title: "取消成功",
                            icon: "success",
                            duration: 2e3,
                            success: function() {
                                setTimeout(function() {
                                    wx.navigateBack({
                                        url: "../wodeyuyue/wodeyuyue"
                                    });
                                }, 2e3);
                            }
                        });
                    }
                });
            }
        });
    },
    onLoad: function(t) {
        var a = this, e = t.id;
        t.money;
        app.util.request({
            url: "entry/wxapp/Cxhextype",
            data: {
                id: e
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    cxhextype: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Money",
            data: {
                id: e
            },
            success: function(t) {
                console.log(t), a.setData({
                    detail: t.data.data,
                    images: t.data.data.zy_sex
                });
            }
        });
    },
    getstorurl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Scurl",
            success: function(t) {
                console.log(t), a.setData({
                    url: t.data.data
                });
            }
        });
    },
    onReady: function() {
        this.getstorurl();
        var a = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                a.setData({
                    tell: t.data.data.yy_telphone
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    tel: function(t) {
        var a = this.data.tell;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    onShow: function(t) {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});