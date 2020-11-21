var app = getApp(), tool = require("../../../we7/js/countDown.js");

Page({
    data: {
        joinGroup: !0,
        indicatorDots: !0,
        autoplay: !0,
        interval: 3e3,
        duration: 1e3,
        circular: !0,
        hideShopPopup: !0,
        hideNewFooter: !0,
        savedMoney: 10,
        totalSave: 11.6,
        qwer: 50,
        qaz: 20,
        flag: !0,
        kanjiabtn: 0,
        banners: [ "../../resource/images/first/dw.png" ],
        bargainList: [ {
            endTime: "",
            clock: ""
        }, {
            endTime: "",
            clock: ""
        } ]
    },
    onLoad: function(a) {
        var i = this;
        console.log(a), wx.setStorageSync("kanjiaid", a.id);
        var s = wx.getStorageSync("openid"), t = (wx.getStorageSync("latitude"), wx.getStorageSync("longitude"), 
        wx.getStorageSync("system"));
        i.setData({
            url: wx.getStorageSync("url"),
            system: t
        }), app.get_location().then(function(t) {
            app.util.request({
                url: "entry/wxapp/BargainDetails",
                cachetime: "30",
                data: {
                    latitude: t.latitude,
                    longitude: t.longitude,
                    id: a.id
                },
                success: function(a) {
                    console.log(a);
                    var e = [ {
                        thumb: a.data.data.pic,
                        title: a.data.data.gname,
                        active_num: a.data.data.num,
                        part_num: a.data.data.part_bargain_num,
                        id: a.data.data.id
                    } ];
                    console.log(e);
                    var o = a.data.data, n = setInterval(function() {
                        var t = tool.countDown(i, o.endtime);
                        t ? o.clock = t[0] + " 天 " + t[1] + " 时 " + t[3] + "分 " + t[4] + "秒 " : (o.clock = " 0 天 0 时 0 分 0 秒 ", 
                        clearInterval(n)), i.setData({
                            bargain: a.data.data,
                            openid: s,
                            active: e[0]
                        });
                    }, 1e3);
                    i.setData({
                        bargain: a.data.data,
                        openid: s
                    });
                }
            });
        }), app.util.request({
            url: "entry/wxapp/isVip",
            cachetime: "0",
            data: {
                openid: s
            },
            success: function(t) {
                console.log(t), 1 == t.data ? wx.setStorageSync("is_vip", t.data) : wx.setStorageSync("is_vip", "");
            }
        });
    },
    joinGroup: function(t) {
        this.setData({
            joinGroup: !1
        });
    },
    closeWelfare: function(t) {
        this.setData({
            joinGroup: !0
        });
    },
    createPoster: function(t) {
        var a = wx.getStorageSync("openid"), e = this.data.active;
        wx.setStorageSync("active", e);
        var o = "chbl_sun/pages/help/help?id=" + e.id + "&openid=" + a;
        wx.setStorageSync("page", o), console.log(e), wx.navigateTo({
            url: "../poster/poster"
        });
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
    closePopupTap: function() {
        this.setData({
            hideShopPopup: !0,
            hideNewFooter: !1
        });
    },
    nowBargain: function(a) {
        var e = this, o = a.detail.target.dataset.gid, n = wx.getStorageSync("openid");
        wx.getStorageSync("kanjiaid");
        console.log(a);
        a.detail.formId;
        var t = e.data.bargain, i = wx.getStorageSync("is_vip");
        1 == e.data.flag ? (e.setData({
            flag: !1
        }), 1 == t.is_vip ? 1 == i ? app.util.request({
            url: "entry/wxapp/SaveFormid",
            cachetime: "0",
            data: {
                user_id: wx.getStorageSync("users").id,
                form_id: a.detail.formId,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/NowBargain",
                    cachetime: "0",
                    data: {
                        id: o,
                        openid: n
                    },
                    success: function(t) {
                        console.log("****************************"), console.log(t), e.setData({
                            hideShopPopup: !1,
                            myprice: t.data
                        }), console.log(o), app.util.request({
                            url: "entry/wxapp/comeActiveMessage",
                            cachetime: "0",
                            data: {
                                form_id: a.detail.formId,
                                openid: wx.getStorageSync("openid"),
                                active_id: o,
                                active_type: 1
                            },
                            success: function(t) {
                                console.log("模板消息发送"), console.log(t);
                            }
                        }), e.onShow();
                    }
                });
            }
        }) : wx.showToast({
            title: "该活动仅限会员参与",
            icon: "none"
        }) : app.util.request({
            url: "entry/wxapp/SaveFormid",
            cachetime: "0",
            data: {
                user_id: wx.getStorageSync("users").id,
                form_id: a.detail.formId,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/NowBargain",
                    cachetime: "0",
                    data: {
                        id: o,
                        openid: n
                    },
                    success: function(t) {
                        console.log("****************************"), console.log(t), e.setData({
                            hideShopPopup: !1,
                            myprice: t.data
                        }), console.log(o), app.util.request({
                            url: "entry/wxapp/comeActiveMessage",
                            cachetime: "0",
                            data: {
                                form_id: a.detail.formId,
                                openid: wx.getStorageSync("openid"),
                                active_id: o,
                                active_type: 1
                            },
                            success: function(t) {
                                console.log("模板消息发送"), console.log(t);
                            }
                        }), e.onShow();
                    }
                });
            }
        }), setTimeout(function() {
            e.setData({
                flag: !0
            });
        }, 2e3)) : wx.showToast({
            title: "请勿重复提交请求！",
            icon: "none"
        });
    },
    bargainlist: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.id, e = wx.getStorageSync("openid");
        wx.navigateTo({
            url: "../help/help?id=" + a + "&openid=" + e
        });
    },
    onShow: function() {
        var t = wx.getStorageSync("kanjiaid"), a = wx.getStorageSync("openid");
        console.log(t), this.getUserInfo();
        var e = this;
        app.util.request({
            url: "entry/wxapp/iskanjia",
            cachetime: "0",
            data: {
                openid: a,
                id: t
            },
            success: function(t) {
                console.log(t), e.setData({
                    iskanjia: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/myBargain",
            cachetime: "0",
            data: {
                openid: a,
                id: t
            },
            success: function(t) {
                console.log(t), e.setData({
                    mybargain: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/partNum",
            cachetime: "0",
            data: {
                id: t
            },
            success: function(t) {
                console.log(t);
                var a = t.data.data;
                e.setData({
                    partuser: a
                });
            }
        }), app.util.request({
            url: "entry/wxapp/friendsImg",
            cachetime: "0",
            data: {
                openid: a,
                id: t
            },
            success: function(t) {
                console.log(t), e.setData({
                    Img: t.data.data
                });
            }
        });
    },
    getUserInfo: function() {
        var a = this;
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(t) {
                        console.log(t), a.setData({
                            userInfo: t.userInfo
                        });
                    }
                });
            }
        });
    },
    onReady: function() {
        console.log(1), this.setData({
            kanjiabtn: 1
        });
    },
    buynow: function(e) {
        var o = this, n = wx.getStorageSync("kanjiaid"), i = wx.getStorageSync("openid"), t = o.data.bargain, a = o.data.mybargain;
        1 != t.lowdebuxing || t.shopprice - 0 == a.prices - 0 ? app.util.request({
            url: "entry/wxapp/Expire",
            cachetime: "0",
            data: {
                id: n
            },
            success: function(t) {
                console.log(t);
                var a = t.data.data;
                app.util.request({
                    url: "entry/wxapp/buyed",
                    cachetime: "0",
                    data: {
                        id: n,
                        openid: i
                    },
                    success: function(t) {
                        (console.log(t.data), 2 == t.data) ? 1 == a ? o.data.bargain.num <= 0 ? wx.showToast({
                            title: "商品没有库存啦！",
                            icon: "none"
                        }) : wx.navigateTo({
                            url: "../to-pay-bargain/index?id=" + e.currentTarget.dataset.id
                        }) : wx.showToast({
                            title: "活动已结束！感谢参与！",
                            icon: "none"
                        }) : wx.showToast({
                            title: "您已购买该商品，不要贪心哦！",
                            icon: "none"
                        });
                    }
                });
            }
        }) : wx.showToast({
            title: "该商品砍到最低价才能购买哦",
            icon: "none"
        });
    },
    goBackHome: function() {
        wx.redirectTo({
            url: "../first/index"
        });
    },
    makeCall: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        var a = wx.getStorageSync("openid"), e = wx.getStorageSync("kanjiaid"), o = (wx.getStorageSync("system"), 
        this.data.bargain);
        if ("button" === t.from) {
            console.log(t.target);
            a = wx.getStorageSync("openid"), e = wx.getStorageSync("kanjiaid");
        }
        return {
            title: o.share_title,
            path: "chbl_sun/pages/help/help?id=" + e + "&openid=" + a,
            success: function(t) {
                console.log("转发成功");
            },
            fail: function(t) {
                console.log("转发失败");
            }
        };
    }
});