var app = getApp();

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
    onLoad: function(o) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    goAdd: function() {
        wx.navigateTo({
            url: "../address-add/index"
        });
    },
    selectDefalut: function(o) {
        console.log(o), app.util.request({
            url: "entry/wxapp/selectDefalut",
            cachetime: "0",
            data: {
                id: o.currentTarget.dataset.id
            },
            success: function(o) {
                console.log(o), 1 == o.data.data && wx.showToast({
                    title: "已设为默认地址！",
                    icon: "6",
                    duration: 2e3,
                    mask: !0,
                    success: function(o) {
                        wx.navigateBack({});
                    },
                    fail: function(o) {},
                    complete: function(o) {}
                });
            }
        });
    },
    delAddress: function(o) {
        var t = this;
        console.log(o);
        var e = o.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "确定删除该地址吗？",
            success: function(o) {
                o.confirm ? (console.log("用户点击确定"), app.util.request({
                    url: "entry/wxapp/delAddress",
                    cachetime: "0",
                    data: {
                        id: e
                    },
                    success: function(o) {
                        console.log(o), wx.showToast({
                            title: "删除成功！",
                            icon: "success",
                            duration: 2e3
                        }), t.onShow();
                    }
                })) : o.cancel && console.log("用户点击取消");
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(o) {
                app.util.request({
                    url: "entry/wxapp/AddressList",
                    cachetime: "0",
                    data: {
                        uid: o.data
                    },
                    success: function(o) {
                        console.log(o), t.setData({
                            addData: o.data.data
                        });
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});