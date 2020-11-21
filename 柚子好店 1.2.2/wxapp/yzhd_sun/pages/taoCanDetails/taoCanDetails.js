var app = getApp(), Api = require("../../resource/utils/util.js");

Page({
    getposterurl: function(t) {
        this.setData({
            loadingflag: !0,
            posterurl: t.detail.url
        }), this.data.clickposterFlag && this.showPoster();
    },
    showPoster: function(t) {
        if (this.data.loadingflag) {
            wx.previewImage({
                urls: [ this.data.posterurl ]
            }), this.setData({
                clickposterFlag: !1
            }), wx.hideLoading(), app.util.request({
                url: "entry/wxapp/DelCtxImg",
                cachetime: "0",
                data: {
                    wxcode: this.data.qr
                },
                success: function(t) {
                    console.log(t);
                }
            });
        } else this.setData({
            clickposterFlag: !0
        }), wx.showLoading({
            title: "卡片生成中..."
        });
        this.setData({
            showModalStatus: !1
        });
    },
    data: {
        clickposterFlag: !1,
        loadingflag: !1,
        indicatorDots: !0,
        autoplay: !0,
        interval: 3e3,
        duration: 1e3,
        circular: !0,
        is_modal_Hidden: !0,
        goodsYh: [],
        shareMore: !0,
        virtualHeader: !0,
        headerImgs: [ "../../resource/images/index/touxiang-5.png", "../../resource/images/index/touxiang.png", "../../resource/images/index/touxiang-3.png", "../../resource/images/index/touxiang-4.png" ]
    },
    onLoad: function(t) {
        var i = this;
        console.log(t), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                console.log(t), i.setData({
                    url: t.data
                }), wx.setStorage({
                    key: "url",
                    data: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetMealDetail",
            cachetime: "0",
            data: {
                meal_id: t.mealid
            },
            success: function(t) {
                console.log(t);
                var a = t.data.data.current_price - t.data.data.fans_price;
                i.setData({
                    mealInfo: t.data.data,
                    joinnum: t.data.data.fictitious_share,
                    saveMoney: a
                });
                var o = Date.parse(new Date()) / 1e3;
                if (console.log(o), o < t.data.data.start_time) {
                    console.log("未开始 ----------------"), i.countDown1();
                    var e = 1;
                } else {
                    console.log("kaishi ----------------");
                    e = 2;
                    i.countDown();
                }
                setTimeout(function() {
                    i.posterInfo();
                }, 1500);
                var n = t.data.data.expire_time;
                console.log(n);
                var s = Api.js_date_time(n).substring(0, 10);
                console.log(s), i.setData({
                    expire_time: s,
                    showhidden: e
                });
            }
        });
        var a = "yzhd_sun/pages/taoCanDetails/taoCanDetails?mealid=" + t.mealid + "&&bid=" + t.bid;
        console.log(a), app.util.request({
            url: "entry/wxapp/GetwxCode",
            cachetime: "0",
            data: {
                page: a
            },
            success: function(t) {
                console.log(123123), console.log(t), i.setData({
                    qr: t.data
                });
            }
        }), i.diyWinColor();
    },
    posterInfo: function() {
        var t = this, a = wx.getStorageSync("user_info");
        console.log(a), setTimeout(function() {
            null != a ? t.setData({
                posterinfo: {
                    avatar: a.avatarUrl,
                    banner: t.data.url + t.data.mealInfo.pic,
                    title: t.data.mealInfo.goods_name,
                    hot: "已售：" + t.data.mealInfo.goods_num,
                    qr: t.data.url + t.data.qr,
                    address: "过期时间：" + t.data.expire_time
                }
            }) : t.setData({
                posterinfo: {
                    avatar: t.data.userInfo.avatarUrl,
                    banner: t.data.url + t.data.shopInfo.logo,
                    title: t.data.shopInfo.name,
                    hot: "已售：" + t.data.shopJoinNum,
                    qr: t.data.url + t.data.qr,
                    address: "过期时间：" + t.data.expire_time
                }
            }), console.log(t.data.posterinfo);
        }, 1500);
    },
    buyNowTap: function(t) {
        console.log(t);
        var a = this;
        if ("00" == a.data.countDownDay && "00" == a.data.countDownHour && "00" == a.data.countDownMinute && "00" == a.data.countDownSecond) wx.showToast({
            title: "活动已过期",
            icon: "none",
            duration: 2e3,
            success: function(t) {
                console.log("接口调用成功");
            },
            fail: function(t) {
                console.log("接口调用失败");
            }
        }); else {
            if (a.data.countDownDay1 && a.data.countDownHour1 && a.data.countDownMinute1 && a.data.countDownSecond1) return void wx.showToast({
                title: "该活动未开始！",
                icon: "none"
            });
            if (a.data.mealInfo.sp_num <= 0) return void wx.showToast({
                title: "该商品暂无库存！",
                icon: "none"
            });
            wx.navigateTo({
                url: "../toPayOrder/toPayOrder?gid=" + t.currentTarget.dataset.gid + "&&buyType=2"
            });
        }
    },
    countDown: function(t) {
        var l = this.data.mealInfo.expire_time - Date.parse(new Date()) / 1e3, u = setInterval(function() {
            var t = l, a = Math.floor(t / 3600 / 24), o = a.toString();
            1 == o.length && (o = "0" + o);
            var e = Math.floor((t - 3600 * a * 24) / 3600), n = e.toString();
            1 == n.length && (n = "0" + n);
            var s = Math.floor((t - 3600 * a * 24 - 3600 * e) / 60), i = s.toString();
            1 == i.length && (i = "0" + i);
            var r = (t - 3600 * a * 24 - 3600 * e - 60 * s).toString();
            1 == r.length && (r = "0" + r), this.setData({
                countDownDay: o,
                countDownHour: n,
                countDownMinute: i,
                countDownSecond: r
            }), --l < 0 && (clearInterval(u), wx.showToast({
                title: "活动已结束"
            }), this.setData({
                countDownDay: "00",
                countDownHour: "00",
                countDownMinute: "00",
                countDownSecond: "00"
            }));
        }.bind(this), 1e3);
    },
    countDown1: function(t) {
        var l = this;
        console.log("进入 countDown");
        var u = l.data.mealInfo.start_time - Date.parse(new Date()) / 1e3, c = setInterval(function() {
            var t = u, a = Math.floor(t / 3600 / 24), o = a.toString();
            1 == o.length && (o = "0" + o);
            var e = Math.floor((t - 3600 * a * 24) / 3600), n = e.toString();
            1 == n.length && (n = "0" + n);
            var s = Math.floor((t - 3600 * a * 24 - 3600 * e) / 60), i = s.toString();
            1 == i.length && (i = "0" + i);
            var r = (t - 3600 * a * 24 - 3600 * e - 60 * s).toString();
            1 == r.length && (r = "0" + r), l.setData({
                countDownDay1: o,
                countDownHour1: n,
                countDownMinute1: i,
                countDownSecond1: r
            }), --u < 0 && (clearInterval(c), wx.showToast({
                title: "活动已结束",
                icon: "none",
                duration: 2e3
            }), l.setData({
                countDownDay1: "00",
                countDownHour1: "00",
                countDownMinute1: "00",
                countDownSecond1: "00"
            }));
        }.bind(l), 1e3);
    },
    onShareAppMessage: function(t) {
        var o = this;
        return "button" === t.from && console.log(t.target), {
            title: o.data.mealInfo.goods_name,
            path: "yzhd_sun/pages/taoCanDetails/taoCanDetails?mealid=" + o.data.mealInfo.id,
            success: function(t) {
                console.log("支付成功");
                var a = wx.getStorageSync("openid");
                app.util.request({
                    url: "entry/wxapp/RecommendGoodsMeal",
                    cachetime: "0",
                    data: {
                        openid: a,
                        gid: o.data.mealInfo.id
                    },
                    success: function(t) {
                        console.log(t), o.setData({
                            joinnum: t.data.data.num
                        }), o.onShow();
                    }
                });
            }
        };
    },
    onReady: function() {},
    onShow: function() {
        var s = this;
        s.wxauthSetting(), s.getHeaderImg(), setTimeout(function() {
            console.log(s.data.mealInfo.id), app.util.request({
                url: "entry/wxapp/RecommendGoodsUsers",
                cachetime: "0",
                data: {
                    gid: s.data.mealInfo.id,
                    buyType: 2
                },
                success: function(t) {
                    var a;
                    if (console.log(t), (a = t.data.data.users) && s.setData({
                        shareUserInfo: a
                    }), 0 != (a = t.data.data.users).length && s.setData({
                        shareUserInfo: a,
                        shareMore: !1
                    }), 0 == a.length && 0 != s.data.joinnum && s.setData({
                        virtualHeader: !1,
                        shareMore: !1
                    }), a.length < 5 && 5 < s.data.joinnum) {
                        console.log("zhegegegeg");
                        for (var o = [], e = 5 - a.length, n = 0; n < e; n++) o.push(s.data.headerImgs[n]);
                        s.setData({
                            virtualArray: o,
                            virtualHeader: !1,
                            shareMore: !1
                        });
                    }
                    if (a.length < 5 && s.data.joinnum < 5) {
                        for (o = [], e = s.data.joinnum - a.length, n = 0; n < e; n++) o.push(s.data.headerImgs[n]);
                        s.setData({
                            virtualArray: o,
                            virtualHeader: !1,
                            shareMore: !0
                        });
                    }
                }
            });
        }, 1e3);
    },
    goHomeTap: function(t) {
        wx.redirectTo({
            url: "../index/index"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    diyWinColor: function(t) {
        var a = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: a.color,
            backgroundColor: a.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "套餐详情"
        });
    },
    bindGetUserInfo: function(t) {
        console.log(t.detail.userInfo), this.setData({
            isLogin: !1
        });
    },
    wxauthSetting: function(t) {
        var s = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(t) {
                console.log("进入wx.getSetting 1"), console.log(t), t.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(t) {
                        s.setData({
                            is_modal_Hidden: !0,
                            thumb: t.userInfo.avatarUrl,
                            nickname: t.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), s.setData({
                    is_modal_Hidden: !1
                }));
            },
            fail: function(t) {
                console.log("获取权限失败 1"), s.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(t) {
                console.log(t.code), console.log("进入wx-login");
                var a = t.code;
                wx.setStorageSync("code", a), wx.getSetting({
                    success: function(t) {
                        console.log("进入wx.getSetting"), console.log(t), t.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(t) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: t.userInfo.avatarUrl,
                                    nickname: t.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(t.userInfo), wx.setStorageSync("user_info", t.userInfo);
                                var o = t.userInfo.nickName, e = t.userInfo.avatarUrl, n = t.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: a
                                    },
                                    success: function(t) {
                                        console.log("进入获取openid"), console.log(t.data), wx.setStorageSync("key", t.data.session_key), 
                                        wx.setStorageSync("openid", t.data.openid);
                                        var a = t.data.openid;
                                        app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: a,
                                                img: e,
                                                name: o,
                                                gender: n
                                            },
                                            success: function(t) {
                                                console.log("进入地址login"), console.log(t.data), wx.setStorageSync("users", t.data), 
                                                wx.setStorageSync("uniacid", t.data.uniacid), s.setData({
                                                    usersinfo: t.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(t) {
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
                    success: function(t) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        this.wxauthSetting();
    },
    bindShareTap: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a), console.log(t);
    },
    close: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
    },
    util: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height("250rpx").step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    getHeaderImg: function() {
        var a = this;
        console.log("获取到头像"), app.globalData.userInfo ? this.setData({
            userInfo: app.globalData.userInfo,
            hasUserInfo: !0
        }) : this.data.canIUse ? app.userInfoReadyCallback = function(t) {
            a.setData({
                userInfo: t.userInfo,
                hasUserInfo: !0
            });
        } : wx.getUserInfo({
            success: function(t) {
                app.globalData.userInfo = t.userInfo, a.setData({
                    userInfo: t.userInfo,
                    hasUserInfo: !0
                });
            }
        });
    }
});