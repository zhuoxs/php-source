var app = getApp();

Page({
    data: {
        banners: [ "http://oydmq0ond.bkt.clouddn.com/shangpinxiangqing.png" ],
        is_modal_Hidden: !0,
        detailsList: [ {
            text: "这里是商家测试文字可删这里是商家测试文字可删这里是商家测试文字可删",
            pic: "http://oydnzfrbv.bkt.clouddn.com/shangjiaxiangqing.png"
        }, {
            text: "这里是商家测试文字可删这里是商家测试文字可删这里是商家测试文字可删",
            pic: "http://oydnzfrbv.bkt.clouddn.com/shangjiaxiangqing.png"
        }, {
            text: "这里是商家测试文字可删这里是商家测试文字可删这里是商家测试文字可删",
            pic: "http://oydnzfrbv.bkt.clouddn.com/shangjiaxiangqing.png"
        } ],
        flag: !0
    },
    onLoad: function(n) {
        wx.setNavigationBarTitle({
            title: n.title
        }), console.log(n), wx.setStorageSync("store_id", n.id);
        var a = this, s = wx.getStorageSync("url");
        app.util.request({
            url: "entry/wxapp/UpPopularity",
            cachetime: "0",
            data: {
                id: n.id
            },
            success: function(e) {
                console.log(e);
            }
        }), wx.getLocation({
            type: "wgs84",
            success: function(e) {
                console.log(e), wx.setStorageSync("latitude", e.latitude), wx.setStorageSync("longitude", e.longitude);
                var o = e.latitude, t = e.longitude;
                app.util.request({
                    url: "entry/wxapp/StoreInfo",
                    cachetime: "30",
                    data: {
                        id: n.id,
                        latitude: o,
                        longitude: t
                    },
                    success: function(e) {
                        console.log(e), a.setData({
                            storeDetails: e.data,
                            url: s
                        });
                    }
                });
            },
            fail: function(e) {
                wx.showModal({
                    title: "请授权获得地理信息",
                    content: '点击右上角...，进入关于页面，再点击右上角...，进入设置,开启"使用我的地理位置"'
                });
            }
        }), app.util.request({
            url: "entry/wxapp/StoreGoods",
            cachetime: "30",
            data: {
                id: n.id
            },
            success: function(e) {
                console.log(e), a.setData({
                    goods: e.data
                });
            }
        });
    },
    toComments: function(e) {
        wx.navigateTo({
            url: "../mine/index"
        });
    },
    makePhone: function(e) {
        console.log(e);
        var o = e.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: o
        });
    },
    goToIndex: function() {
        wx.redirectTo({
            url: "../first/index"
        });
    },
    goGoodsDetails: function(e) {
        var o = e.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../goods-detail/index?gid=" + o
        });
    },
    goGetYhq: function(e) {
        console.log(e);
        var o = e.currentTarget.dataset.cid, t = wx.getStorageSync("openid"), n = this, a = n.data.flag;
        console.log(a), 1 == a ? (n.setData({
            flag: !1
        }), app.util.request({
            url: "entry/wxapp/ReceiveCoupon",
            cachetime: "0",
            data: {
                openid: t,
                cid: o
            },
            success: function(e) {
                console.log(e), setTimeout(function() {
                    n.setData({
                        flag: !0
                    });
                }, 3e3);
            }
        })) : wx.showToast({
            title: "您已领取优惠券！",
            icon: "none"
        }), n.onShow();
    },
    onReady: function() {},
    overReceiveCoupon: function(e) {
        wx.showToast({
            title: "您已领取该优惠券，快去使用吧！",
            icon: "none"
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
                })) : (console.log("scope.userInfo没有授权 1"), s.setData({
                    is_modal_Hidden: !1
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
                var o = e.code;
                wx.setStorageSync("code", o), wx.getSetting({
                    success: function(e) {
                        console.log("进入wx.getSetting"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(e) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: e.userInfo.avatarUrl,
                                    nickname: e.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo);
                                var t = e.userInfo.nickName, n = e.userInfo.avatarUrl, a = e.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: o
                                    },
                                    success: function(e) {
                                        console.log("进入获取openid"), console.log(e.data), wx.setStorageSync("key", e.data.session_key), 
                                        wx.setStorageSync("openid", e.data.openid);
                                        var o = e.data.openid;
                                        app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: o,
                                                img: n,
                                                name: t,
                                                gender: a
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
    },
    onShow: function() {
        var o = this, e = wx.getStorageSync("store_id"), t = wx.getStorageSync("openid");
        console.log(e), o.wxauthSetting(), app.util.request({
            url: "entry/wxapp/getCouponDetails",
            cachetime: "0",
            data: {
                id: e,
                openid: t
            },
            success: function(e) {
                console.log(e), o.setData({
                    couponList: e.data
                });
            }
        });
    },
    ReceiveCoupon: function(e) {
        console.log(e);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(e) {
        console.log(e);
        wx.getStorageSync("openid");
        var o = wx.getStorageSync("store_id"), t = e.target.dataset.store_name;
        return "button" === e.from && console.log(e.target), {
            title: t.store_name,
            path: "chbl_sun/pages/shops/shops?id=" + o,
            success: function(e) {},
            fail: function(e) {}
        };
    }
});