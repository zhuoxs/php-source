var e = getApp();

Page({
    data: {
        session: "",
        logintag: "",
        key: ""
    },
    onLoad: function(e) {
        var o = this;
        try {
            var n = wx.getStorageSync("session");
            n && (console.log("session:", n), o.setData({
                session: n
            }));
        } catch (e) {}
    },
    onReady: function() {},
    onGotUserInfo: function(o) {
        var n = this;
        console.log(o);
        var t = n.data.session, a = o.detail.userInfo.avatarUrl, i = o.detail.userInfo.city, s = o.detail.userInfo.country, r = o.detail.userInfo.gender, c = o.detail.userInfo.nickName, l = o.detail.userInfo.province;
        wx.setStorage({
            key: "wx_headimg",
            data: a
        }), wx.request({
            url: e.data.url + "getweixininfo",
            data: {
                wx_headimg: a,
                city: i,
                country: s,
                gender: r,
                nickName: c,
                province: l,
                logintag: t
            },
            header: {
                "content-type": "application/x-www-form-urlencoded",
                Cookie: "PHPSESSID=" + t
            },
            success: function(e) {
                console.log("getweixininfo => 提交微信信息返回数据"), console.log(e), "0000" == e.data.retCode ? (console.log("延迟调用============"), 
                n.setData({
                    key: "0000"
                }), n.onLoad()) : console.log("微信登录失败");
            }
        });
    },
    getPhoneNumber: function(o) {
        var n = this.data.session;
        console.log(o), console.log(o.detail.errMsg), console.log(o.detail.iv), console.log(o.detail.encryptedData);
        var t = o.detail.encryptedData, a = o.detail.iv;
        wx.request({
            url: e.data.url + "getmember_mobile_decryption",
            data: {
                encryptedData: t,
                iv: a,
                logintag: n
            },
            header: {
                "content-type": "application/x-www-form-urlencoded",
                Cookie: "PHPSESSID=" + n
            },
            success: function(e) {
                console.log(e), "0000" == e.data.retCode ? wx.redirectTo({
                    url: "/pages/index/index"
                }) : wx.showToast({
                    title: e.data.retDesc,
                    icon: "loading",
                    duration: 2e3,
                    mask: !0
                });
            }
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});