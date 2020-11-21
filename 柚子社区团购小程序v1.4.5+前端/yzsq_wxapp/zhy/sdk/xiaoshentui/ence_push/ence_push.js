var app = getApp();

Page({
    data: {
        jscode: "",
        jsonData: "",
        isShowtip: !1,
        tip: "",
        idDisb: !0
    },
    formSubmit: function(i) {
        var s = this;
        this.data.idDisb && (s.setData({
            idDisb: !1
        }), wx.getUserInfo({
            success: function(t) {
                var a = {
                    appkey: wx.getStorageSync("t_appkey"),
                    wx_code: s.data.jscode,
                    iv: t.iv,
                    jsondata: t.encryptedData,
                    uuid: wx.getStorageSync("t_uuid"),
                    formid: i.detail.formId
                };
                wx.showNavigationBarLoading(), wx.request({
                    url: "https://openapi.xiaoshentui.com/Main/action/Pushmsg/Pushmsg/form_id",
                    data: a,
                    method: "POST",
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(t) {
                        200 == t.data.code ? (s.setData({
                            idDisb: !0
                        }), s.setData({
                            isShowtip: !0,
                            tip: "获取成功，快去刷新页面测试推送吧！"
                        })) : s.setData({
                            isShowtip: !0,
                            idDisb: !0,
                            tip: t.data.message
                        }), setTimeout(function() {
                            s.setData({
                                tip: "",
                                isShowtip: !1
                            });
                        }, 1500), wx.hideNavigationBarLoading();
                    }
                });
            },
            fail: function() {
                s.setData({
                    idDisb: !0
                });
            }
        }));
    },
    onShow: function() {
        this.getJscode();
    },
    getJscode: function() {
        var a = this;
        wx.login({
            success: function(t) {
                t.code ? a.setData({
                    jscode: t.code
                }) : a.setData({
                    jscode: ""
                });
            }
        });
    }
});