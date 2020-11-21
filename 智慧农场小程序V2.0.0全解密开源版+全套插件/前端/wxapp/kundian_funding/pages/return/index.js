var n = new getApp().util.url("entry/wxapp/funding") + "m=kundian_farm_plugin_funding";

Page({
    data: {
        info: []
    },
    onLoad: function(t) {
        var a = this;
        wx.request({
            url: n,
            data: {
                op: "getReturnInfo",
                control: "project"
            },
            success: function(n) {
                a.setData({
                    info: n.data.returnInfo
                });
            }
        });
    }
});