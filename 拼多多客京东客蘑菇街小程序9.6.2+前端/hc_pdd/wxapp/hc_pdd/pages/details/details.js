var app = getApp();

Page({
    data: {
        imgUrls: [ "../../images/3f324f22fd3acff9407605642d12ebsa7.png", "../../images/3f324f22fd3acff9407605642d12ebsa7.png", "../../images/3f324f22fd3acff9407605642d12ebsa7.png" ],
        fen: 0,
        is_index: 0,
        myuser_id: 1,
        judge: !0
    },
    onLoad: function(a) {
        var t = this;
        console.log(getCurrentPages()[0].route, "从哪里进的啊"), "hc_pdd/pages/details/details" == getCurrentPages()[0].route ? t.setData({
            judge: !0
        }) : t.setData({
            judge: !1
        });
        var e = t.data.myuser_id, o = app.globalData.openId;
        console.log(o);
        var i = a.user_id, s = a.goods_id, d = a.itemUrl, n = a.skuId, r = a.parameter, u = a.materialUrl, l = app.globalData.couponUrl;
        if (console.log(a), t.setData({
            openId: o
        }), null != a.user_id) {
            e = app.globalData.user_id;
            if (null != o) {
                var p = t.data.fen;
                i = a.user_id;
                t.setData({
                    fen: 0,
                    user_id: i
                });
            } else {
                i = a.user_id, p = 1;
                t.setData({
                    fen: p,
                    user_id: i
                });
            }
            t.setData({
                myuser_id: e,
                openId: o
            }), console.log(a.user_id, "options.user_id", app.globalData.user_id, "app.globalData.user_id", "options.user_id != undefined");
        } else {
            i = app.globalData.user_id, console.log(a.user_id, "options.user_id", app.globalData.user_id, "app.globalData.user_id", "options.user_id == undefined");
            o = app.globalData.openId, e = app.globalData.user_id, p = t.data.fen;
            t.setData({
                user_id: i,
                fen: p,
                myuser_id: e,
                openId: o
            });
        }
        t.setData({
            goods_id: s,
            myuser_id: e,
            user_id: i,
            openId: o,
            fen: p,
            itemUrl: d,
            skuId: n,
            parameter: r,
            couponUrl: l,
            materialUrl: u
        }), console.log(t.data.goods_id, "传过来的goods_id", t.data.user_id, "传过来的uid"), app.util.request({
            url: "entry/wxapp/Goodsdetail",
            method: "POST",
            data: {
                goods_id_list: t.data.goods_id,
                user_id: t.data.user_id,
                itemUrl: t.data.itemUrl,
                skuId: t.data.skuId,
                parameter: t.data.parameter
            },
            success: function(a) {
                var e = a.data.data;
                t.setData({
                    goods: e
                }), console.log(e, "goods"), t.Shareurl();
            }
        }), t.Headcolor(), console.log(t.data.fen, "0是openid为空", t.data.user_id, "我自己的uid", t.data.itemUrl, "邀请人的uid", t.data.is_index, "is_index值");
    },
    Shareurl: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Shareurl",
            method: "POST",
            data: {
                goods_id: t.data.goods_id,
                user_id: t.data.user_id,
                itemId: t.data.goods.itemId,
                promId: t.data.goods.promid,
                skuId: t.data.skuId,
                materialUrl: t.data.materialUrl,
                couponUrl: t.data.couponUrl,
                parameter: t.data.parameter
            },
            success: function(a) {
                app.globalData.we_app_info = a.data.data.we_app_info;
                var e = a.data.data.we_app_info;
                t.setData({
                    we_app_info: e
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    submitInfotwo: function(a) {
        console.log("获取id");
        var e = a.detail.formId;
        console.log(e), console.log("获取formid结束"), this.setData({
            formid: e
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
    submitInfodetails: function(a) {
        this.submitInfotwo(a), this.fanhui();
    },
    submitInfomai: function(a) {
        this.submitInfotwo(a);
    },
    submitInfen: function(a) {
        this.fen();
    },
    Headcolor: function() {
        var l = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: l.data.user_id
            },
            success: function(a) {
                var e = a.data.data.config, t = e.client_id, o = e.client_secret, i = e.pid, s = e.enable, d = a.data.data.config.shenhe, n = a.data.data.config.is_index, r = a.data.data.is_daili, u = e.zzappid;
                l.setData({
                    config: e,
                    client_id: t,
                    client_secret: o,
                    pid: i,
                    enable: s,
                    shenhe: d,
                    is_index: n,
                    appid: u,
                    is_daili: r
                });
            }
        });
    },
    mai: function() {
        this.data.enable;
        wx.navigateToMiniProgram({
            appId: this.data.we_app_info.app_id,
            path: this.data.we_app_info.page_path,
            extraData: {
                user_id: this.data.user_id
            },
            envVersion: "release",
            success: function(a) {
                console.log("成功");
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    Goodszhuce: function() {
        app.util.request({
            url: "entry/wxapp/Goodszhuce",
            method: "POST",
            data: {
                user_id: this.data.user_id,
                myuser_id: this.data.myuser_id
            },
            success: function(a) {
                console.log(a);
            }
        });
    },
    onReady: function() {},
    fen: function() {
        var a = this, e = a.data.goods_id, t = (a.data.user_id, a.data.itemUrl), o = a.data.skuId, i = a.data.parameter, s = a.data.materialUrl;
        a.data.couponUrl;
        0 == i ? wx.navigateTo({
            url: "../share/share?goods_id=" + e + "&parameter=" + i + "&user_id=" + a.data.user_id
        }) : 1 == i ? wx.navigateTo({
            url: "../share/share?itemUrl=" + t + "&parameter=" + i + "&user_id=" + a.data.user_id
        }) : 2 == i && wx.navigateTo({
            url: "../share/share?skuId=" + o + "&parameter=" + i + "&materialUrl=" + s + "&user_id=" + a.data.user_id + "&couponUrl=" + a.data.couponUrl
        });
    },
    fanhui: function() {
        console.log(111), wx.reLaunch({
            url: "../index/index"
        });
    },
    fanhuia: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    getUserInfo: function(e) {
        var t = this;
        wx.getSetting({
            success: function(a) {
                a.authSetting["scope.userInfo"] ? (t.login(e), wx.showLoading({
                    title: "登录中..."
                })) : wx.showModal({
                    title: "提示",
                    content: "获取用户信息失败,需要授权才能继续使用！",
                    showCancel: !1,
                    confirmText: "授权",
                    success: function(a) {
                        a.confirm && wx.openSetting({
                            success: function(a) {
                                a.authSetting["scope.userInfo"] ? wx.showToast({
                                    title: "授权成功"
                                }) : wx.showToast({
                                    title: "未授权..."
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    register: function(l) {
        var p = this;
        wx.getStorage({
            key: "user",
            success: function(a) {
                console.log(a, "登录成功");
                var e, t = (e = a.data.detail).openid, o = e.session_key, i = (e = e.userInfo).country, s = e.province, d = e.city, n = e.gender, r = e.nickName, u = e.avatarUrl;
                app.util.request({
                    url: "entry/wxapp/Goodszhuce",
                    method: "post",
                    dataType: "json",
                    data: {
                        user_id: p.data.user_id,
                        openid: t,
                        session_key: o,
                        nickname: r,
                        gender: n,
                        country: i,
                        province: s,
                        city: d,
                        avatar: u
                    },
                    success: function(a) {
                        app.globalData.user_id = a.data.data, p.setData({
                            myuser_id: a.data.data
                        }), "function" == typeof l && l(a.data.data);
                    },
                    fail: function(a) {
                        console.log(a, "登录失败");
                    }
                });
            },
            fail: function(a) {}
        });
    },
    login: function(t) {
        var o = this;
        console.log("登录中"), app.globalData.userInfo ? ("function" == typeof cb && cb(app.globalData.userInfo), 
        console.log("登录中2")) : wx.login({
            success: function(a) {
                console.log(a);
                var e = t.detail;
                app.globalData.userInfo = e.userInfo, e.act = "autologin", e.code = a.code, app.util.request({
                    url: "entry/wxapp/getopenid",
                    method: "post",
                    dataType: "json",
                    data: e,
                    success: function(a) {
                        0 == a.data.errno && (e.session_key = a.data.data.session_key, e.openid = a.data.data.openid, 
                        app.globalData.userInfo = e, wx.setStorageSync("user", t), "function" == typeof cb && cb(app.globalData.userInfo), 
                        o.register(function(a) {}));
                    }
                });
            },
            fail: function(a) {
                console.log("获取失败");
            }
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(a) {
        var e = this;
        return "button" === a.from && console.log(a.target), {
            title: e.data.goods.goods_name,
            path: "hc_pdd/pages/details/details?goods_id=" + e.data.goods.goods_id + "&user_id=" + e.data.user_id + "&appid=" + e.data.we_app_info.app_id + "&path=" + e.data.guanggao_lujing + "&itemUrl=" + e.data.itemUrl,
            imageUrl: e.data.goods.goods_thumbnail_url,
            success: function(a) {},
            fail: function(a) {}
        };
    }
});