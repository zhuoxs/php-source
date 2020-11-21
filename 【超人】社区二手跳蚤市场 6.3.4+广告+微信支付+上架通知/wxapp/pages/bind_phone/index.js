var app = getApp();

Page({
    data: {
        showAuth: !1
    },
    onLoad: function() {},
    saveNumber: function(e) {
        var t = this;
        "getPhoneNumber:ok" == e.detail.errMsg ? (t.data.showAuth && t.setData({
            showAuth: !1
        }), wx.checkSession({
            success: function() {
                app.util.request({
                    url: "entry/wxapp/item",
                    cachetime: "0",
                    data: {
                        act: "get_phone_number",
                        encryptedData: e.detail.encryptedData,
                        iv: e.detail.iv,
                        m: "superman_hand2"
                    },
                    success: function(e) {
                        if (0 == e.data.errno) {
                            var t = e.data.data.purePhoneNumber, a = wx.getStorageSync("userInfo");
                            a.memberInfo.mobile = t, wx.setStorageSync("userInfo", a), wx.showToast({
                                title: "绑定成功"
                            }), setTimeout(function() {
                                wx.redirectTo({
                                    url: "../home/index"
                                });
                            }, 1500);
                        }
                    },
                    fail: function(e) {
                        console.log(e);
                    }
                });
            }
        })) : t.setData({
            showAuth: !0
        });
    }
});