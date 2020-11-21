var t = new getApp().util.url("entry/wxapp/funding") + "m=kundian_farm_plugin_funding";

Page({
    data: {
        progressList: []
    },
    onLoad: function(r) {
        var s = this, a = r.pid;
        wx.request({
            url: t,
            data: {
                op: "getProgress",
                control: "project",
                pid: a
            },
            success: function(t) {
                s.setData({
                    progressList: t.data.progress
                });
            }
        });
    }
});