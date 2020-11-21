var app = getApp(), tool = require("../../../style/utils/countDown.js");

Page({
    data: {
        navTile: "首页",
        imgUrls: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842309.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842319.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842327.png" ],
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        current: 0,
        notName: "公告",
        notice: "本周凡是进店，送菇凉一枚",
        operation: [ {
            name: "预约",
            src: "../../../style/images/nav8.png",
            bindname: "toBook"
        }, {
            name: "好物",
            src: "../../../style/images/nav2.png",
            bindname: "toGood"
        }, {
            name: "优惠券",
            src: "../../../style/images/nav7.png",
            bindname: "toCards"
        }, {
            name: "关于我们",
            src: "../../../style/images/nav4.png",
            bindname: "toAbout"
        }, {
            name: "拼团",
            src: "../../../style/images/nav5.png",
            bindname: "toGroup"
        }, {
            name: "砍价",
            src: "../../../style/images/nav3.png",
            bindname: "toBargain"
        }, {
            name: "限时购",
            src: "../../../style/images/nav6.png",
            bindname: "toLimit"
        }, {
            name: "分享",
            src: "../../../style/images/nav1.png",
            bindname: "toShare"
        } ],
        shopUserImg: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295622.png",
        shopMsg: "欢迎光临本店",
        shopMsg2: "有问题点击右边按钮进行客服咨询",
        shopPhone: "13000000",
        cards: [ {
            money: "5",
            day: "3",
            remark: "5元无门槛",
            status: "1"
        }, {
            money: "8",
            day: "3",
            remark: "8元无门槛",
            status: "0"
        } ],
        bargainList: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
            bgSrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162021.png",
            price: "600",
            minPrice: "300.00",
            usernum: "99",
            uthumb: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311829.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311834.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311837.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15221231184.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311843.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212314013.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212314019.png" ],
            endTime: "1529799965000",
            clock: ""
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            bgSrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162003.png",
            price: "600",
            minPrice: "398.00",
            usernum: "109",
            uthumb: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311829.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311834.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311837.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15221231184.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311843.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212314013.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212314019.png" ],
            endTime: "1554519898765",
            clock: ""
        } ],
        newList: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            price: "399.00"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00"
        } ],
        group: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
            bgSrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162003.png",
            price: "600",
            minPrice: "398.00",
            usernum: "109",
            group: "多人拼，更省",
            groupUser: "2人团",
            num: "99"
        } ],
        isLogin: !1,
        showAd: !1
    },
    bindViewTap: function() {
        wx.navigateTo({
            url: "../logs/logs"
        });
    },
    onLoad: function() {
        console.log("重新加载");
        var t = wx.getStorageSync("settings");
        "" != t && wx.setNavigationBarTitle({
            title: t.index_title
        });
        var e = this, a = getCurrentPages(), n = a[a.length - 1].route;
        console.log("当前路径为:" + n), e.setData({
            current_url: n
        }), app.editTabBar(), app.util.request({
            url: "entry/wxapp/checkGroups",
            cachetime: "0",
            success: function(t) {}
        }), app.util.request({
            url: "entry/wxapp/Url1",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                }), e.reload(), e.getSomething();
            }
        });
    },
    getCoupon: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/getCoupon",
            cachetime: "0",
            data: {
                uid: t,
                show_index: 1
            },
            success: function(t) {
                e.setData({
                    coupon: t.data.data
                });
            }
        });
    },
    getSomething: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/getCustomize",
            cachetime: "10",
            success: function(t) {
                var e = t.data.tab;
                console.log(app.globalData.isIpx), wx.setStorageSync("tab", e), n.setData({
                    customize: t.data,
                    isIpx: app.globalData.isIpx
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Settings",
            cachetime: "10",
            success: function(t) {
                wx.setStorageSync("settings", t.data), n.setData({
                    settings: t.data,
                    navTile: t.data.index_title
                });
                var e = t.data.is_adv, a = wx.getStorageSync("is_adv");
                1 == e && "" == a && n.setData({
                    showAd: !0
                });
            }
        }), app.util.request({
            url: "entry/wxapp/icons",
            cachetime: "10",
            success: function(t) {
                n.setData({
                    icons: t.data.data
                });
            }
        });
    },
    reload: function(t) {
        var o = this;
        wx.login({
            success: function(t) {
                var e = t.code;
                wx.setStorageSync("code", e), app.util.request({
                    url: "entry/wxapp/openid",
                    cachetime: "0",
                    data: {
                        code: e
                    },
                    success: function(t) {
                        wx.setStorageSync("key", t.data.session_key), wx.setStorageSync("openid", t.data.openid);
                        var n = t.data.openid;
                        o.getCoupon(n), wx.getSetting({
                            success: function(t) {
                                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                                    success: function(t) {
                                        wx.setStorageSync("user_info", t.userInfo);
                                        var e = t.userInfo.nickName, a = t.userInfo.avatarUrl;
                                        app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: n,
                                                img: a,
                                                name: e
                                            },
                                            success: function(t) {
                                                wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid);
                                            }
                                        }), o.setData({
                                            avatarUrl: a
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    onShow: function() {
        var n = this;
        wx.getStorageSync("is_login") || wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] ? (wx.setStorageSync("is_login", 1), n.setData({
                    isLogin: !1
                })) : n.setData({
                    isLogin: !0
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "20",
            success: function(t) {
                wx.setStorageSync("system", t.data), wx.setStorageSync("color", t.data.color), wx.setStorageSync("fontcolor", t.data.fontcolor), 
                wx.setNavigationBarColor({
                    frontColor: wx.getStorageSync("fontcolor"),
                    backgroundColor: wx.getStorageSync("color"),
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getBargainGoods",
            cachetime: "0",
            data: {
                index: 8
            },
            success: function(t) {
                var a = t.data;
                setInterval(function() {
                    for (var t = 0; t < a.length; t++) {
                        var e = tool.countDown(n, a[t].endtime);
                        a[t].clock = e ? "距离结束还剩：" + e[0] + "天" + e[1] + "时" + e[3] + "分" + e[4] + "秒" : "已经截止";
                    }
                    n.setData({
                        bargainrecommend: a
                    });
                }, 1e3);
            }
        }), app.util.request({
            url: "entry/wxapp/TypeGoodList",
            cachetime: "0",
            data: {
                show_index: 1
            },
            success: function(t) {
                console.log(t), n.setData({
                    goodsrecommend: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getGroupGoods",
            cachetime: "0",
            data: {
                index: 8
            },
            success: function(t) {
                var e = t.data;
                n.setData({
                    groupsrecommend: e
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getYuyueGoods",
            cachetime: "0",
            data: {
                index: 8
            },
            success: function(t) {
                var e = t.data;
                n.setData({
                    yuyuerecommend: e
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getHaowuGoods",
            cachetime: "0",
            data: {
                index: 8
            },
            success: function(t) {
                var e = t.data;
                n.setData({
                    haowurecommend: e
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getLimitGoods",
            cachetime: "0",
            data: {
                index: 8
            },
            success: function(t) {
                var a = t.data;
                setInterval(function() {
                    for (var t = 0; t < a.length; t++) {
                        var e = tool.countDown(n, a[t].endtime);
                        a[t].clock = e ? e[2] + " : " + e[3] + " : " + e[4] : "00 : 00 : 00";
                    }
                    n.setData({
                        limitrecommend: a
                    });
                }, 1e3);
            }
        }), app.util.request({
            url: "entry/wxapp/getShareGoods",
            cachetime: "0",
            data: {
                index: 8
            },
            success: function(t) {
                var e = t.data;
                n.setData({
                    sharerecommend: e
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getRecommendSort",
            cachetime: "10",
            success: function(t) {
                n.setData({
                    RecommendSort: t.data
                });
            }
        });
    },
    goTap: function(t) {
        var e = this;
        e.setData({
            current: t.currentTarget.dataset.index
        }), 0 == e.data.current && wx.redirectTo({
            url: "../index/index?currentIndex=0"
        }), 1 == e.data.current && wx.redirectTo({
            url: "../shop/shop?currentIndex=1"
        }), 2 == e.data.current && wx.redirectTo({
            url: "../active/active?currentIndex=2"
        }), 3 == e.data.current && wx.redirectTo({
            url: "../carts/carts?currentIndex=3"
        }), 4 == e.data.current && wx.redirectTo({
            url: "../user/user?currentIndex=4"
        });
    },
    toDialog: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.settings.tel
        });
    },
    callphone: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.settings.hz_tel
        });
    },
    receRards: function(t) {
        var a = this, e = t.currentTarget.dataset.status, n = t.currentTarget.dataset.index, o = a.data.coupon, i = t.currentTarget.dataset.gid;
        "2" == e ? wx.showModal({
            title: "提示",
            content: "您已经领取过该优惠券啦~",
            showCancel: !1
        }) : 1 == e ? wx.showModal({
            title: "提示",
            content: "优惠券已被抢光啦~下次早点来",
            showCancel: !1
        }) : "0" == e && wx.getStorage({
            key: "openid",
            success: function(t) {
                console.log("openid为"), console.log(t.data), app.util.request({
                    url: "entry/wxapp/receiveCoupon",
                    cachetime: "0",
                    data: {
                        uid: t.data,
                        gid: i
                    },
                    success: function(t) {
                        var e = t.data.errno;
                        0 == e || 3 == e ? (o[n].status = 2, wx.showModal({
                            title: "提示",
                            content: "恭喜你，领取成功",
                            showCancel: !1,
                            success: function(t) {
                                a.setData({
                                    coupon: o
                                });
                            }
                        })) : 1 != e && 2 != e || (o[n].status = 1), a.setData({
                            coupon: o
                        });
                    }
                });
            }
        });
    },
    toBook: function(t) {
        wx.navigateTo({
            url: "book/book"
        });
    },
    toCards: function(t) {
        wx.navigateTo({
            url: "cards/cards"
        });
    },
    toAbout: function(t) {
        wx.navigateTo({
            url: "about/about"
        });
    },
    toGroup: function(t) {
        wx.navigateTo({
            url: "group/group"
        });
    },
    toBargain: function(t) {
        wx.navigateTo({
            url: "bargain/bargain"
        });
    },
    toLimit: function(t) {
        wx.navigateTo({
            url: "limit/limit"
        });
    },
    toShare: function(t) {
        wx.navigateTo({
            url: "share/share"
        });
    },
    toGood: function(t) {
        wx.navigateTo({
            url: "good/good"
        });
    },
    toBardet: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "bardet/bardet?gid=" + e
        });
    },
    toGoodsdet: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "goodsDet/goodsDet?gid=" + e
        });
    },
    toGroupdet: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "groupDet/groupDet?gid=" + e
        });
    },
    isLogin: function(t) {
        this.setData({
            isLogin: !this.data.isLogin
        });
    },
    bindGetUserInfo: function(t) {
        console.log(t), console.log(t.detail.userInfo), null == t.detail.userInfo ? console.log("没有授权") : (wx.setStorageSync("is_login", 1), 
        this.setData({
            isLogin: !1
        }), this.reload(), this.onLoad());
    },
    onShareAppMessage: function() {},
    toSharedet: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "shareDet/shareDet?gid=" + e
        });
    },
    toGooddet: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "goodDet/goodDet?gid=" + e
        });
    },
    toBookdet: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "bookDet/bookDet?gid=" + e
        });
    },
    toLimitdet: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "limitDet/limitDet?gid=" + e
        });
    },
    toggleAd: function(t) {
        wx.setStorageSync("is_adv", 1), this.setData({
            showAd: !1
        });
    },
    toBanner: function(t) {
        var e = t.currentTarget.dataset.url;
        e = "/" + e, wx.navigateTo({
            url: e
        });
    },
    toIcons: function(t) {
        var e = t.currentTarget.dataset.url;
        e = "/" + e, wx.navigateTo({
            url: e
        });
    },
    toTab: function(t) {
        var e = t.currentTarget.dataset.url;
        e = "/" + e, wx.redirectTo({
            url: e
        });
    },
    toSearch: function(t) {
        var e = this.data.keyword;
        "" == e || null == e ? wx.showToast({
            title: "请输入关键词",
            icon: "none"
        }) : (wx.setStorageSync("keyword", e), wx.navigateTo({
            url: "/yzmdwsc_sun/pages/search/search?keyword=" + e
        }));
    },
    inputFocus: function(t) {
        console.log(t.detail.value), this.setData({
            keyword: t.detail.value
        });
    }
});