var app = getApp();

Page({
    data: {
        region: "",
        customItem: "全部",
        address: []
    },
    onLoad: function(e) {
        var o = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: n
            },
            success: function(e) {
                console.log("查看用户id"), console.log(e.data), o.setData({
                    yh_id: e.data.id
                }), wx.setStorageSync("user_id", e.data.id);
            }
        }), o.diyWinColor();
    },
    bindRegionChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            region: e.detail.value
        });
    },
    bindCancel: function() {
        wx.navigateBack({});
    },
    bindSave: function(e) {
        console.log("表单数据"), console.log(e.detail.value);
        var n = this.data.region;
        console.log(n);
        var a = e.detail.value;
        if ("" != a.linkMan) if ("" != a.mobile) if ("" != a.stree) {
            n = this.data.region;
            wx.getStorage({
                key: "key",
                success: function(e) {
                    console.log("这是什么歌"), console.log(e);
                    var o = wx.getStorageSync("user_id");
                    app.util.request({
                        url: "entry/wxapp/Address_mine",
                        cachetime: "0",
                        data: {
                            user_id: o,
                            linkMan: a.linkMan,
                            mobile: a.mobile,
                            stree: a.stree,
                            region: n
                        },
                        success: function(e) {
                            console.log("地址添加数据查看"), console.log(e), wx.navigateBack({});
                        }
                    });
                }
            }), console.log(e), wx.setStorage({
                key: "addNew",
                data: {
                    name: e.detail.value.linkMan,
                    mobile: e.detail.value.mobile,
                    stree: e.detail.value.stree
                }
            }), wx.navigateBack({});
        } else wx.showModal({
            title: "提示",
            content: "请输入详细地址！",
            showCancel: !1
        }); else wx.showModal({
            title: "提示",
            content: "请输入收货人手机号码！",
            showCancel: !1
        }); else wx.showModal({
            title: "提示",
            content: "请输入收货人！",
            showCancel: !1
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    diyWinColor: function(e) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "添加收货地址"
        });
    }
});