var app = getApp();

Component({
    properties: {
        dUserId: {
            type: Number,
            value: 0,
            observer: function(e, t) {}
        }
    },
    data: {
        modalMsg: "获取你的公开信息(昵称、头像等)",
        isLogin: !1
    },
    attached: function() {
        var e = wx.getStorageSync("user") || [];
        this.setData({
            isLogin: null == e.name
        });
    },
    methods: {
        getUserInfo: function(e) {
            var a = this.data.dUserId, o = this, s = e.detail.userInfo;
            app.get_openid().then(function(e) {
                var t = wx.getStorageSync("share_type"), n = wx.getStorageSync("d_user");
                2 == t && e != n && "" != n ? (console.log("邀请好友任务"), app.util.request({
                    url: "entry/wxapp/setInvitefriends",
                    data: {
                        m: app.globalData.Plugin_scoretask,
                        openid: e,
                        invite_openid: n
                    },
                    showLoading: !1,
                    success: function(e) {}
                })) : console.log("没有邀请新用户"), app.util.request({
                    url: "entry/wxapp/Login",
                    cachetime: "0",
                    data: {
                        openid: e,
                        img: s.avatarUrl,
                        name: s.nickName
                    },
                    success: function(e) {
                        console.log(e), app.get_user_info(!0).then(function(e) {
                            0 < a && app.distribution.distribution_parsent(app, a), o.setData({
                                isLogin: !1
                            }), wx.setStorageSync("user", e), o.triggerEvent("togetuserinfo", {});
                        });
                    }
                });
            }), console.log(e.detail.userInfo);
        }
    }
});