var app = getApp(), eatvisit = require("../eatvisit.js");

Page({
    data: {
        curIndex: 0,
        nav: [ "火热进行中", "已抢完" ],
        page: [ 1, 1 ],
        is_modal_Hidden: !0,
        whichone: 1,
        open_eatvisit: [],
        goodslist: [],
        eattabname: [],
        isLogin: !1,
        bgLogo: "../../../../style/images/icon6.png"
    },
    onLoad: function(a) {
        var o = this;
        a = app.func.decodeScene(a), o.setData({
            options: a
        });
        var t = eatvisit.eattabname(app, o);
        o.setData({
            eattabname: t
        }), app.get_user_info().then(function(a) {
            console.log(a), o.setData({
                cardNum: a.tel ? a.tel : "***********",
                isLogin: !a.name,
                phoneGrant: !(a.tel || !a.name),
                user: a,
                openid: a.openid
            }), app.util.request({
                url: "entry/wxapp/GetPlatformInfo",
                data: {
                    m: "yzhyk_sun"
                },
                success: function(a) {
                    console.log(a), o.setData({
                        setting: a.data
                    }), wx.setNavigationBarColor({
                        frontColor: 1 == a.data.app_fcolor ? "#000000" : "#ffffff",
                        backgroundColor: a.data.app_bcolor ? a.data.app_bcolor : "#ffffff"
                    });
                }
            });
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                m: app.globalData.Plugin_yzhyk,
                type: 2
            },
            showLoading: !1,
            success: function(a) {
                var t = a.data, e = a.data.navname ? a.data.navname : "大转盘";
                wx.setNavigationBarTitle({
                    title: e
                }), 2 != t ? o.setData({
                    eatvisit_set: t
                }) : wx.showModal({
                    title: "提示消息",
                    content: "大转盘功能未开启",
                    showCancel: !1,
                    success: function(a) {
                        wx.redirectTo({
                            url: "/yzhyk_sun/pages/inedx/index"
                        });
                    }
                });
            }
        });
    },
    onReady: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/GetGoods",
            data: {
                m: app.globalData.Plugin_eatvisit,
                openid: s.data.openid
            },
            showLoading: !1,
            success: function(a) {
                if (console.log(a.data), 2 != a.data) {
                    var t = a.data.url, e = a.data.goodslist, o = a.data.status;
                    s.setData({
                        goodsstatus: o,
                        goodsurl: t,
                        goodslist: e
                    });
                } else s.setData({
                    goodslist: []
                });
            }
        });
    },
    onShow: function() {
        var a = this.data.options;
        a.d_user_id && app.distribution.distribution_parsent(app, a.d_user_id);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var s = this, n = s.data.page, i = s.data.curIndex, d = n[i];
        app.util.request({
            url: "entry/wxapp/GetGoods",
            data: {
                goodstype: index,
                page: d,
                m: app.globalData.Plugin_eatvisit,
                openid: s.data.openid
            },
            showLoading: !1,
            success: function(a) {
                if (console.log(a.data), 2 != a.data) {
                    var t = a.data.url, e = a.data.goodslist, o = a.data.status;
                    n[i] = d + 1, s.setData({
                        goodsstatus: o,
                        goodsurl: t,
                        goodslist: e,
                        pages: n
                    });
                } else s.setData({
                    goodslist: []
                });
            }
        });
    },
    onShareAppMessage: function() {
        return {
            path: "/pages/plugin/eatvisit/life/life?d_user_id=" + wx.getStorageSync("users").id
        };
    },
    navTap: function(a) {
        var s = this, t = parseInt(a.currentTarget.dataset.index);
        app.util.request({
            url: "entry/wxapp/GetGoods",
            data: {
                goodstype: t,
                m: app.globalData.Plugin_eatvisit,
                openid: s.data.openid
            },
            showLoading: !1,
            success: function(a) {
                if (console.log(a.data), 2 != a.data) {
                    var t = a.data.url, e = a.data.goodslist, o = a.data.status;
                    s.setData({
                        goodsstatus: o,
                        goodsurl: t,
                        goodslist: e,
                        pages: [ 1, 1 ]
                    });
                } else s.setData({
                    goodslist: [],
                    pages: [ 1, 1 ]
                });
            }
        }), this.setData({
            curIndex: t
        });
    },
    toLifeDet: function(a) {
        var t = this, e = a.currentTarget.dataset.id, o = a.currentTarget.dataset.vip;
        t.data.openid;
        if (1 == o) {
            if (console.log(t.data.user.end_time), null == t.data.user.is_member) return wx.showToast({
                title: "会员商品，请先购买会员",
                icon: "none",
                duration: 1e3
            }), !1;
            wx.navigateTo({
                url: "/pages/plugin/eatvisit/lifedet/lifedet?id=" + e
            });
        } else wx.navigateTo({
            url: "/pages/plugin/eatvisit/lifedet/lifedet?id=" + e
        });
    },
    bindGetUserInfo: function(a) {
        var t = this, e = a.detail.userInfo;
        app.util.request({
            url: "entry/wxapp/UpdateUser",
            cachetime: "0",
            data: {
                id: t.data.user.id,
                img: e.avatarUrl,
                name: e.nickName,
                gender: e.gender,
                m: "yzhyk_sun"
            },
            success: function(a) {
                app.get_user_info(!1).then(function(a) {
                    t.setData({
                        user: a,
                        isLogin: !1,
                        phoneGrant: !(a.tel || !a.name)
                    });
                });
            }
        }), console.log(a.detail.userInfo);
    }
});