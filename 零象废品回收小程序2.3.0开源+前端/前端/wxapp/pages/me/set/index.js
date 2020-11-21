var e = getApp();

Page({
    data: {
        phone: ""
    },
    onLoad: function(t) {
        var a = this;
        e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.detail",
                uid: wx.getStorageSync("uid")
            },
            success: function(e) {
                a.setData({
                    detail: e.data.data
                });
            }
        });
    },
    getPhoneNumber: function(t) {
        var a = this;
        e.util.getUserInfo(function(e) {}), t.detail.iv && e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "home.userphone",
                iv: t.detail.iv,
                encryptedData: t.detail.encryptedData
            },
            success: function(e) {
                a.setData({
                    phone: e.data.data
                }), console.log(e);
            }
        });
    },
    formSubmit: function(t) {
        var a = this, i = {
            phone: a.data.phone ? a.data.phone : t.detail.value.phone,
            name: t.detail.value.name,
            id: t.detail.value.id,
            uid: wx.getStorageSync("uid"),
            m: "ox_reclaim",
            r: "me.editDetail"
        };
        e.util.request({
            url: "entry/wxapp/Api",
            data: i,
            method: "POST",
            success: function(e) {
                wx.showModal({
                    title: "操作提示",
                    content: "保存成功",
                    success: function(e) {
                        e.confirm && wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            },
            fail: function(e) {
                wx.showModal({
                    title: "系统提示",
                    content: e.data.message ? e.data.message : "错误",
                    showCancel: !1,
                    success: function(e) {
                        e.confirm && backApp();
                    }
                });
            }
        });
    }
});