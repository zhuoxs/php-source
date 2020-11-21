var app = getApp();

Page({
    data: {
        imgUrls: [ "../../images/3f324f22fd3acff9407605642d12ebsa7.png", "../../images/3f324f22fd3acff9407605642d12ebsa7.png", "../../images/3f324f22fd3acff9407605642d12ebsa7.png" ],
        fen: 0,
        is_index: 0,
        myuser_id: 1,
        judge: !0,
        sharein: !1,
        flag: !1,
        goods_id: 0,
        parameter: 0,
        order_num: 0,
        isTip: 0
    },
    onLoad: function(a) {
        var t = this;
        console.log(getCurrentPages()[0].route, "从哪里进的啊");
        var e = "hc_pdd/pages/details/details" == getCurrentPages()[0].route, o = t.data.myuser_id, s = app.globalData.openId;
        console.log(s), console.log(o);
        var i = app.globalData.user_id, d = a.goods_id, n = a.itemUrl, r = a.skuId, l = a.parameter, u = a.materialUrl, p = app.globalData.couponUrl;
        if (console.log(i), console.log(d), app.util.request({
            url: "entry/wxapp/isCollect",
            method: "GET",
            data: {
                user_id: i,
                goods_id: d,
                parameter: l,
                itemUrl: n,
                skuId: r
            },
            success: function(a) {
                var e = a.data.data;
                console.log(e), e && t.setData({
                    flag: e
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        }), a.sharein) {
            t.setData({
                sharein: !0
            });
        }
        if (console.log(t.data.sharein, "分享了没有----------------------------"), t.setData({
            openId: s
        }), null != a.user_id) {
            o = app.globalData.user_id;
            if (null != s) {
                var c = t.data.fen;
                i = a.user_id;
                t.setData({
                    fen: 0,
                    user_id: i
                });
            } else {
                i = a.user_id, c = 1;
                t.setData({
                    fen: c,
                    user_id: i
                });
            }
            t.setData({
                myuser_id: o,
                openId: s,
                goods_id: d,
                parameter: l
            }), console.log(a.user_id, "options.user_id", app.globalData.user_id, "app.globalData.user_id", "options.user_id != undefined");
        } else {
            console.log(2), i = app.globalData.user_id, console.log(a.user_id, "options.user_id", app.globalData.user_id, "app.globalData.user_id", "options.user_id == undefined");
            s = app.globalData.openId, o = app.globalData.user_id, c = t.data.fen;
            t.setData({
                user_id: i,
                fen: c,
                myuser_id: o,
                openId: s,
                goods_id: d,
                parameter: l
            });
        }
        t.setData({
            judge: e,
            goods_id: d,
            myuser_id: o,
            user_id: i,
            openId: s,
            fen: c,
            itemUrl: n,
            skuId: r,
            parameter: l,
            couponUrl: p,
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
                    goods: e,
                    order_num: e.sold_quantity
                }), console.log(e, "goods"), t.Shareurl();
            }
        }), t.Headcolor();
    },
    target: function() {},
    collect: function() {
        var e = this;
        e.scrollTip();
        var a = e.data.flag;
        e.setData({
            flag: !a
        }), app.util.request({
            url: "entry/wxapp/Collectpost",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                goods_id: e.data.goods_id,
                sold_quantity: e.data.order_num,
                goods_name: e.data.goods.goods_name,
                parameter: e.data.parameter,
                now_price: e.data.goods.now_price,
                coupon_discount: e.data.goods.coupon_discount,
                goods_thumbnail_url: e.data.goods.goods_thumbnail_url,
                itemUrl: e.data.itemUrl ? e.data.itemUrl : "",
                skuId: e.data.skuId ? e.data.skuId : "",
                couponUrl: e.data.couponUrl ? e.data.couponUrl : "",
                materialUrl: e.data.materialUrl ? e.data.materialUrl : "",
                act: e.data.flag ? "add" : "del"
            },
            success: function(a) {
                console.log(e.data.flag ? "收藏成功！" : "取消收藏");
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
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
    scrollTip: function() {
        var a = this;
        this.setData({
            isTip: 1
        });
        setTimeout(function() {
            a.setData({
                isTip: 0
            });
        }, 1800);
    },
    Headcolor: function() {
        var u = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: u.data.user_id
            },
            success: function(a) {
                var e = a.data.data.config, t = e.client_id, o = e.client_secret, s = e.pid, i = e.enable, d = a.data.data.config.shenhe, n = a.data.data.config.is_index, r = a.data.data.is_daili, l = e.zzappid;
                u.setData({
                    config: e,
                    client_id: t,
                    client_secret: o,
                    pid: s,
                    enable: i,
                    shenhe: d,
                    is_index: n,
                    appid: l,
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
        var a = this, e = a.data.goods_id, t = (a.data.user_id, a.data.itemUrl), o = a.data.skuId, s = a.data.parameter, i = a.data.materialUrl;
        a.data.couponUrl;
        0 == s ? wx.navigateTo({
            url: "../share/share?goods_id=" + e + "&parameter=" + s + "&user_id=" + a.data.user_id
        }) : 1 == s ? wx.navigateTo({
            url: "../share/share?itemUrl=" + t + "&parameter=" + s + "&user_id=" + a.data.user_id
        }) : 2 == s && wx.navigateTo({
            url: "../share/share?skuId=" + o + "&parameter=" + s + "&materialUrl=" + i + "&user_id=" + a.data.user_id + "&couponUrl=" + a.data.couponUrl
        });
    },
    fanhui: function() {
        console.log(111), wx.switchTab({
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
                }), setTimeout(function() {
                    wx.hideLoading();
                }, 2e3)) : wx.showModal({
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
    register: function(u) {
        var p = this;
        wx.getStorage({
            key: "user",
            success: function(a) {
                console.log(a, "登录成功");
                var e, t = (e = a.data.detail).openid, o = e.session_key, s = (e = e.userInfo).country, i = e.province, d = e.city, n = e.gender, r = e.nickName, l = e.avatarUrl;
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
                        country: s,
                        province: i,
                        city: d,
                        avatar: l
                    },
                    success: function(a) {
                        app.globalData.user_id = a.data.data, p.setData({
                            myuser_id: a.data.data
                        }), "function" == typeof u && u(a.data.data);
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
        var e = this, t = e.data.goods.goods_thumbnail_url, o = e.data.goods.goods_name, s = e.data.goods.goods_title, i = e.data.goods_id, d = e.data.itemUrl, n = e.data.skuId, r = e.data.parameter, l = e.data.materialUrl, u = e.data.couponUrl;
        if (e.setData({
            goods_src: t,
            goods_name: o,
            goods_title: s
        }), 0 == r) var p = "hc_pdd/pages/details/details?goods_id=" + i + "&parameter=" + r + "&user_id=" + app.globalData.user_id + "&sharein=sharein&sharein=sharein"; else if (1 == r) p = "hc_pdd/pages/details/details?itemUrl=" + d + "&parameter=" + r + "&user_id=" + app.globalData.user_id + "&sharein=sharein"; else if (2 == r) p = "hc_pdd/pages/details/details?skuId=" + n + "&parameter=" + r + "&materialUrl=" + l + "&couponUrl=" + u + "&user_id=" + app.globalData.user_id + "&sharein=sharein";
        return {
            title: e.data.goods_title,
            path: p,
            imageUrl: e.data.goods_src,
            success: function(a) {},
            fail: function(a) {}
        };
    }
});