var app = getApp();

Page({
    data: {
        goodInfo: "",
        indexx: 0,
        indexxx: 0,
        indexxx2: 0,
        is_modal_Hidden: !0,
        isLogin: !0,
        numvalue: 1,
        selectlist: [],
        selectsize: [],
        goStatus: "add",
        shoppingWindow: !1,
        lb_imgs: [],
        goods_price: "",
        red: ""
    },
    onLoad: function(e) {
        var t = this;
        t.wxauthSetting();
        var a = wx.getStorageSync("total") || 0;
        t.setData({
            red: Number(a)
        }), app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url2", e.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
        var o = e.id;
        t.setData({
            id: o
        });
        var n = e.goods_price;
        app.util.request({
            url: "entry/wxapp/GoodsDetails",
            data: {
                id: o
            },
            cachetime: 30,
            success: function(e) {
                console.log(e), t.setData({
                    goodInfo: e.data.data,
                    lb_imgs: e.data.data.lb_imgs,
                    goods_price: n,
                    selectsize: e.data.data.spec_value,
                    selectlist: e.data.data.spec_name,
                    indexxxx: e.data.data.spec_value[0],
                    selectsize2: e.data.data.spec_values,
                    selectlist2: e.data.data.spec_names,
                    indexxxx2: e.data.data.spec_values[0]
                });
            }
        });
    },
    choosesize: function(e) {
        var t = e.currentTarget.dataset.num, a = e.currentTarget.dataset.index;
        this.setData({
            indexxx: t,
            indexxxx: a
        });
    },
    choosesize2: function(e) {
        var t = e.currentTarget.dataset.num, a = e.currentTarget.dataset.index;
        this.setData({
            indexxx2: t,
            indexxxx2: a
        });
    },
    addnum: function(e) {
        var t = this.data.numvalue + 1;
        this.setData({
            numvalue: t
        });
    },
    subbnum: function(e) {
        var t = this.data.numvalue;
        1 < this.data.numvalue && (t = this.data.numvalue - 1), this.setData({
            numvalue: t
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    addShoppingCart: function(e) {
        var t = e.currentTarget.dataset.stat;
        console.log(t), this.setData({
            goStatus: t,
            shoppingWindow: !0
        });
    },
    closeShoppingWindow: function() {
        this.setData({
            shoppingWindow: !1
        });
    },
    goProductInfo: function(e) {
        var o, n = this, s = wx.getStorageSync("shop"), d = [], i = s.length;
        app.util.request({
            url: "entry/wxapp/CheckStatus",
            cachetime: 0,
            data: {
                gid: n.data.id
            },
            success: function(e) {
                if (console.log(n.data.goods_price), console.log(n.data.goodInfo.goods_price), void 0 === n.data.goods_price || "" == n.data.goods_price) var t = {
                    indexId: i + 1,
                    types: n.data.indexxxx + " , " + n.data.indexxxx2,
                    productNumber: n.data.numvalue,
                    picer: n.data.goodInfo.goods_price,
                    img: n.data.goodInfo.imgs,
                    red: n.data.red,
                    goods_id: n.data.goodInfo.id,
                    freight: n.data.goodInfo.freight,
                    goods_name: n.data.goodInfo.goods_name
                }; else t = {
                    indexId: i + 1,
                    types: n.data.indexxxx + " , " + n.data.indexxxx2,
                    productNumber: n.data.numvalue,
                    picer: n.data.goods_price,
                    img: n.data.goodInfo.imgs,
                    red: n.data.red,
                    goods_id: n.data.goodInfo.id,
                    freight: n.data.goodInfo.freight,
                    goods_name: n.data.goodInfo.goods_name
                };
                if (console.log(t), "add" == n.data.goStatus) {
                    if (console.log("购物车"), 0 == s.length) d.push(t), wx.setStorageSync("shop", d); else {
                        d = s;
                        for (var a = 0; a < i; a++) d[a].goods_id == n.data.goodInfo.id && (d[a].productNumber = d[a].productNumber + n.data.numvalue, 
                        o = !0);
                        1 == o || d.push(t), wx.setStorageSync("shop", d);
                    }
                    wx.showToast({
                        title: "添加成功",
                        icon: "success",
                        duration: 2e3
                    });
                } else wx.setStorageSync("shopnow", t), wx.navigateTo({
                    url: "/byjs_sun/pages/charge/chargeYesOrder/chargeYesOrder"
                });
                n.closeShoppingWindow();
            }
        });
    },
    onShareAppMessage: function(e) {
        var t = wx.getStorageSync("users").name;
        return "button" === e.from && console.log(e.target), {
            title: "用户 " + t + " 邀你购买装备 [" + this.data.goodInfo.goods_name + "]",
            path: "/byjs_sun/pages/charge/chargeProductInfo/chargeProductInfo?id=" + this.data.id,
            success: function(e) {},
            fail: function(e) {}
        };
    },
    goCar: function(e) {
        wx.setStorageSync("shopnow", ""), wx.navigateTo({
            url: "/byjs_sun/pages/charge/chargeShoppingCart/chargeShoppingCart"
        });
    },
    toIndex: function(e) {
        wx.redirectTo({
            url: "/byjs_sun/pages/product/index/index"
        });
    },
    wxauthSetting: function(e) {
        var s = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(e) {
                console.log("进入wx.getSetting 1"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(e) {
                        s.setData({
                            is_modal_Hidden: !0,
                            thumb: e.userInfo.avatarUrl,
                            nickname: e.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(e) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                }));
            },
            fail: function(e) {
                console.log("获取权限失败 1"), s.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(e) {
                console.log("进入wx-login");
                var t = e.code;
                wx.setStorageSync("code", t), wx.getSetting({
                    success: function(e) {
                        console.log("进入wx.getSetting"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(e) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: e.userInfo.avatarUrl,
                                    nickname: e.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo);
                                var a = e.userInfo.nickName, o = e.userInfo.avatarUrl, n = e.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: t
                                    },
                                    success: function(e) {
                                        console.log("进入获取openid"), console.log(e.data), wx.setStorageSync("key", e.data.session_key);
                                        var t = e.data.openid;
                                        wx.setStorageSync("userid", e.data.openid), wx.setStorage({
                                            key: "openid",
                                            data: t
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: t,
                                                img: o,
                                                name: a,
                                                gender: n
                                            },
                                            success: function(e) {
                                                console.log("进入地址login"), console.log(e.data), wx.setStorageSync("users", e.data), 
                                                wx.setStorageSync("uniacid", e.data.uniacid), s.setData({
                                                    usersinfo: e.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(e) {
                                console.log("进入 wx-getUserInfo 失败"), wx.showModal({
                                    title: "获取信息失败",
                                    content: "请允许授权以便为您提供给服务!",
                                    success: function(e) {
                                        s.setData({
                                            is_modal_Hidden: !1
                                        });
                                    }
                                });
                            }
                        })) : (console.log("scope.userInfo没有授权"), s.setData({
                            is_modal_Hidden: !1
                        }));
                    }
                });
            },
            fail: function() {
                wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务!!!",
                    success: function(e) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        this.wxauthSetting();
    }
});