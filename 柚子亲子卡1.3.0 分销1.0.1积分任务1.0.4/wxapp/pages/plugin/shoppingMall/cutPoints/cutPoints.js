var app = getApp();

Page({
    data: {
        invite_openid: "",
        invite: "",
        gid: "",
        cut: [],
        value: !1,
        moreMissions: !0
    },
    onLoad: function(t) {
        var a = t.d_user, e = t.gid;
        this.setData({
            invite: a,
            gid: e
        }), this.getGoodsDetail(), this.getUser();
    },
    getGoodsDetail: function() {
        var t = wx.getStorageSync("user").openid, a = this, e = this.data.gid, i = a.data.invite;
        app.util.request({
            url: "entry/wxapp/getGoodsDetail",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: i,
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
                openid: t
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
        var a = this, t = this.data.gid, e = this.data.invite, i = wx.getStorageSync("user").openid;
        console.log("商品id"), console.log(t), console.log("用户id"), console.log(e), app.util.request({
            url: "entry/wxapp/setBargain",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: i,
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
    }
});