var app = getApp();

Page({
    data: {},
    myform: function(n) {
        var a = n.detail.value.name, e = n.detail.value.phone;
        "" != a && "" != e ? app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            data: {
                op: "staff_apply",
                name: a,
                phone: e
            },
            success: function(n) {
                app.look.ok(n.data.message, function() {
                    wx.reLaunch({
                        url: "../index/index"
                    });
                }, 2e3);
            }
        }) : app.look.alert("信息不全");
    },
    onLoad: function(n) {
        1 == app.globalData.userInfo.admin1 && wx.showToast({
            title: "你已经是员工",
            icon: "none",
            duration: 2e3,
            success: function(n) {
                wx.reLaunch({
                    url: "../manageIndex/manageIndex"
                });
            }
        });
    },
    onReady: function() {
        this.setData({
            image: app.module_url + "resource/wxapp/manage/staff_apply.png"
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});