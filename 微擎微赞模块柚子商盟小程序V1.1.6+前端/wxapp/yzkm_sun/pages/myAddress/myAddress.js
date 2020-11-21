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
        var n = this, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: e
            },
            success: function(o) {
                console.log("查看用户id"), console.log(o), n.setData({
                    comment_xqy: o.data
                }), wx.setStorageSync("id", o.data.id);
            }
        });
        var t = wx.getStorageSync("id");
        app.util.request({
            url: "entry/wxapp/Address_myfabu",
            data: {
                id: t
            },
            success: function(o) {
                console.log("查看用户地址信息"), console.log(o), n.setData({
                    list: o.data
                });
            }
        }), this.diyWinColor();
    },
    goAdd: function(o) {
        wx.navigateTo({
            url: "../address-add/index"
        });
    },
    selAddress: function(o) {
        console.log("1111111111111111111"), console.log(o);
        var n = o.currentTarget.dataset.id, e = wx.getStorageSync("id");
        app.util.request({
            url: "entry/wxapp/Address_del",
            data: {
                del_id: n,
                yh_id: e
            },
            success: function(o) {
                console.log("是否设置成功"), console.log(o), wx.showModal({
                    title: "提示",
                    content: "设置成功",
                    showCancel: !1
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
    onShareAppMessage: function() {},
    diyWinColor: function(o) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "我的收货地址"
        });
    }
});