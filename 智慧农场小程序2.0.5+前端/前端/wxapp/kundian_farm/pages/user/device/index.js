var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        deviceData: [],
        farmSetData: wx.getStorageSync("kundian_farm_setData")
    },
    onLoad: function(e) {
        var n = this;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getYunDevice",
                control: "control",
                uniacid: t
            },
            success: function(a) {
                n.setData({
                    deviceData: a.data.deviceData
                });
            }
        });
    }
});