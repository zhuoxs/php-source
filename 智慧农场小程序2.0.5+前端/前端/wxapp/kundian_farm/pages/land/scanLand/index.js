var a = new getApp(), e = a.siteInfo.uniacid;

Page({
    data: {
        mineLand: [],
        sendMine: [],
        lid: "",
        farmSetData: []
    },
    onLoad: function(n) {
        var t = this, d = n.lid;
        this.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        }), wx.showLoading({
            title: "玩命加载中..."
        }), a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getScanLand",
                control: "land",
                uniacid: e,
                lid: d
            },
            success: function(a) {
                t.setData({
                    mineLand: a.data.mineLand,
                    sendMine: a.data.landSeed,
                    user: a.data.user,
                    orderData: a.data.orderData
                }), wx.hideLoading();
            }
        });
    },
    goHome: function(a) {
        wx.reLaunch({
            url: "/kundian_farm/pages/HomePage/index/index"
        });
    }
});