var a = new getApp(), e = a.siteInfo.uniacid;

Page({
    data: {
        canPresented: "0.00",
        hadPresented: 0,
        dakuan: 0,
        farmSetData: wx.getStorageSync("kundian_farm_setData")
    },
    onLoad: function(t) {
        var n = this, i = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "distribution",
                op: "getUserSalePrice",
                uid: i,
                uniacid: e
            },
            success: function(a) {
                n.setData({
                    user: a.data.user
                });
            }
        });
    },
    intoWithdrawRecord: function(a) {
        wx.navigateTo({
            url: "../recode/index"
        });
    }
});