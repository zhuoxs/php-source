var app = getApp();

Page({
    data: {},
    onLoad: function(e) {},
    formSubmit: function(e) {
        console.log(e);
        var a = wx.getStorageSync("auth_type"), t = e.detail.value.title, n = e.detail.value.valb, l = e.detail.value.valc, o = e.detail.value.change_date, i = e.detail.value.change_time, c = e.detail.value.allowance, u = e.detail.value.total, d = wx.getStorageSync("openid");
        wx.showModal({
            title: "提示",
            content: "确认信息填写完整？",
            success: function(e) {
                e.confirm ? (console.log("用户点击确定"), app.util.request({
                    url: "entry/wxapp/ReleaseCoupon",
                    cachetime: "30",
                    data: {
                        title: t,
                        valb: n,
                        valc: l,
                        change_date: o,
                        change_time: i,
                        allowance: c,
                        total: u,
                        openid: d,
                        auth_type: a
                    },
                    success: function(e) {
                        console.log(e), console.log({
                            title: t,
                            valb: n,
                            valc: l,
                            change_date: o,
                            change_time: i,
                            allowance: c,
                            total: u,
                            openid: d,
                            auth_type: a
                        }), 1 == e.data.data && (wx.showToast({
                            title: "发布成功！"
                        }), setTimeout(function() {
                            wx.navigateTo({
                                url: "../../manager/center/center"
                            });
                        }, 2e3));
                    }
                })) : e.cancel && console.log("用户点击取消");
            }
        });
    },
    bindDateChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            date: e.detail.value
        });
    },
    bindTimeChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            time: e.detail.value
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {}
});