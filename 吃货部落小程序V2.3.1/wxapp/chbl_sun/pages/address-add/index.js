var app = getApp();

Page({
    data: {
        region: [ "北京市", "北京市", "东城区" ],
        customItem: "全部",
        address: []
    },
    onLoad: function(e) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    bindRegionChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            region: e.detail.value
        });
    },
    bindCancel: function() {
        wx.navigateBack({});
    },
    bindSave: function(n) {
        console.log(n);
        var t = this.data.region, e = n.detail.value;
        "" != e.linkMan ? "" != e.mobile ? "" != e.stree ? (console.log(n), wx.getStorage({
            key: "openid",
            success: function(e) {
                console.log(e);
                var o = e.data;
                app.util.request({
                    url: "entry/wxapp/SetAddress",
                    cachetime: "0",
                    data: {
                        consignee: n.detail.value.linkMan,
                        phone: n.detail.value.mobile,
                        stree: n.detail.value.stree,
                        address: t,
                        uid: o
                    },
                    success: function(e) {
                        console.log(e), wx.showToast({
                            title: "添加成功！",
                            icon: "success",
                            duration: 2e3
                        });
                    }
                });
            }
        }), wx.navigateBack({})) : wx.showModal({
            title: "提示",
            content: "请输入详细地址！",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请输入收货人手机号码！",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请输入收货人！",
            showCancel: !1
        });
    },
    onReady: function() {},
    onShow: function() {
        wx.getStorage({
            key: "openid",
            success: function(e) {
                app.util.request({
                    url: "entry/wxapp/AddressList",
                    cachetime: "0",
                    data: {
                        uid: e.data
                    },
                    success: function(e) {
                        console.log(e);
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