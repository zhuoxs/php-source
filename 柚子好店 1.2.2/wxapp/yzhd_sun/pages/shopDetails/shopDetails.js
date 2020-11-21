var app = getApp(), Api = require("../../resource/utils/util.js");

Page({
    getposterurl: function(a) {
        this.setData({
            loadingflag: !0,
            posterurl: a.detail.url
        }), this.data.clickposterFlag && this.showPoster();
    },
    showPoster: function(a) {
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
                success: function(a) {
                    console.log(a);
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
        shareNum: !0,
        openGroup: !0,
        openBook: !0,
        openComment: !0,
        is_modal_Hidden: !0,
        virtualHeader: !0,
        headerImgs: [ "../../resource/images/index/touxiang.png", "../../resource/images/index/touxiang-3.png", "../../resource/images/index/touxiang-4.png", "../../resource/images/index/touxiang-5.png" ]
    },
    onLoad: function(a) {
        console.log(666), console.log(a);
        var t = wx.getStorageSync("openid"), u = this;
        u.setData({
            storeID: a.store_id,
            orderno: a.orderno,
            openid: t
        }), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                console.log(a), u.setData({
                    url: a.data
                }), wx.setStorage({
                    key: "url",
                    data: a.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetGoods",
            cachetime: "0",
            data: {
                bid: a.store_id
            },
            success: function(a) {
                console.log(a), u.setData({
                    shopGoods: a.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetCoupons",
            cachetime: "0",
            data: {
                bid: a.store_id,
                openid: t
            },
            success: function(a) {
                console.log(a), u.setData({
                    couponsList: a.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetMeals",
            cachetime: "0",
            data: {
                bid: a.store_id
            },
            success: function(a) {
                console.log(a);
                var t = a.data.data;
                u.setData({
                    mealInfo: t
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetBranchDetail",
            cachetime: "0",
            data: {
                bid: a.store_id
            },
            success: function(a) {
                console.log(a);
                var t = a.data.data;
                u.setData({
                    shopInfo: t,
                    shopJoinNum: a.data.data.recommend_num
                }), 1 == t.is_open_book && u.setData({
                    openBook: !1
                }), 1 == t.is_open_comment && u.setData({
                    openComment: !1
                }), 1 == t.is_open_group && u.setData({
                    openGroup: !1
                }), setTimeout(function() {
                    u.diyWinColor();
                }, 500), setTimeout(function() {
                    u.posterInfo();
                }, 1500);
            }
        });
        var e = "yzhd_sun/pages/shopDetails/shopDetails?store_id=" + a.store_id;
        console.log(e), app.util.request({
            url: "entry/wxapp/GetwxCode",
            cachetime: "0",
            data: {
                page: e
            },
            success: function(a) {
                console.log(123123), console.log(a), u.setData({
                    qr: a.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetComments",
            cachetime: "0",
            data: {
                bid: a.store_id
            },
            success: function(a) {
                if (console.log(a), 0 != a.data.data.length) {
                    for (var t = a.data.data, e = 0; e < t.length; e++) t[e].comment_time = Api.js_date_time(t[e].comment_time);
                    var o = [], n = [];
                    for (e = 0; e < t.length; e++) {
                        o[e] = new Array(), n[e] = new Array();
                        for (var s = 0; s < a.data.data[e].score; s++) o[e][s] = 1;
                        for (var i = 0; i < 5 - a.data.data[e].score; i++) n[e][i] = 1;
                    }
                    for (e = 0; e < t.length; e++) t[e].star = o[e], t[e].kong = n[e];
                    console.log(t), u.setData({
                        commentsInfo: t
                    });
                } else {
                    var r = a.data.data;
                    u.setData({
                        noComments: r
                    });
                }
            }
        });
    },
    posterInfo: function() {
        var a = this, t = wx.getStorageSync("user_info");
        console.log(t), setTimeout(function() {
            null != t ? a.setData({
                posterinfo: {
                    avatar: t.avatarUrl,
                    banner: a.data.url + a.data.shopInfo.cover,
                    title: a.data.shopInfo.name,
                    hot: a.data.shopJoinNum + "人推荐",
                    qr: a.data.url + a.data.qr,
                    address: a.data.shopInfo.address
                }
            }) : a.setData({
                posterinfo: {
                    avatar: a.data.userInfo.avatarUrl,
                    banner: a.data.url + a.data.shopInfo.cover,
                    title: a.data.shopInfo.name,
                    hot: a.data.shopJoinNum + "人推荐",
                    qr: a.data.url + a.data.qr,
                    address: a.data.shopInfo.address
                }
            }), console.log(a.data.posterinfo);
        }, 1500);
    },
    goShopMenus: function(a) {
        var t = this;
        2 != a.currentTarget.dataset.index || t.data.orderno ? wx.navigateTo({
            url: "../menu/menu?currentType=" + a.currentTarget.dataset.index + "&&storeID=" + t.data.storeID + "&&storeName=" + t.data.shopInfo.name + "&&orderno=" + t.data.orderno + "&&shopLogo=" + t.data.shopInfo.logo
        }) : wx.showModal({
            title: "提示",
            content: "请从订单页面处进入评论",
            showCancel: !1
        });
    },
    makePhone: function(a) {
        wx.makePhoneCall({
            phoneNumber: this.data.shopInfo.phone
        });
    },
    goDapaiTap: function(a) {
        wx.navigateTo({
            url: "../dapai-Qg/dapai-Qg?gid=" + a.currentTarget.dataset.gid
        });
    },
    goYhqDetails: function(a) {
        console.log(a), wx.navigateTo({
            url: "../yhqDetails/yhqDetails?id=" + a.currentTarget.dataset.id + "&&bid=" + a.currentTarget.dataset.bid
        });
    },
    goMealDetails: function(a) {
        wx.navigateTo({
            url: "../taoCanDetails/taoCanDetails?mealid=" + a.currentTarget.dataset.mealid + "&&bid=" + a.currentTarget.dataset.bid
        });
    },
    goHomeTap: function(a) {
        wx.navigateTo({
            url: "../index/index"
        });
    },
    onReady: function() {},
    onShow: function() {
        var s = this;
        s.wxauthSetting(), s.getHeaderImg(), console.log(s.data.storeID), setTimeout(function() {
            app.util.request({
                url: "entry/wxapp/RecommendBranchUsers",
                cachetime: "0",
                data: {
                    bid: s.data.storeID
                },
                success: function(a) {
                    console.log(a);
                    var t = a.data.data.users;
                    if (0 != t.length && s.setData({
                        shareUserInfo: t,
                        shareNum: !1
                    }), 0 == t.length && 0 != s.data.shopJoinNum && s.setData({
                        virtualHeader: !1,
                        shareNum: !1
                    }), t.length < 5 && 5 < s.data.shopJoinNum) {
                        for (var e = [], o = 5 - t.length, n = 0; n < o; n++) e.push(s.data.headerImgs[n]);
                        s.setData({
                            virtualArray: e,
                            virtualHeader: !1,
                            shareNum: !1
                        });
                    }
                    if (t.length < 5 && s.data.shopJoinNum < 5) {
                        for (e = [], o = s.data.shopJoinNum - t.length, n = 0; n < o; n++) e.push(s.data.headerImgs[n]);
                        s.setData({
                            virtualArray: e,
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
    onShareAppMessage: function(a) {
        var t = this;
        return "button" === a.from && console.log(t.data.shopInfo), {
            title: t.data.shopInfo.name,
            path: "yzhd_sun/pages/shopDetails/shopDetails?store_id=" + t.data.shopInfo.id,
            success: function(a) {
                console.log("转发成功"), console.log(a), app.util.request({
                    url: "entry/wxapp/RecommendBranch",
                    cachetime: "0",
                    data: {
                        openid: t.data.openid,
                        bid: t.data.shopInfo.id
                    },
                    success: function(a) {
                        console.log(a), t.setData({
                            shopJoinNum: a.data.data.num
                        }), t.onShow();
                    }
                });
            }
        };
    },
    diyWinColor: function(a) {
        var t = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: t.color,
            backgroundColor: t.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: this.data.shopInfo.name
        });
    },
    bindGetUserInfo: function(a) {
        console.log(a.detail.userInfo), this.setData({
            isLogin: !1
        });
    },
    wxauthSetting: function(a) {
        var s = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(a) {
                console.log("进入wx.getSetting 1"), console.log(a), a.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(a) {
                        s.setData({
                            is_modal_Hidden: !0,
                            thumb: a.userInfo.avatarUrl,
                            nickname: a.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), s.setData({
                    is_modal_Hidden: !1
                }));
            },
            fail: function(a) {
                console.log("获取权限失败 1"), s.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(a) {
                console.log(a.code), console.log("进入wx-login");
                var t = a.code;
                wx.setStorageSync("code", t), wx.getSetting({
                    success: function(a) {
                        console.log("进入wx.getSetting"), console.log(a), a.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(a) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: a.userInfo.avatarUrl,
                                    nickname: a.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(a.userInfo), wx.setStorageSync("user_info", a.userInfo);
                                var e = a.userInfo.nickName, o = a.userInfo.avatarUrl, n = a.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: t
                                    },
                                    success: function(a) {
                                        console.log("进入获取openid"), console.log(a.data), wx.setStorageSync("key", a.data.session_key), 
                                        wx.setStorageSync("openid", a.data.openid);
                                        var t = a.data.openid;
                                        app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: t,
                                                img: o,
                                                name: e,
                                                gender: n
                                            },
                                            success: function(a) {
                                                console.log("进入地址login"), console.log(a.data), wx.setStorageSync("users", a.data), 
                                                wx.setStorageSync("uniacid", a.data.uniacid), s.setData({
                                                    usersinfo: a.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(a) {
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
                    success: function(a) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(a) {
        console.log("授权操作更新");
        this.wxauthSetting();
    },
    bindShareTap: function(a) {
        var t = a.currentTarget.dataset.statu;
        this.util(t), console.log(a);
    },
    close: function(a) {
        var t = a.currentTarget.dataset.statu;
        this.util(t);
    },
    util: function(a) {
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
            }), "close" == a && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == a && this.setData({
            showModalStatus: !0
        });
    },
    getHeaderImg: function() {
        var t = this;
        console.log("获取到头像"), app.globalData.userInfo ? this.setData({
            userInfo: app.globalData.userInfo,
            hasUserInfo: !0
        }) : this.data.canIUse ? app.userInfoReadyCallback = function(a) {
            t.setData({
                userInfo: a.userInfo,
                hasUserInfo: !0
            });
        } : wx.getUserInfo({
            success: function(a) {
                app.globalData.userInfo = a.userInfo, t.setData({
                    userInfo: a.userInfo,
                    hasUserInfo: !0
                });
            }
        });
    }
});