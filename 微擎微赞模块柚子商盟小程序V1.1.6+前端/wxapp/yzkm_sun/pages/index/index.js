var app = getApp(), template = require("../template/template.js");

Page({
    data: {
        sta_hyk: "",
        jh_num: "",
        user_id: "",
        banners: [ "http://oydnzfrbv.bkt.clouddn.com/a5.jpg" ],
        is_modal_Hidden: !0,
        canIUse: wx.canIUse("button.open-type.getUserInfo"),
        isLogin: !1,
        currentTab: 0,
        currentIndex: 0,
        statusType: [ "商家推荐", "最新入驻", "距离最近" ],
        num: 5,
        light: "",
        kong: "",
        imgUrls: "",
        is_open_pop: "",
        cheatTrial: "",
        hyk_id: "",
        hyk_price: "",
        hyk_day: ""
    },
    onLoad: function(e) {
        var a = this;
        a.wxauthSetting();
        wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Url",
            success: function(o) {
                console.log("页面加载请求"), wx.setStorageSync("url", o.data), a.setData({
                    url: o.data
                }), app.util.request({
                    url: "entry/wxapp/Custom_photo",
                    success: function(e) {
                        console.log("自定义数据显示");
                        var t = o.data;
                        template.tabbar("tabBar", 0, a, e, t);
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            success: function(e) {
                console.log("获取系统表的配置参数"), wx.setStorageSync("system", e.data), e.data.pt_name && wx.setNavigationBarTitle({
                    title: e.data.pt_name
                }), e.data.color && wx.setNavigationBarColor({
                    frontColor: e.data.color,
                    backgroundColor: e.data.fontcolor,
                    animation: {
                        timingFunc: "easeIn"
                    }
                }), a.setData({
                    system: e.data,
                    is_open_pop: e.data.is_open_pop,
                    cheatTrial: e.data.cheatTrial
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Banner_photo",
            success: function(e) {
                console.log("首页基本内容"), a.setData({
                    imgUrls: e.data.Banner_photo,
                    sj_class: e.data.goodstype,
                    card_img: e.data.Card_zdy.img,
                    card_title: e.data.Card_zdy.title,
                    winindex: e.data.winindex
                });
            }
        });
    },
    goBuyTap: function(e) {
        wx.navigateTo({
            url: "../vipCard/vipCard"
        });
    },
    goDetails: function(e) {
        wx.navigateTo({
            url: "../psDetails/psDetails"
        });
    },
    itemClick: function(e) {
        console.log(e), 3 == e.currentTarget.dataset.pop_type ? wx.navigateTo({
            url: "../goodsDetails/goodsDetails?id=" + e.currentTarget.dataset.id
        }) : 2 == e.currentTarget.dataset.pop_type && wx.navigateTo({
            url: "../seller/details/details?id=" + e.currentTarget.dataset.id
        });
    },
    callmemine: function(e) {
        wx.makePhoneCall({
            phoneNumber: e.currentTarget.dataset.tel,
            success: function(e) {
                console.log("-----拨打电话成功-----");
            },
            fail: function(e) {
                console.log("-----拨打电话失败-----");
            }
        });
    },
    closeTap: function(e) {
        wx.setStorageSync("comeIn", 1), this.setData({
            comeIn: 1
        });
    },
    buyCardType: function(e) {
        console.log(e);
        this.setData({
            currentIdx: e.currentTarget.dataset.index,
            hyk_id: e.currentTarget.dataset.id,
            hyk_price: e.currentTarget.dataset.price,
            hyk_day: e.currentTarget.dataset.day
        });
    },
    tobuy: function(o) {
        console.log(o);
        var a = this, n = wx.getStorageSync("openid");
        console.log(n), console.log(a.data.sta_hyk), 2 != a.data.sta_hyk ? (app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: n
            },
            success: function(e) {
                console.log("查看用户id"), console.log(e), a.setData({
                    user_id: e.data.id
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Member_dqsj",
            data: {
                openid: n
            },
            success: function(e) {
                if (console.log("返回的用户会员卡状态"), console.log(e), 0 == e.data.status) wx.showToast({
                    title: "您的会员还未过期，无需重复购买",
                    icon: "none"
                }); else if ("" == e.data || 1 == e.data.status) {
                    if ("" == a.data.hyk_id) return void wx.showToast({
                        title: "购买的会员天数不能为空",
                        icon: "none"
                    });
                    setTimeout(function() {
                        var e = a.data.hyk_price, t = a.data.user_id;
                        console.log(t), console.log(e), console.log(n), app.util.request({
                            url: "entry/wxapp/Orderarr",
                            cachetime: "30",
                            data: {
                                openid: n,
                                price: .01
                            },
                            success: function(e) {
                                console.log(e);
                                e.data.prepay_id;
                                wx.requestPayment({
                                    timeStamp: e.data.timeStamp,
                                    nonceStr: e.data.nonceStr,
                                    package: e.data.package,
                                    signType: "MD5",
                                    paySign: e.data.paySign,
                                    success: function(e) {
                                        console.log("支付数据"), console.log(e), wx.showToast({
                                            title: "支付成功",
                                            icon: "success",
                                            duration: 2e3
                                        }), app.util.request({
                                            url: "entry/wxapp/Member_card",
                                            data: {
                                                openid: n,
                                                user_id: t,
                                                hyk_id: a.data.hyk_id,
                                                hyk_price: a.data.hyk_price,
                                                hyk_day: a.data.hyk_day
                                            },
                                            success: function(e) {
                                                console.log("修改成功"), console.log(e), app.util.request({
                                                    url: "entry/wxapp/AccessToken",
                                                    cachetime: "0",
                                                    success: function(e) {
                                                        console.log(e.data), console.log(o.detail.formId), app.util.request({
                                                            url: "entry/wxapp/Send_hyk",
                                                            cachetime: "0",
                                                            data: {
                                                                access_token: e.data.access_token,
                                                                template_id: "8cHbAdKMxbW0hHT14-F50YuMmDIiiRjatjLUL3VxDwo",
                                                                page: "./index/index",
                                                                openid: n,
                                                                form_id: o.detail.formId,
                                                                money: a.data.hyk_price
                                                            },
                                                            success: function(e) {
                                                                console.log(e);
                                                            }
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }, 500);
                }
            }
        })) : wx.showToast({
            title: "不好意思这个功能暂未开放",
            icon: "none"
        });
    },
    inputActCode: function(e) {
        console.log(e), console.log(e), console.log(e.detail.value);
        this.setData({
            jh_num: e.detail.value
        });
    },
    deterActTap: function(e) {
        var o = this;
        console.log(e), console.log(o.data.jh_num);
        var t = wx.getStorageSync("openid");
        console.log(t), app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: t
            },
            success: function(e) {
                console.log("查看用户id"), console.log(e), o.setData({
                    user_id: e.data.id
                });
            }
        }), setTimeout(function() {
            var e = o.data.user_id;
            console.log(e);
            var t = wx.getStorageSync("openid");
            console.log(t), app.util.request({
                url: "entry/wxapp/Activation",
                data: {
                    num_code: o.data.jh_num,
                    user_id: e,
                    openid: t
                },
                success: function(e) {
                    console.log("激活码判定"), console.log(e);
                }
            });
        }, 500);
    },
    click_sj: function(e) {
        console.log("商家分类id"), console.log(e);
        var t = e.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../seller/seller?id=" + t
        });
    },
    statusTap: function(e) {
        e.currentTarget.dataset.index;
        this.setData({
            currentIndex: e.currentTarget.dataset.index
        }), this.onShow();
    },
    makePhone: function(e) {
        console.log("电话的参数"), console.log(e);
        var t = e.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Store_tel",
            data: {
                sj_id: t
            },
            success: function(e) {
                console.log("商电话请求"), console.log(e), wx.makePhoneCall({
                    phoneNumber: e.data[0].phone,
                    success: function(e) {
                        console.log("-----拨打电话成功-----");
                    },
                    fail: function(e) {
                        console.log("-----拨打电话失败-----");
                    }
                });
            }
        });
    },
    toSellerDeatils: function(e) {
        console.log(e), wx.navigateTo({
            url: "../seller/details/details?id=" + e.currentTarget.dataset.id + "&&store_name=" + e.currentTarget.dataset.store_name
        });
    },
    bindChange: function(e) {
        this.setData({
            currentTab: e.detail.current
        });
    },
    swichNav: function(e) {
        if (this.data.currentTab === e.target.dataset.current) return !1;
        this.setData({
            currentTab: e.target.dataset.current
        });
    },
    bindGetUserInfo: function(e) {
        console.log(e.detail.userInfo), this.setData({
            isLogin: !1
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        wx.getStorageSync("comeIn") && a.setData({
            comeIn: 1
        });
        var n = a.data.currentIndex;
        console.log(n), wx.getLocation({
            type: "wgs84",
            success: function(e) {
                var t = e.latitude, o = e.longitude;
                app.util.request({
                    url: "entry/wxapp/Store_xxk",
                    data: {
                        latitude: t,
                        longitude: o,
                        currentIndex: n
                    },
                    success: function(e) {
                        console.log("商家数据请求"), a.setData({
                            list1: e.data
                        });
                    }
                });
            }
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
                var t = e.code;
                wx.setStorageSync("code", t), wx.getSetting({
                    success: function(e) {
                        console.log("进入wx.getSetting"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(e) {
                                console.log(e), s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: e.userInfo.avatarUrl,
                                    nickname: e.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo);
                                var o = e.userInfo.nickName, a = e.userInfo.avatarUrl, n = e.userInfo.gender;
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
                                                img: a,
                                                name: o,
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
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(e) {
        if ("button" === e.from && console.log(e.target), console.log(this.data.system.pt_name), 
        null == this.data.system.pt_name) var t = "柚子商盟"; else t = this.data.system.pt_name;
        return {
            title: this.data.nickname + "邀你来到[" + t + "]",
            path: "/yzkm_sun/pages/index/index",
            success: function(e) {},
            fail: function(e) {}
        };
    },
    onError: function(e) {
        console.log("[ onError"), console.log("onError"), console.log("msg"), console.log("]");
    },
    getUserInfo: function() {
        var t = this;
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(e) {
                        console.log("获取用户信息"), console.log(e), t.setData({
                            userInfo: e.userInfo
                        });
                    }
                });
            }
        });
    }
});