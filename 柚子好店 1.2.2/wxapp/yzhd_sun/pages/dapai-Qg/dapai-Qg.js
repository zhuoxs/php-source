var app = getApp(), Api = require("../../resource/utils/util.js");

Page({
    getposterurl: function(o) {
        this.setData({
            loadingflag: !0,
            posterurl: o.detail.url
        }), this.data.clickposterFlag && this.showPoster();
    },
    showPoster: function(o) {
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
                success: function(o) {
                    console.log(o);
                }
            });
        } else this.setData({
            clickposterFlag: !0
        }), wx.showLoading({
            title: "卡片生成中..."
        }), setTimeout(function() {
            wx.hideLoading();
        }, 2e3);
        this.setData({
            showModalStatus: !1
        });
    },
    data: {
        clickposterFlag: !1,
        loadingflag: !1,
        shareNum: !0,
        indicatorDots: !0,
        autoplay: !0,
        interval: 3e3,
        duration: 1e3,
        circular: !0,
        is_modal_Hidden: !0,
        goodsYh: [],
        virtualHeader: !0,
        headerImgs: [ "../../resource/images/index/touxiang-5.png", "../../resource/images/index/touxiang.png", "../../resource/images/index/touxiang-3.png", "../../resource/images/index/touxiang-4.png" ]
    },
    onLoad: function(o) {
        console.log("qweeeeeqqqqqqqqqqqqqqq");
        wx.getStorageSync("openid");
        console.log(o);
        var r = this;
        r.setData({
            buyType: o.buyType ? o.buyType : ""
        }), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(o) {
                console.log("aaaaaaaaaaaaaaaaaaa"), console.log(o), r.setData({
                    url: o.data
                }), wx.setStorage({
                    key: "url",
                    data: o.data
                });
            }
        }), console.log("商品3333"), o.buyType ? (console.log("商品2222" + o.gid), app.util.request({
            url: "entry/wxapp/GetGoodsDetail",
            cachetime: "0",
            data: {
                gid: o.gid,
                buyType: o.buyType
            },
            success: function(o) {
                console.log("++++++++++++++++++"), console.log(o), app.util.request({
                    url: "entry/wxapp/GetBranchDetail",
                    cachetime: "0",
                    data: {
                        bid: o.data.data.branch_id
                    },
                    success: function(o) {
                        console.log(o), r.setData({
                            shopInfo: o.data.data
                        });
                    }
                });
                var t = o.data.data.current_price - o.data.data.fans_price;
                t = t.toFixed(2), r.setData({
                    goodsInfo: o.data.data,
                    saveMoney: t,
                    joinnum: o.data.data.recommend_num
                }), r.countDown(), setTimeout(function() {
                    r.posterInfo();
                }, 1500);
                var a = o.data.data.expire_time;
                console.log(a);
                var e = Api.js_date_time(a).substring(0, 10);
                console.log(e), r.setData({
                    expire_time: e
                });
            }
        })) : (console.log("商品1111" + o.gid), app.util.request({
            url: "entry/wxapp/GetGoodsDetail",
            cachetime: "0",
            data: {
                gid: o.gid
            },
            success: function(o) {
                console.log("获取商品***************************"), console.log(o);
                var t = o.data.data;
                app.util.request({
                    url: "entry/wxapp/GetBranchDetail",
                    cachetime: "0",
                    data: {
                        bid: o.data.data.branch_id
                    },
                    success: function(o) {
                        console.log("获取shangjia***************************"), console.log(o), r.setData({
                            shopInfo: o.data.data
                        });
                    }
                });
                var a = o.data.data.current_price - o.data.data.fans_price;
                a = a.toFixed(2), r.setData({
                    goodsInfo: o.data.data,
                    saveMoney: a,
                    joinnum: o.data.data.recommend_num
                });
                var e = Date.parse(new Date()) / 1e3;
                if (console.log(e), e < t.start_time) {
                    console.log("未开始 ----------------"), r.countDown1();
                    var n = 1;
                } else {
                    console.log("kaishi ----------------");
                    n = 2;
                    r.countDown();
                }
                setTimeout(function() {
                    r.posterInfo();
                }, 1500);
                var s = o.data.data.expire_time;
                console.log(s);
                var i = Api.js_date_time(s).substring(0, 10);
                console.log(i), r.setData({
                    showhidden: n,
                    expire_time: i
                });
            }
        })), console.log("商品4444");
        var t = "yzhd_sun/pages/dapai-Qg/dapai-Qg?gid=" + o.gid + "&buyType=" + o.buyType;
        console.log(t), app.util.request({
            url: "entry/wxapp/GetwxCode",
            cachetime: "0",
            data: {
                page: t
            },
            success: function(o) {
                console.log(123123), console.log(o), r.setData({
                    qr: o.data
                });
            }
        }), r.diyWinColor();
    },
    goShopTap: function(o) {
        wx.navigateTo({
            url: "../shopDetails/shopDetails?store_id=" + this.data.shopInfo.id
        });
    },
    makePhone: function(o) {
        console.log(o);
        wx.makePhoneCall({
            phoneNumber: this.data.shopInfo.phone
        });
    },
    buyNowTap: function(o) {
        console.log(o);
        var t = this;
        if (wx.getStorageSync("shopcart") && wx.removeStorageSync("shopcart"), "00" == t.data.countDownDay && "00" == t.data.countDownHour && "00" == t.data.countDownMinute && "00" == t.data.countDownSecond) wx.showToast({
            title: "活动已结束",
            icon: "none",
            duration: 2e3,
            success: function(o) {
                console.log("接口调用成功");
            },
            fail: function(o) {
                console.log("接口调用失败");
            }
        }); else {
            if (t.data.countDownDay1 && t.data.countDownHour1 && t.data.countDownMinute1 && t.data.countDownSecond1) return void wx.showToast({
                title: "该活动未开始！",
                icon: "none"
            });
            if (t.data.goodsInfo.sp_num <= 0) return void wx.showToast({
                title: "该商品已无库存",
                icon: "none"
            });
            wx.navigateTo({
                url: "../toPayOrder/toPayOrder?gid=" + o.currentTarget.dataset.id + "&&saveMoney=" + this.data.saveMoney + "&&buyType=" + this.data.buyType
            });
        }
    },
    countDown: function(o) {
        var c = this;
        console.log("进入 countDown");
        var u = c.data.goodsInfo.expire_time - Date.parse(new Date()) / 1e3, l = setInterval(function() {
            var o = u, t = Math.floor(o / 3600 / 24), a = t.toString();
            1 == a.length && (a = "0" + a);
            var e = Math.floor((o - 3600 * t * 24) / 3600), n = e.toString();
            1 == n.length && (n = "0" + n);
            var s = Math.floor((o - 3600 * t * 24 - 3600 * e) / 60), i = s.toString();
            1 == i.length && (i = "0" + i);
            var r = (o - 3600 * t * 24 - 3600 * e - 60 * s).toString();
            1 == r.length && (r = "0" + r), c.setData({
                countDownDay: a,
                countDownHour: n,
                countDownMinute: i,
                countDownSecond: r
            }), --u < 0 && (clearInterval(l), wx.showToast({
                title: "活动已结束",
                icon: "none",
                duration: 2e3
            }), c.setData({
                countDownDay: "00",
                countDownHour: "00",
                countDownMinute: "00",
                countDownSecond: "00"
            }));
        }.bind(c), 1e3);
    },
    countDown1: function(o) {
        var c = this;
        console.log("进入 countDown");
        var u = c.data.goodsInfo.start_time - Date.parse(new Date()) / 1e3, l = setInterval(function() {
            var o = u, t = Math.floor(o / 3600 / 24), a = t.toString();
            1 == a.length && (a = "0" + a);
            var e = Math.floor((o - 3600 * t * 24) / 3600), n = e.toString();
            1 == n.length && (n = "0" + n);
            var s = Math.floor((o - 3600 * t * 24 - 3600 * e) / 60), i = s.toString();
            1 == i.length && (i = "0" + i);
            var r = (o - 3600 * t * 24 - 3600 * e - 60 * s).toString();
            1 == r.length && (r = "0" + r), c.setData({
                countDownDay1: a,
                countDownHour1: n,
                countDownMinute1: i,
                countDownSecond1: r
            }), --u < 0 && (clearInterval(l), wx.showToast({
                title: "活动已结束",
                icon: "none",
                duration: 2e3
            }), c.setData({
                countDownDay1: "00",
                countDownHour1: "00",
                countDownMinute1: "00",
                countDownSecond1: "00"
            }));
        }.bind(c), 1e3);
    },
    goHomeTap: function(o) {
        wx.redirectTo({
            url: "../index/index"
        });
    },
    posterInfo: function() {
        var o = this, t = wx.getStorageSync("user_info");
        console.log(t), setTimeout(function() {
            null != t ? (o.setData({
                posterinfo: {
                    avatar: t.avatarUrl,
                    banner: o.data.url + o.data.goodsInfo.pic,
                    title: o.data.goodsInfo.goods_name,
                    hot: "已售：" + o.data.goodsInfo.goods_num,
                    qr: o.data.url + o.data.qr,
                    address: "过期时间：" + o.data.expire_time
                }
            }), console.log(o.data.posterinfo)) : o.setData({
                posterinfo: {
                    avatar: o.data.userInfo.avatarUrl,
                    banner: o.data.url + o.data.goodsInfo.pic,
                    title: o.data.goodsInfo.goods_name,
                    hot: "已售：" + o.data.goodsInfo.goods_num,
                    qr: o.data.url + o.data.qr,
                    address: "过期时间：" + o.data.expire_time
                }
            });
        }, 1500);
    },
    onReady: function() {
        console.log("789789798");
    },
    onShow: function() {
        console.log("进入 onShow");
        var s = this;
        s.wxauthSetting(), s.getHeaderImg(), setTimeout(function() {
            app.util.request({
                url: "entry/wxapp/RecommendGoodsUsers",
                cachetime: "0",
                data: {
                    gid: s.data.goodsInfo.id,
                    buyType: s.data.buyType
                },
                success: function(o) {
                    console.log(o);
                    var t = o.data.data.users;
                    if (0 != t.length && s.setData({
                        shareUserInfo: t,
                        shareNum: !1
                    }), 0 == t.length && 0 != s.data.joinnum && s.setData({
                        virtualHeader: !1,
                        shareNum: !1
                    }), t.length < 5 && 5 < s.data.joinnum) {
                        console.log("zhegegegeg");
                        for (var a = [], e = 5 - t.length, n = 0; n < e; n++) a.push(s.data.headerImgs[n]);
                        s.setData({
                            virtualArray: a,
                            virtualHeader: !1,
                            shareNum: !1
                        });
                    }
                    if (t.length < 5 && s.data.joinnum < 5) {
                        for (a = [], e = s.data.joinnum - t.length, n = 0; n < e; n++) a.push(s.data.headerImgs[n]);
                        s.setData({
                            virtualArray: a,
                            virtualHeader: !1,
                            shareNum: !0
                        });
                    }
                }
            });
        }, 1e3);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(o) {
        console.log(o);
        var a = this, t = a.data.goodsInfo.goods_name;
        return "button" === o.from && console.log(o.target), {
            title: t,
            path: "yzhd_sun/pages/dapai-Qg/dapai-Qg?gid=" + a.data.goodsInfo.id + "&&bid=" + a.data.shopInfo.id + "&&buyType=" + a.data.buyType + "&&title=" + a.data.title,
            success: function(o) {
                console.log(o), console.log("支付成功");
                var t = wx.getStorageSync("openid");
                app.util.request({
                    url: "entry/wxapp/RecommendGoods",
                    cachetime: "0",
                    data: {
                        openid: t,
                        gid: a.data.goodsInfo.id,
                        buyType: a.data.buyType
                    },
                    success: function(o) {
                        console.log(o), a.setData({
                            joinInfo: o.data.data,
                            joinnum: o.data.data.num
                        }), a.onShow();
                    }
                });
            }
        };
    },
    diyWinColor: function(o) {
        var t = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: t.color,
            backgroundColor: t.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), 3 == this.data.buyType ? wx.setNavigationBarTitle({
            title: "大牌抢购"
        }) : wx.setNavigationBarTitle({
            title: "大牌福利"
        });
    },
    bindGetUserInfo: function(o) {
        console.log(o.detail.userInfo), this.setData({
            isLogin: !1
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
                console.log(o.code), console.log("进入wx-login1");
                var t = o.code;
                wx.setStorageSync("code", t), wx.getSetting({
                    success: function(o) {
                        console.log("进入wx.getSetting2"), console.log(o), o.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权3"), 
                        wx.getUserInfo({
                            success: function(o) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: o.userInfo.avatarUrl,
                                    nickname: o.userInfo.nickName
                                }), console.log("进入wx-getUserInfo4"), console.log(o.userInfo), wx.setStorageSync("user_info", o.userInfo);
                                var a = o.userInfo.nickName, e = o.userInfo.avatarUrl, n = o.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: t
                                    },
                                    success: function(o) {
                                        console.log("进入获取openid5"), console.log(o.data), wx.setStorageSync("key", o.data.session_key), 
                                        wx.setStorageSync("openid", o.data.openid);
                                        var t = o.data.openid;
                                        app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: t,
                                                img: e,
                                                name: a,
                                                gender: n
                                            },
                                            success: function(o) {
                                                console.log("进入地址login6"), console.log(o.data), wx.setStorageSync("users", o.data), 
                                                wx.setStorageSync("uniacid", o.data.uniacid), s.setData({
                                                    usersinfo: o.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(o) {
                                console.log("进入 wx-getUserInfo 失败7"), s.setData({
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
    },
    bindShareTap: function(o) {
        var t = o.currentTarget.dataset.statu;
        this.util(t), console.log(o);
    },
    close: function(o) {
        var t = o.currentTarget.dataset.statu;
        this.util(t);
    },
    util: function(o) {
        var t = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = t).opacity(0).height(0).step(), this.setData({
            animationData: t.export()
        }), setTimeout(function() {
            t.opacity(1).height("250rpx").step(), this.setData({
                animationData: t
            }), "close" == o && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == o && this.setData({
            showModalStatus: !0
        });
    },
    getHeaderImg: function() {
        var t = this;
        console.log("获取到头像"), app.globalData.userInfo ? this.setData({
            userInfo: app.globalData.userInfo,
            hasUserInfo: !0
        }) : this.data.canIUse ? app.userInfoReadyCallback = function(o) {
            t.setData({
                userInfo: o.userInfo,
                hasUserInfo: !0
            });
        } : wx.getUserInfo({
            success: function(o) {
                app.globalData.userInfo = o.userInfo, t.setData({
                    userInfo: o.userInfo,
                    hasUserInfo: !0
                });
            }
        });
    }
});