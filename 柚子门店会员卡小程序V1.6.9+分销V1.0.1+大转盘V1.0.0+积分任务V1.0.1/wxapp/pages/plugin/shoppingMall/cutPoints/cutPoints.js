var app = getApp();

Page({
    data: {
        invite_openid: "",
        invite: "",
        gid: "",
        cut: [],
        value: !1,
        moreMissions: !0,
        isLogin: !1,
        bgLogo: "../../../../style/images/icon6.png"
    },
    onLoad: function(t) {
        var a = this, e = t.d_user, o = t.gid;
        this.setData({
            invite: e,
            gid: o
        }), app.get_user_info().then(function(t) {
            console.log(t), a.setData({
                cardNum: t.tel ? t.tel : "***********",
                isLogin: !t.name,
                phoneGrant: !(t.tel || !t.name),
                user: t,
                openid: t.openid
            }), app.util.request({
                url: "entry/wxapp/GetPlatformInfo",
                data: {
                    m: "yzhyk_sun"
                },
                success: function(t) {
                    console.log(t), a.setData({
                        setting: t.data
                    });
                }
            }), a.getGoodsDetail(), a.getUser();
        });
    },
    getGoodsDetail: function() {
        var a = this, t = (wx.getStorageSync("user"), a.data.openid), e = this.data.gid, o = a.data.invite;
        app.util.request({
            url: "entry/wxapp/getGoodsDetail",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: o,
                bargain_openid: t,
                id: e
            },
            showLoading: !1,
            success: function(t) {
                console.log("商品信息"), console.log(t.data.data), 1 == t.data.data.cut ? a.setData({
                    cut: 1
                }) : 3 == t.data.data.cut ? a.setData({
                    cut: 3
                }) : a.setData({
                    cut: 2
                }), a.setData({
                    list: t.data.data,
                    imgroot: t.data.other.img_root
                });
            }
        });
    },
    getUser: function() {
        var a = this, t = (wx.getStorageSync("user"), a.data.invite);
        app.util.request({
            url: "entry/wxapp/getUser",
            data: {
                openid: t,
                m: app.globalData.Plugin_scoretask
            },
            showLoading: !1,
            success: function(t) {
                console.log("用户"), console.log(t.data), a.setData({
                    use: t.data
                });
            }
        });
    },
    onReady: function() {},
    cut: function() {
        this.setBargain();
    },
    cut3: function(t) {
        var a = this.data.gid;
        wx.redirectTo({
            url: "/pages/plugin/shoppingMall/details/details?id=" + a
        });
    },
    setBargain: function() {
        var a = this, t = this.data.gid, e = this.data.invite, o = (wx.getStorageSync("user"), 
        a.data.openid);
        console.log("商品id"), console.log(t), console.log("用户id"), console.log(e), app.util.request({
            url: "entry/wxapp/setBargain",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: o,
                invite_openid: e,
                gid: t
            },
            showLoading: !1,
            success: function(t) {
                console.log("砍价了吗"), console.log(t.data.code), a.getGoodsDetail(), a.setData({
                    cut: t.data.code
                });
            }
        });
    },
    want: function() {
        wx.redirectTo({
            url: "../integrationMall/integrationMall"
        });
    },
    click: function() {
        this.setData({
            value: !0,
            moreMissions: !1
        });
    },
    bindGetUserInfo: function(t) {
        var a = this, e = t.detail.userInfo;
        app.util.request({
            url: "entry/wxapp/UpdateUser",
            cachetime: "0",
            data: {
                id: a.data.user.id,
                img: e.avatarUrl,
                name: e.nickName,
                gender: e.gender,
                m: "yzhyk_sun"
            },
            success: function(t) {
                app.get_user_info(!1).then(function(t) {
                    a.setData({
                        user: t,
                        isLogin: !1,
                        phoneGrant: !(t.tel || !t.name)
                    });
                });
            }
        }), console.log(t.detail.userInfo);
    }
});