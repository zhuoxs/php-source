var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {},
    onPullDownRefresh: function() {},
    onLoad: function() {
        var t = this, e = setInterval(function() {
            1 == t.data.dddd && wx.redirectTo({
                url: "../sponsortwo/sponsortwo",
                success: function(t) {
                    clearInterval(e);
                },
                fail: function(t) {},
                complete: function(t) {}
            });
        }, 1e3);
    },
    onShow: function() {
        var e = this, t = wx.getStorageSync("users").openid;
        e.setData({
            openid: t
        }), app.util.request({
            url: "entry/wxapp/GetSponsor",
            success: function(t) {
                console.log(t), e.setData({
                    pro: t.data
                });
            }
        });
    },
    formSubmit: function() {
        var e = this, t = e.data.phone, a = e.data.wx, n = e.data.sname, o = e.data.openid;
        console.log(o), 0 < e.data.length1 && 0 < e.data.length2 && 0 < e.data.length3 && app.util.request({
            url: "entry/wxapp/AddSponsor",
            data: {
                phone: t,
                wx: a,
                sname: n,
                openid: o
            },
            success: function(t) {
                1 == t.data && e.setData({
                    dddd: !0
                });
            }
        });
    },
    bindKeyInput1: function(t) {
        this.setData({
            phone: t.detail.value,
            length1: t.detail.value.length
        });
    },
    bindKeyInput2: function(t) {
        this.setData({
            wx: t.detail.value,
            length2: t.detail.value.length
        });
    },
    bindKeyInput3: function(t) {
        this.setData({
            sname: t.detail.value,
            length3: t.detail.value.length
        });
    }
});