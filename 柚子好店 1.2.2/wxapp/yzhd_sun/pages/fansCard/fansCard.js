var app = getApp(), template = require("../template/template.js"), Api = require("../../resource/utils/util.js");

Page({
    data: {
        shareNum: !0,
        comeIn: !0,
        showRule: !0,
        is_modal_Hidden: !0,
        virtualHeader: !0,
        headerImgs: [ "../../resource/images/index/touxiang.png", "../../resource/images/index/touxiang-3.png", "../../resource/images/index/touxiang-4.png", "../../resource/images/index/touxiang-5.png" ]
    },
    onLoad: function(e) {
        var t = this;
        t.wxauthSetting();
        var a = wx.getStorageSync("openid");
        console.log(a), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(e) {
                console.log(e), t.setData({
                    url: e.data
                }), wx.setStorage({
                    key: "url",
                    data: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(e) {
                console.log(e), wx.setStorageSync("system", e.data), t.setData({
                    system: e.data
                }), t.diyWinColor();
            }
        }), t.getUser(), t.getHeaderImg();
    },
    joinFansTap: function(e) {
        app.util.request({
            url: "entry/wxapp/GetFansCard",
            success: function(e) {
                console.log(e), 1 == e.data.vipopen ? wx.navigateTo({
                    url: "../joinFansCard/joinFansCard"
                }) : wx.showToast({
                    title: "该功能暂未开放！",
                    icon: "none"
                });
            }
        });
    },
    callTap: function(e) {
        console.log(e), wx.makePhoneCall({
            phoneNumber: e.currentTarget.dataset.tel
        });
    },
    copyTap: function(e) {
        console.log(e);
        wx.setClipboardData({
            data: e.currentTarget.dataset.chat,
            success: function(e) {
                wx.getClipboardData({
                    success: function(e) {
                        console.log(e.data);
                    }
                });
            }
        });
    },
    seeVipPower: function(e) {
        this.setData({
            showRule: !1
        });
    },
    platFormTap: function(e) {
        this.setData({
            comeIn: !1
        });
    },
    closePopupTap: function(e) {
        this.setData({
            showRule: !0
        });
    },
    closeTap: function(e) {
        wx.setStorageSync("comeIn", !0), this.setData({
            comeIn: !0
        });
    },
    goYhqDetails: function(e) {
        console.log(e), 2 == this.data.isVip ? wx.showModal({
            title: "提示",
            content: "您还没有购买粉丝卡",
            showCancel: !1,
            success: function(e) {}
        }) : 2 != this.data.isVip && wx.navigateTo({
            url: "../yhqDetails/yhqDetails?id=" + e.currentTarget.dataset.id + "&&bid=" + e.currentTarget.dataset.bid
        });
    },
    onShow: function() {
        var i = this, e = wx.getStorageSync("openid");
        console.log(e), i.getHeaderImg(), setTimeout(function(e) {
            app.util.request({
                url: "entry/wxapp/getVIpUsers",
                cachetime: "0",
                success: function(s) {
                    console.log(s), i.setData({
                        vipUsersInfo: s.data.data
                    }), app.util.request({
                        url: "entry/wxapp/GetFansCard",
                        cachetime: "0",
                        success: function(e) {
                            console.log(e), i.setData({
                                fansCardInfo: e.data
                            });
                            var t = s.data.data.length + parseInt(e.data.v_pay_num);
                            if (i.setData({
                                totalVipNum: t
                            }), 0 == s.data.data.length && 0 != t && i.setData({
                                virtualHeader: !1,
                                shareNum: !1
                            }), s.data.data.length < 5 && 5 < t) {
                                console.log("小鱼");
                                for (var a = [], o = 5 - s.data.data.length, n = 0; n < o; n++) a.push(i.data.headerImgs[n]);
                                i.setData({
                                    virtualArray: a,
                                    virtualHeader: !1,
                                    shareNum: !1
                                });
                            }
                            if (s.data.data.length < 5 && t <= 5) {
                                console.log("小鱼");
                                for (a = [], o = t - s.data.data.length, n = 0; n < o; n++) a.push(i.data.headerImgs[n]);
                                i.setData({
                                    virtualArray: a,
                                    virtualHeader: !1,
                                    shareNum: !0
                                });
                            }
                        }
                    });
                }
            });
        }, 500);
        var t = wx.getStorageSync("users");
        console.log(t), app.util.request({
            url: "entry/wxapp/Login",
            cachetime: "0",
            data: {
                openid: t.openid,
                img: t.img,
                name: t.name,
                gender: t.gender
            },
            success: function(e) {
                console.log("进入地址login"), console.log(e.data), wx.setStorageSync("users", e.data), 
                wx.setStorageSync("uniacid", e.data.uniacid);
                var t = e.data;
                i.setData({
                    usersinfo: e.data,
                    users: t
                });
                var a = t.vip_expire_time;
                console.log(a);
                var o = Api.js_date_time(a).substring(0, 10);
                console.log(o), i.setData({
                    vip_expire_time: o
                });
            }
        }), i.setData({
            users: t
        }), app.util.request({
            url: "entry/wxapp/GetCoupons",
            cachetime: "0",
            data: {
                openid: e
            },
            success: function(e) {
                console.log(e), i.setData({
                    couponsList: e.data.data
                });
            }
        });
    },
    onShareAppMessage: function(e) {
        return "button" === e.from && console.log(e.target), {
            title: "买了粉丝卡，优惠享不停~",
            path: "yzhd_sun/pages/fansCard/fansCard",
            success: function(e) {
                console.log("转发成功"), console.log(e);
            }
        };
    },
    diyWinColor: function(e) {
        var t = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: t.color,
            backgroundColor: t.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "粉丝卡"
        });
    },
    getHeaderImg: function() {
        var t = this;
        app.globalData.userInfo ? this.setData({
            userInfo: app.globalData.userInfo,
            hasUserInfo: !0
        }) : this.data.canIUse ? app.userInfoReadyCallback = function(e) {
            t.setData({
                userInfo: e.userInfo,
                hasUserInfo: !0
            });
        } : wx.getUserInfo({
            success: function(e) {
                app.globalData.userInfo = e.userInfo, t.setData({
                    userInfo: e.userInfo,
                    hasUserInfo: !0
                });
            }
        });
    },
    bindGetUserInfo: function(e) {
        console.log(e.detail.userInfo), this.setData({
            isLogin: !1
        });
    },
    wxauthSetting: function(e) {
        var s = this, t = wx.getStorageSync("openid");
        console.log(t), t ? wx.getSetting({
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
                console.log(e.code), console.log("进入wx-login");
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
                                        console.log("进入获取openid"), console.log(e.data), wx.setStorageSync("key", e.data.session_key), 
                                        wx.setStorageSync("openid", e.data.openid);
                                        var t = e.data.openid;
                                        app.util.request({
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
                                console.log("进入 wx-getUserInfo 失败"), s.setData({
                                    is_modal_Hidden: !1
                                });
                            }
                        })) : (console.log("scope.userInfo没有授权"), s.setData({
                            is_modal_Hidden: !1
                        }));
                    }
                }), s.onShow(), s.getUser();
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
    getUser: function() {
        var t = this;
        setTimeout(function() {
            var e = wx.getStorageSync("openid");
            console.log(e), app.util.request({
                url: "entry/wxapp/IsVip",
                cachetime: "0",
                data: {
                    openid: e
                },
                success: function(e) {
                    console.log(e), t.setData({
                        isVip: e.data
                    });
                }
            });
        }, 800);
    }
});