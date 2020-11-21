var a = new getApp();

Page({
    data: {
        plant: [],
        farmSetData: []
    },
    onLoad: function(t) {
        var e = this, n = a.siteInfo.uniacid, i = t.sid;
        wx.showLoading({
            title: "玩命加载中..."
        }), a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getSendDetail",
                control: "land",
                uniacid: n,
                sid: i
            },
            success: function(a) {
                e.setData({
                    plant: a.data.sendDetail
                }), wx.hideLoading();
            }
        }), a.util.setNavColor(n), e.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    }
});