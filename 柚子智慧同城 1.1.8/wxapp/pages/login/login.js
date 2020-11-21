var t = getApp();

t.Base({
    data: {},
    onLoad: function(t) {
        var i = decodeURIComponent(t.id);
        i ? this.setData({
            backurl: i
        }) : this.setData({
            backurl: "/pages/home/home"
        });
    },
    onLoginTap: function(t) {
        "getUserInfo:fail auth deny" !== t.detail.errMsg && (this.setData({
            info: t.detail.userInfo
        }), this.wxLogin());
    },
    wxLogin: function() {
        var i = this;
        wx.login({
            success: function(n) {
                n.code ? t.api.apiWxGetopenid({
                    code: n.code
                }).then(function(t) {
                    wx.setStorageSync("session_key", t.data.session_key), i.getUserInfo(t.data.openid);
                }).catch(function(i) {
                    i.code, t.tips(i.msg);
                }) : t.tips("登录失败！" + n.errMsg);
            }
        });
    },
    checkDistributions: function(i) {
        var n = wx.getStorageSync("s_id");
        if (n && i && i.id) {
            var a = {
                user_id: i.id,
                parents_id: n
            };
            t.api.apiDistributionSetDistributionParents(a).then(function(t) {}).catch(function(t) {});
        }
    },
    getUserInfo: function(i) {
        var n = this, a = wx.getStorageSync("s_id"), e = {
            openid: i,
            nickname: this.data.info.nickName,
            avatar: this.data.info.avatarUrl,
            gender: this.data.info.gender,
            share_user_id: a
        };
        t.api.apiUserLogin(e).then(function(i) {
            wx.setStorageSync("yztcInfo", i.data), n.checkDistributions(i.data), t.reTo(n.data.backurl);
        }).catch(function(i) {
            i.code, t.tips(i.msg);
        });
    }
});