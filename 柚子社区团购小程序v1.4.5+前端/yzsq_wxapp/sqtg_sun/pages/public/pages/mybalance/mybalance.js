var app = getApp();

Page({
    data: {
        reload: !1
    },
    onLoad: function(a) {
        this.onLoadData();
    },
    onShow: function() {
        this.data.reload && (this.onLoadData(), this.setData({
            reload: !1
        }));
    },
    onLoadData: function() {
        var e = this, a = wx.getStorageSync("userInfo");
        a ? app.ajax({
            url: "Crecharge|recharge",
            data: {
                user_id: a.id
            },
            success: function(a) {
                e.setData({
                    info: a.data,
                    show: !0
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(a) {
                if (a.confirm) {
                    var e = encodeURIComponent("/sqtg_sun/pages/public/pages/mybalance/mybalance");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + e);
                } else a.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    }
});