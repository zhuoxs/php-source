var app = getApp();

Page({
    data: {},
    onsubmit: function(o) {
        var n = this, t = o.detail.value, e = wx.getStorageSync("openid"), a = t.age, i = t.gender, s = t.miaoshu, c = t.yibao, u = t.idcad, l = t.tel, r = t.user, d = t.my_id;
        console.log(d), "" == t.user ? wx.showModal({
            content: "姓名不能为空"
        }) : "" == t.age ? wx.showModal({
            content: "请填写您的年龄"
        }) : "点击验证手机号" == t.tel ? (n.setData({
            title: "请填前往个人中心验证手机号",
            close: !0
        }), setTimeout(function() {
            n.setData({
                close: !1
            });
        }, 2e3)) : "" == t.idcad || t.idcad.length < 18 ? wx.showModal({
            content: "请正确填写您的身份证号"
        }) : "" !== t.my_id ? app.util.request({
            url: "entry/wxapp/Myinfors",
            data: {
                my_id: d,
                age: a,
                gender: i,
                miaoshu: s,
                tel: l,
                user: r,
                yibao: c,
                idcad: u,
                openid: e
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
                my_id: d,
                age: a,
                gender: i,
                miaoshu: s,
                tel: l,
                user: r,
                yibao: c,
                idcad: u,
                openid: e
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
        var n = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: n
        });
        var t = this, e = wx.getStorageSync("openid"), a = app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/Myinforsarray",
            data: {
                openid: e,
                uniacid: a
            },
            success: function(o) {
                console.log(o), t.setData({
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
    onShow: function() {
        this.getMyphone();
    },
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
    },
    tiaozhuan: function() {
        wx.navigateTo({
            url: "/hyb_yl/tel/tel",
            success: function(o) {},
            fail: function(o) {},
            complete: function(o) {}
        });
    }
});