var app = getApp();

Page({
    data: {},
    onsubmit: function(o) {
        var n = this, e = o.detail.value, t = wx.getStorageSync("openid"), a = e.age, i = e.gender, s = e.miaoshu, c = e.yibao, u = e.idcad, l = e.tel, d = e.user, r = e.my_id;
        console.log(r), "" == e.user ? wx.showModal({
            content: "姓名不能为空"
        }) : "" == e.age ? wx.showModal({
            content: "请填写您的年龄"
        }) : "" == e.tel ? (n.setData({
            title: "请填前往个人中心验证手机号",
            close: !0
        }), setTimeout(function() {
            n.setData({
                close: !1
            });
        }, 2e3)) : "" == e.idcad || e.idcad.length < 18 ? wx.showModal({
            content: "请正确填写您的身份证号"
        }) : "" !== e.my_id ? app.util.request({
            url: "entry/wxapp/Myinfors",
            data: {
                my_id: r,
                age: a,
                gender: i,
                miaoshu: s,
                tel: l,
                user: d,
                yibao: c,
                idcad: u,
                openid: t
            },
            success: function(o) {
                console.log(o), wx.showToast({
                    title: "修改成功",
                    icon: "success",
                    duration: 800,
                    success: function() {
                        wx.reLaunch({
                            url: "../my/my"
                        });
                    }
                });
            },
            fail: function(o) {
                console.log(o);
            }
        }) : app.util.request({
            url: "entry/wxapp/Myinfors",
            data: {
                my_id: r,
                age: a,
                gender: i,
                miaoshu: s,
                tel: l,
                user: d,
                yibao: c,
                idcad: u,
                openid: t
            },
            success: function(o) {
                wx.showToast({
                    title: "添加成功",
                    icon: "success",
                    duration: 800,
                    success: function() {
                        wx.reLaunch({
                            url: "../my/my"
                        });
                    }
                });
            },
            fail: function(o) {
                console.log(o);
            }
        });
    },
    onLoad: function(o) {
        var n = this, e = wx.getStorageSync("openid"), t = app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/Myinforsarray",
            data: {
                openid: e,
                uniacid: t
            },
            success: function(o) {
                console.log(o), n.setData({
                    myinforsarray: o.data.data
                });
            },
            fail: function(o) {
                console.log(o);
            }
        });
    },
    onReady: function() {
        this.getMyphone();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getMyphone: function() {
        var n = this, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Myinforphone",
            data: {
                openid: o
            },
            success: function(o) {
                n.setData({
                    myinforphone: o.data.data.u_phone
                });
            },
            fail: function(o) {
                console.log(o);
            }
        });
    }
});