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
            var t = this.data.dUserId, n = this, a = e.detail.userInfo;
            app.get_openid().then(function(e) {
                app.util.request({
                    url: "entry/wxapp/Login",
                    cachetime: "0",
                    data: {
                        openid: e,
                        img: a.avatarUrl,
                        name: a.nickName
                    },
                    success: function(e) {
                        console.log(e), app.get_user_info(!0).then(function(e) {
                            0 < t && app.distribution.distribution_parsent(app, t), n.setData({
                                isLogin: !1
                            }), wx.setStorageSync("user", e), n.triggerEvent("togetuserinfo", {});
                        });
                    }
                });
            }), console.log(e.detail.userInfo);
        }
    }
});