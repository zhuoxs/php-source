var _Page;

function _defineProperty(a, t, i) {
    return t in a ? Object.defineProperty(a, t, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = i, a;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        logs: [],
        fx_level: 0,
        is_daili: 0,
        huituannone: !0
    },
    onLoad: function() {
        var a = this, t = app.globalData.userInfo;
        a.setData({
            userInfo: t
        }), a.yemian(), a.Headcolor(), a.Diyname();
    },
    bills: function() {
        wx.navigateTo({
            url: "../bills/bills"
        });
    },
    xaubjnj: function() {
        this.setData({
            huituannone: !this.data.huituannone
        });
    },
    xiantime: function() {
        var a = this, t = app.globalData.xiantime;
        t++, (app.globalData.xiantime = t) < 3 && (a.setData({
            huituannone: !1
        }), setTimeout(function() {
            a.setData({
                huituannone: !0
            });
        }, 1e4));
    },
    submitInfotwo: function(a) {
        console.log("获取id");
        var t = a.detail.formId;
        console.log(t), console.log("获取formid结束"), this.setData({
            formid: t
        }), app.util.request({
            url: "entry/wxapp/formid",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                formid: this.data.formid
            },
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/Formid",
                    method: "POST",
                    data: {
                        user_id: app.globalData.user_id
                    },
                    success: function(a) {
                        console.log(a);
                    }
                });
            }
        });
    },
    submitIntixian: function(a) {
        this.submitInfotwo(a), this.tixian();
    },
    submitInorder: function(a) {
        this.submitInfotwo(a), this.order(a);
    },
    yemian: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Withdraw",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data;
                null == t.money && (t.money = 0), i.setData({
                    aica: t
                });
            }
        });
    },
    Redenvelopes: function() {
        this.Hongbaolist();
    },
    Hongbaolist: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Hongbaolist",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                hbmoney: e.data.hbmoney
            },
            success: function(a) {
                var t = a.data.data.list, i = a.data.data;
                e.setData({
                    goodsist: t,
                    goodsistcsa: i
                }), e.Myhongbao();
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    Myhongbao: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Myhongbao",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                wx.navigateTo({
                    url: "../redpacket/redpacket?goodsistcsa=" + t.data.goodsistcsa.hongbao.end_time + "&endtime=" + t.data.hb.endtime
                });
            }
        });
    },
    bindgetphonenumber: function(t) {
        console.log(t), "getPhoneNumber:fail:cancel to confirm login" == t.detail.errMsg ? (console.log(t.detail.errMsg), 
        wx.showModal({
            title: "提示",
            showCancel: !1,
            content: "未授权",
            success: function(a) {}
        })) : "getPhoneNumber:ok" == t.detail.errMsg && (this.inspector(), wx.login({
            success: function(a) {
                console.log(a.code), app.util.request({
                    url: "entry/wxapp/Getsessionkey",
                    data: {
                        code: a.code
                    },
                    success: function(a) {
                        a.data.session_key;
                        app.util.request({
                            url: "entry/wxapp/Usermobile",
                            data: {
                                encryptedData: t.detail.encryptedData,
                                iv: t.detail.iv,
                                code: a.code,
                                user_id: app.globalData.user_id,
                                session_key: a.data.data.session_key
                            },
                            success: function(a) {},
                            fail: function(a) {}
                        });
                    },
                    fail: function(a) {}
                });
            }
        }));
    },
    order: function(a) {
        var t = a.currentTarget.dataset.chshi;
        wx.navigateTo({
            url: "../goods/goods?chshi=" + t
        });
    },
    Headcolor: function() {
        var f = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.config.tixiant_color, i = a.data.data.config.tixianb_color, e = a.data.data.config.bg_pic, o = a.data.data.info.fx_level, n = a.data.data.is_daili, s = a.data.data.config, u = a.data.data.is_mobile, r = a.data.data.hongbao, d = r.is_open, c = a.data.data.hb, l = a.data.data.icon, p = a.data.data.config.kaiguan;
                f.setData({
                    tixianb_color: i,
                    tixiant_color: t,
                    bg_pic: e,
                    is_daili: n,
                    fx_level: o,
                    config: s,
                    is_mobile: u,
                    hongbao: r,
                    paper: d,
                    hb: c,
                    icon: l,
                    kaiguan: p
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    Diyname: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Diyname",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.config;
                i.setData({
                    nufiome: t
                });
            }
        });
    },
    she: function() {
        wx.navigateTo({
            url: "../shezhi/shezhi"
        });
    },
    lianwo: function() {
        wx.navigateTo({
            url: "../contactus/contactus"
        });
    },
    invite: function() {
        wx.navigateTo({
            url: "../invite/invite"
        });
    },
    teamdata: function() {
        wx.navigateTo({
            url: "../Teamdata/Teamdata"
        });
    },
    myding: function() {
        wx.navigateTo({
            url: "../goods/goods"
        });
    },
    yunyi: function() {
        wx.navigateTo({
            url: "../inspector/inspector"
        });
    },
    tixian: function() {
        wx.navigateTo({
            url: "../cash/cash?kenif=0"
        });
    },
    inspector: function() {
        wx.navigateTo({
            url: "../inspector/inspector"
        });
    }
}, "invite", function() {
    wx.navigateTo({
        url: "../invite/invite"
    });
}), _defineProperty(_Page, "Commissions", function() {
    wx.navigateTo({
        url: "../Commissions/Commissions"
    });
}), _defineProperty(_Page, "onShow", function() {
    this.Headcolor(), this.yemian();
    var a = app.globalData.userInfo;
    this.setData({
        userInfo: a
    }), this.Diyname();
}), _Page));