var app = getApp();

Page({
    data: {
        hideShopPopup: !1,
        is_modal_Hidden: !0,
        shopprice: "",
        buyNumber: 1,
        guige: "还未选择",
        banners: [ "http://oydmq0ond.bkt.clouddn.com/shangpinxiangqing.png" ]
    },
    onLoad: function(o) {
        var e = this;
        e.wxauthSetting(), wx.setStorageSync("iid", o.id), console.log("获取当前商品Id"), console.log(o.id), 
        e.diyWinColor(), app.util.request({
            url: "entry/wxapp/Url",
            success: function(o) {
                console.log("页面加载请求"), console.log(o), wx.getStorageSync("url", o.data), e.setData({
                    url: o.data
                });
            }
        });
    },
    labelItemTap: function(o) {
        console.log("规格"), console.log(o), console.log(o.currentTarget.dataset.index);
        o.currentTarget.dataset.index;
        this.setData({
            guige: o.currentTarget.dataset.item,
            currentIndex: o.currentTarget.dataset.index
        });
    },
    numJianTap: function(o) {
        console.log("减少"), console.log(o);
        var e = this.data.buyNumber;
        1 < e && (e--, this.setData({
            buyNumber: e
        }));
    },
    numJiaTap: function(o) {
        var e = this, t = o.currentTarget.dataset.inventory;
        console.log("增加"), console.log(o);
        var n = e.data.buyNumber;
        t <= ++n ? e.setData({
            buyNumber: t
        }) : e.setData({
            buyNumber: n
        });
    },
    gohome: function() {
        wx.reLaunch({
            url: "../index/index"
        });
    },
    buyNow: function(o) {
        var e = this;
        console.log("立即购买"), console.log(o);
        var t = e.data.buyNumber, n = e.data.guige, a = wx.getStorageSync("iid"), s = wx.getStorageSync("openid");
        return console.log(t), console.log(n), console.log(a), console.log(s), wx.setStorageSync("buyNumber", t), 
        "" == n ? (wx.showToast({
            title: "规格不能为空",
            icon: "none"
        }), !1) : 0 == t ? (wx.showToast({
            title: "购买数量不能为空",
            icon: "none"
        }), !1) : 0 == o.currentTarget.dataset.inventory ? (wx.showToast({
            title: "库存不足",
            icon: "none"
        }), !1) : void wx.navigateTo({
            url: "../to-pay-order/to-pay-order?iid=" + a + "&&openid=" + s + "&&guige=" + n + "&&buyNumber=" + t + "&&shopprice=" + e.data.shopprice + "&&freight=" + e.data.sp_xx.freight
        });
    },
    toBuy: function(o) {
        var e = o.currentTarget.dataset.statu;
        this.util(e), console.log(o);
    },
    close: function(o) {
        var e = o.currentTarget.dataset.statu;
        this.util(e);
    },
    util: function(o) {
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        if ((this.animation = e).opacity(0).height(0).step(), this.setData({
            animationData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height("630rpx").step(), this.setData({
                animationData: e
            }), "close" == o && this.setData({
                hideShopPopup: !1
            });
        }.bind(this), 200), "open" == o) {
            var t = this;
            t.setData({
                hideShopPopup: !0
            });
            var n = wx.getStorageSync("iid");
            console.log("获取当前商品Id"), console.log(n), app.util.request({
                url: "entry/wxapp/Doods_details",
                data: {
                    iid: n
                },
                success: function(o) {
                    console.log("商品数据请求"), console.log(o), t.setData({
                        sp_guige: o.data
                    });
                }
            });
        }
    },
    onReady: function() {},
    onShow: function() {
        var e = this, o = wx.getStorageSync("iid");
        console.log("获取当前商品Id"), console.log(o), app.util.request({
            url: "entry/wxapp/Doods_details",
            data: {
                iid: o
            },
            success: function(o) {
                console.log("商品信息详情"), console.log(o), e.setData({
                    sp_xx: o.data,
                    shopprice: o.data.shopprice
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(o) {
        return console.log(o), "button" === o.from && console.log(o.target), {
            title: wx.getStorageSync("users").name + "邀你购买[" + this.data.sp_xx.gname + "]",
            path: "/yzkm_sun/pages/goodsDetails/goodsDetails?id=" + this.data.sp_xx.gid,
            success: function(o) {},
            fail: function(o) {}
        };
    },
    diyWinColor: function(o) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "商品详情"
        });
    },
    wxauthSetting: function(o) {
        var s = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(o) {
                console.log("进入wx.getSetting 1"), console.log(o), o.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(o) {
                        s.setData({
                            is_modal_Hidden: !0,
                            thumb: o.userInfo.avatarUrl,
                            nickname: o.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), s.setData({
                    is_modal_Hidden: !1
                }));
            },
            fail: function(o) {
                console.log("获取权限失败 1"), s.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(o) {
                console.log("进入wx-login");
                var e = o.code;
                wx.setStorageSync("code", e), wx.getSetting({
                    success: function(o) {
                        console.log("进入wx.getSetting"), console.log(o), o.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(o) {
                                console.log(o), s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: o.userInfo.avatarUrl,
                                    nickname: o.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(o.userInfo), wx.setStorageSync("user_info", o.userInfo);
                                var t = o.userInfo.nickName, n = o.userInfo.avatarUrl, a = o.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: e
                                    },
                                    success: function(o) {
                                        console.log("进入获取openid"), console.log(o.data), wx.setStorageSync("key", o.data.session_key), 
                                        wx.setStorageSync("openid", o.data.openid);
                                        var e = o.data.openid;
                                        app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: e,
                                                img: n,
                                                name: t,
                                                gender: a
                                            },
                                            success: function(o) {
                                                console.log("进入地址login"), console.log(o.data), wx.setStorageSync("users", o.data), 
                                                wx.setStorageSync("uniacid", o.data.uniacid), s.setData({
                                                    usersinfo: o.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(o) {
                                console.log("进入 wx-getUserInfo 失败"), s.setData({
                                    is_modal_Hidden: !1
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
                    success: function(o) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(o) {
        console.log("授权操作更新");
        this.wxauthSetting();
    }
});