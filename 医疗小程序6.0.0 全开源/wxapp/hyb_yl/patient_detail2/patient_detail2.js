var app = getApp();

Page({
    data: {
        status: null,
        hyb_ylmz: 3,
        mess: {
            name: "花花",
            age: "18",
            gender: "女",
            tel: "12345689",
            money: "15.00",
            order_number: "FJDSFK1215454",
            doctor: "叠加方块",
            ky_yibao: ""
        },
        btn: "提交",
        disabled: !1
    },
    formSubmit: function(o) {
        console.log(o.detail.formId), console.log(o.detail.value);
        var a = o.detail.value, t = a.dmoney, e = a.rg, n = this.data.id, i = a.zid, s = a.ky_openid, c = a.docid;
        console.log(n), "" == o.detail.value.rg ? wx.showToast({
            title: "请填写处方",
            image: "/hyb_ylmz/resource/images/error.png"
        }) : "提交" == this.data.btn ? app.util.request({
            url: "entry/wxapp/Saverecipe",
            data: {
                userid: n,
                dmoney: t,
                content: e,
                docid: i,
                orderarr: c,
                openid: s
            },
            success: function(o) {
                console.log(o), wx.showToast({
                    title: "提交成功",
                    icon: "success",
                    duration: 2e3,
                    success: function() {
                        setTimeout(function() {
                            wx.redirectTo({
                                url: "/hyb_ylmz/personal_page/my_prescription/my_prescription?id=" + i
                            });
                        }, 2e3);
                    }
                });
            },
            fail: function(o) {
                console.log(o);
            }
        }) : (wx.showToast({
            title: "已确认"
        }), wx.navigateBack({
            delta: 1
        }));
    },
    sure_btn: function(t) {
        var e = this.data.id, n = (t.detail.formId, wx.getStorageSync("openid"));
        console.log(e), app.util.request({
            url: "entry/wxapp/Savedoctorack",
            data: {
                ky_id: e,
                doctorack: 1
            },
            success: function(o) {
                console.log(o);
                var a = t.detail.formId;
                console.log(t.detail.formId), app.util.request({
                    url: "entry/wxapp/AccessToken",
                    data: {
                        ky_id: e,
                        openid: n,
                        formId: a
                    },
                    success: function(o) {
                        console.log(o), wx.showToast({
                            title: "已通知用户"
                        });
                    },
                    fail: function(o) {
                        console.log(o);
                    }
                }), wx.showToast({
                    title: "已确认"
                }), wx.navigateBack({
                    delta: 1
                });
            },
            fail: function(o) {
                console.log(o);
            }
        });
    },
    onLoad: function(o) {
        var a = this, t = o.id, e = o.ky_yibao;
        app.util.request({
            url: "entry/wxapp/Saveinfo",
            data: {
                ky_id: t
            },
            success: function(o) {
                console.log(o.data.data.ky_yibao), a.setData({
                    infos: o.data.data,
                    ky_docmoney: o.data.data.ky_docmoney,
                    ky_yibao: o.data.data.ky_yibao
                });
            },
            fail: function(o) {
                console.log(o);
            }
        }), a.setData({
            status: o.status,
            id: t,
            ky_yibao: e
        }), app.util.request({
            url: "entry/wxapp/kyyibaoorder",
            data: {
                ky_yibao: e
            },
            success: function(o) {
                console.log(o), a.setData({
                    userkyyibao: o.data.data
                });
            },
            fail: function(o) {
                console.log(o);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});