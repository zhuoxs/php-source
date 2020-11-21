var _Page;

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        logs: [],
        fx_level: 0,
        is_daili: 0,
        huituannone: !0,
        perid: 0
    },
    onLoad: function() {
        var t = app.globalData.userInfo;
        this.setData({
            userInfo: t
        });
    },
    toCollect: function() {
        wx.navigateTo({
            url: "../Collection/Collection"
        });
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
        var t = this, a = app.globalData.xiantime;
        a++, (app.globalData.xiantime = a) < 3 && (t.setData({
            huituannone: !1
        }), setTimeout(function() {
            t.setData({
                huituannone: !0
            });
        }, 1e4));
    },
    submitInfotwo: function(t) {
        var a = t.detail.formId;
        this.setData({
            formid: a
        }), app.util.request({
            url: "entry/wxapp/formid",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                formid: this.data.formid
            },
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Formid",
                    method: "POST",
                    data: {
                        user_id: app.globalData.user_id
                    },
                    success: function(t) {}
                });
            }
        });
    },
    toLogin: function() {
        wx.navigateTo({
            url: "../login/login"
        });
    },
    getUserInfo: function(a) {
        var e = this;
        wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] ? e.login(a) : wx.showModal({
                    title: "提示",
                    content: "获取用户信息失败,需要授权才能继续使用！",
                    showCancel: !1,
                    confirmText: "授权",
                    success: function(t) {
                        t.confirm && wx.openSetting({
                            success: function(t) {
                                t.authSetting["scope.userInfo"] ? wx.showToast({
                                    title: "授权成功"
                                }) : wx.showToast({
                                    title: "未授权..."
                                });
                            }
                        });
                    }
                });
            },
            fail: function(t) {}
        });
    }
}, "getUserInfo", function(a) {
    var e = this;
    wx.getSetting({
        success: function(t) {
            t.authSetting["scope.userInfo"] ? e.login(a) : wx.showModal({
                title: "提示",
                content: "获取用户信息失败,需要授权才能继续使用！",
                showCancel: !1,
                confirmText: "授权",
                success: function(t) {
                    t.confirm && wx.openSetting({
                        success: function(t) {
                            t.authSetting["scope.userInfo"] ? wx.showToast({
                                title: "授权成功"
                            }) : wx.showToast({
                                title: "未授权..."
                            });
                        }
                    });
                }
            });
        },
        fail: function(t) {}
    });
}), _defineProperty(_Page, "submitIntixian", function(t) {
    this.submitInfotwo(t), this.tixian();
}), _defineProperty(_Page, "submitInorder", function(t) {
    this.submitInfotwo(t), this.order(t);
}), _defineProperty(_Page, "yemian", function() {
    var i = this;
    return new Promise(function(n, a) {
        app.util.request({
            url: "entry/wxapp/Withdraw",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(t) {
                var a = t.data.data, e = a.tongji;
                null == a.money && (a.money = 0), i.setData({
                    aica: a,
                    tongji: e
                }), n(t.data.message);
            },
            fail: function(t) {
                a(t.data.message);
            }
        });
    });
}), _defineProperty(_Page, "Redenvelopes", function() {
    this.Hongbaolist();
}), _defineProperty(_Page, "Hongbaolist", function() {
    var n = this;
    app.util.request({
        url: "entry/wxapp/Hongbaolist",
        method: "POST",
        data: {
            user_id: app.globalData.user_id,
            hbmoney: n.data.hbmoney
        },
        success: function(t) {
            var a = t.data.data.list, e = t.data.data;
            n.setData({
                goodsist: a,
                goodsistcsa: e
            }), n.Myhongbao();
        },
        fail: function(t) {}
    });
}), _defineProperty(_Page, "Myhongbao", function() {
    var a = this;
    app.util.request({
        url: "entry/wxapp/Myhongbao",
        method: "POST",
        data: {
            user_id: app.globalData.user_id
        },
        success: function(t) {
            wx.navigateTo({
                url: "../redpacket/redpacket?goodsistcsa=" + a.data.goodsistcsa.hongbao.end_time + "&endtime=" + a.data.hb.endtime
            });
        }
    });
}), _defineProperty(_Page, "bindgetphonenumber", function(a) {
    "getPhoneNumber:fail:cancel to confirm login" == a.detail.errMsg ? wx.showModal({
        title: "提示",
        showCancel: !1,
        content: "未授权",
        success: function(t) {}
    }) : "getPhoneNumber:ok" == a.detail.errMsg && (this.inspector(), wx.login({
        success: function(t) {
            app.util.request({
                url: "entry/wxapp/Getsessionkey",
                data: {
                    code: t.code
                },
                success: function(t) {
                    t.data.session_key;
                    app.util.request({
                        url: "entry/wxapp/Usermobile",
                        data: {
                            encryptedData: a.detail.encryptedData,
                            iv: a.detail.iv,
                            code: t.code,
                            user_id: app.globalData.user_id,
                            session_key: t.data.data.session_key
                        },
                        success: function(t) {},
                        fail: function(t) {}
                    });
                },
                fail: function(t) {}
            });
        }
    }));
}), _defineProperty(_Page, "order", function(t) {
    var a = t.currentTarget.dataset.chshi;
    wx.navigateTo({
        url: "../goods/goods?chshi=" + a
    });
}), _defineProperty(_Page, "Headcolor", function() {
    var p = this;
    return new Promise(function(g, a) {
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(t) {
                var a = t.data.data.config.tixiant_color, e = t.data.data.config.tixianb_color, n = t.data.data.config.bg_pic, i = t.data.data.info.fx_level, o = t.data.data.is_daili, s = t.data.data.config, r = t.data.data.is_mobile, u = t.data.data.hongbao, c = u.is_open, d = t.data.data.hb, l = t.data.data.icon, f = t.data.data.config.kaiguan;
                p.setData({
                    tixianb_color: e,
                    tixiant_color: a,
                    bg_pic: n,
                    is_daili: o,
                    fx_level: i,
                    config: s,
                    is_mobile: r,
                    hongbao: u,
                    paper: c,
                    hb: d,
                    icon: l,
                    kaiguan: f
                }), g(t.data.message);
            },
            fail: function(t) {
                a(t.data.message);
            }
        });
    });
}), _defineProperty(_Page, "Diyname", function() {
    var i = this;
    return new Promise(function(e, n) {
        wx.getStorage({
            key: "userInfo",
            success: function(t) {
                var a = t.data;
                i.setData({
                    userInfo: a
                }), app.util.request({
                    url: "entry/wxapp/Diyname",
                    method: "POST",
                    data: {
                        user_id: a.user_id
                    },
                    success: function(t) {
                        var a = t.data.data.config;
                        i.setData({
                            nufiome: a
                        }), e(t.data.message);
                    },
                    fail: function(t) {
                        n(t.data.message);
                    }
                });
            }
        });
    });
}), _defineProperty(_Page, "tapyun", function(t) {
    var a = Number(t.currentTarget.dataset.index);
    this.setData({
        perid: a,
        tongji: this.data.tongji
    });
}), _defineProperty(_Page, "she", function() {
    wx.navigateTo({
        url: "../shezhi/shezhi"
    });
}), _defineProperty(_Page, "lianwo", function() {
    wx.navigateTo({
        url: "../contactus/contactus"
    });
}), _defineProperty(_Page, "invite", function() {
    0 < this.data.is_daili ? wx.navigateTo({
        url: "../invite/invite"
    }) : wx.showModal({
        title: "提示",
        content: "请先升级为" + this.data.nufiome.daili,
        showCancel: !1,
        success: function(t) {
            t.confirm && wx.navigateTo({
                url: "../inspector/inspector"
            });
        }
    });
}), _defineProperty(_Page, "teamdata", function() {
    wx.navigateTo({
        url: "../Teamdata/Teamdata"
    });
}), _defineProperty(_Page, "myding", function() {
    wx.navigateTo({
        url: "../goods/goods"
    });
}), _defineProperty(_Page, "yunyi", function() {
    wx.navigateTo({
        url: "../inspector/inspector"
    });
}), _defineProperty(_Page, "tixian", function() {
    wx.navigateTo({
        url: "../cash/cash?kenif=0"
    });
}), _defineProperty(_Page, "inspector", function() {
    app.util.request({
        url: "entry/wxapp/Diyname",
        method: "POST",
        data: {
            user_id: app.globalData.user_id
        },
        success: function(t) {
            app.globalData.nufiome = t.data.data.config, app.globalData.role = t.data.data.role, 
            wx.navigateTo({
                url: "../inspector/inspector"
            });
        }
    });
}), _defineProperty(_Page, "Commissions", function() {
    this.data.userInfo ? wx.navigateTo({
        url: "../Commissions/Commissions"
    }) : wx.showModal({
        title: "提示",
        content: "请先去登录",
        showCancel: !1
    });
}), _defineProperty(_Page, "onShow", function() {
    Promise.all([ this.Headcolor(), this.yemian(), this.Diyname() ]).then(function(t) {}, function(t) {});
}), _Page));