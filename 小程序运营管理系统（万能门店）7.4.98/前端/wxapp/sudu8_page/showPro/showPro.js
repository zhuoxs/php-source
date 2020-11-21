var _Page;

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp();

Page((_defineProperty(_Page = {
    data: _defineProperty({
        picList: [],
        interval: 5e3,
        duration: 1e3,
        currentSwiper: 0,
        clock: "",
        a: 1,
        sc: 0,
        content: "",
        con2: "",
        con3: "",
        shareHome: 0,
        fxsid: 0,
        shareShow: 0,
        shareScore: 0,
        shareNotice: 0,
        infinite: !1,
        current: 0,
        imgheights: []
    }, "currentSwiper", 0),
    imageLoad: function(t) {
        var a = 750 / (t.detail.width / (a = t.detail.height)), e = this.data.imgheights;
        e[t.currentTarget.dataset.id] = a, this.setData({
            imgheights: e
        });
    },
    bindchange: function(t) {
        this.setData({
            current: t.detail.current
        });
    },
    onLoad: function(t) {
        var a = this, e = t.id;
        a.setData({
            id: e
        }), wx.showShareMenu({
            withShareTicket: !0
        });
        var i = 0;
        t.fxsid && (i = t.fxsid, a.setData({
            fxsid: t.fxsid,
            shareHome: 1
        })), t.userid && a.setData({
            userid: t.userid
        }), app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(t) {
                t.data.data;
                a.setData({
                    baseinfo: t.data.data,
                    comm: t.data.data.commP,
                    comms: t.data.data.commPs
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(a.getinfos, i);
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                e.setData({
                    openid: t.data
                });
                var a = e.data.id;
                e.getShowPic(a), e.givepscore();
            }
        });
    },
    checkvip: function() {
        var a = this, t = wx.getStorageSync("openid");
        wx.request({
            url: app.util.url("entry/wxapp/checkvip", {
                m: "sudu8_page"
            }),
            data: {
                kwd: "miaosha",
                openid: t,
                id: a.data.id,
                gz: 1
            },
            success: function(t) {
                return !0 === t.data.data ? (a.tobuy(), !1) : !1 === t.data.data ? (a.setData({
                    needvip: !0
                }), wx.showModal({
                    title: "进入失败",
                    content: "使用本功能需先开通vip!",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "/sudu8_page/register/register"
                        });
                    }
                }), !1) : void (0 < t.data.data.needgrade ? (a.setData({
                    needvip: !0
                }), 0 < t.data.data.grade ? t.data.data.grade < t.data.data.needgrade ? wx.showModal({
                    title: "进入失败",
                    content: "使用本功能需成为" + t.data.data.vipname + "(" + t.data.data.needgrade + ")以上等级会员,请先升级!",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "/sudu8_page/open1/open1"
                        });
                    }
                }) : a.tobuy() : t.data.data.grade < t.data.data.needgrade ? wx.showModal({
                    title: "进入失败",
                    content: "使用本功能需成为" + t.data.data.vipname + "(" + t.data.data.needgrade + ")以上等级会员,请先开通会员后再升级会员等级!",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "/sudu8_page/register/register"
                        });
                    }
                }) : a.tobuy()) : a.tobuy());
            },
            fail: function(t) {}
        });
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    output: function(t) {
        var a = void 0;
        if (this.data.sto_id = t.sto_id, a = 0 < t.day ? t.day + "天" + t.hour + "小时" + t.min + "分钟" + t.sec + "秒" : t.hour + "小时" + t.min + "分钟" + t.sec + "秒", 
        0 == t.day && 0 == t.hour && 0 == t.min && 0 == t.sec) if (0 == this.data.start) {
            this.setData({
                start: 1
            });
            var e = new Date().getTime();
            app.util.countDown(this.output, 1e3 * this.data.sale_end_time - e);
        } else 1 == this.data.start && this.setData({
            start: 2
        }); else this.setData({
            clock: a
        });
    },
    getShowPic: function(a) {
        var e = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/globaluserinfo",
            data: {
                openid: t
            },
            success: function(t) {
                e.setData({
                    globaluser: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/showPro",
            data: {
                types: "showPro",
                id: a,
                openid: t
            },
            success: function(t) {
                0 == t.data.data.is_flag && wx.showModal({
                    title: "提示",
                    content: "该商品已不存在,请选择其他商品",
                    showCancel: !1,
                    success: function() {
                        return wx.navigateBack({
                            delta: 1
                        }), !1;
                    }
                }), 1 == t.data.data.is_saletwo && wx.showModal({
                    title: "提示",
                    content: "该商品已下架,请选择其他商品",
                    showCancel: !1,
                    success: function() {
                        wx.redirectTo({
                            url: "/sudu8_page/index/index"
                        });
                    }
                }), 0 == t.data.data.timetobegin && "0" == t.data.data.sale_end_time_copy ? e.setData({
                    infinite: !0
                }) : 0 == t.data.data.timetobegin && 0 == t.data.data.sale_end_time ? e.setData({
                    start: 2
                }) : 0 < t.data.data.timetobegin ? (e.setData({
                    start: 0
                }), app.util.countDown(e.output, t.data.data.timetobegin)) : 0 == t.data.data.timetobegin && 0 < t.data.data.sale_end_time && (e.setData({
                    start: 1
                }), app.util.countDown(e.output, 1e3 * t.data.data.sale_end_time)), e.setData({
                    id: a,
                    sale_end_time: t.data.data.sale_end_time_copy,
                    picList: t.data.data.text,
                    title: t.data.data.title,
                    datas: t.data.data,
                    my_num: t.data.data.my_num,
                    xg_num: t.data.data.pro_xz,
                    sc: t.data.data.collectcount,
                    commSelf: t.data.data.comment
                }), t.data.data.product_txt && WxParse.wxParse("content", "html", t.data.data.product_txt, e, 5), 
                t.data.data.con2 && WxParse.wxParse("con2", "html", t.data.data.con2, e, 5), t.data.data.con3 && WxParse.wxParse("con3", "html", t.data.data.con3, e, 5), 
                wx.setNavigationBarTitle({
                    title: e.data.title
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
            }
        }), setTimeout(function() {
            if ("1" == e.data.comm && "0" != e.data.commSelf || "1" == e.data.commSelf) {
                var t = e.data.comms;
                e.setData({
                    commShow: 1
                }), app.util.request({
                    url: "entry/wxapp/getComment",
                    cachetime: "0",
                    data: {
                        id: a,
                        comms: t
                    },
                    success: function(t) {
                        "" != t.data && e.setData({
                            comments: t.data.data,
                            is_comment: 1
                        });
                    }
                });
            }
        }, 500);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        for (var t = this.data.id, a = this.data.sto_id, e = a - 50; e <= a + 50; e++) clearTimeout(e);
        this.getShowPic(t), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    makePhoneCall: function(t) {
        var a = this.data.baseinfo.tel;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    onShareAppMessage: function() {
        var t = wx.getStorageSync("openid"), a = this.data.id, e = "";
        return e = 1 == this.data.globaluser.fxs ? "/sudu8_page/showPro/showPro?id=" + a + "&userid=" + t : "/sudu8_page/showPro/showPro?id=" + a + "&userid=" + t + "&fxsid=" + t, 
        {
            title: this.data.title,
            path: e,
            success: function(t) {}
        };
    },
    change: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            a: a
        });
    },
    givepscore: function() {
        var t = this.data.id, a = this.data.userid, e = wx.getStorageSync("openid");
        a != e && 0 != a && app.util.request({
            url: "entry/wxapp/giveposcore",
            data: {
                id: t,
                types: "showPro",
                openid: e,
                fxsid: a
            },
            success: function(t) {}
        });
    },
    swiperChange: function(t) {
        this.setData({
            currentSwiper: t.detail.current
        });
    },
    share111: function() {
        this.setData({
            share: 1
        });
    },
    share_close: function() {
        this.setData({
            share: 0
        });
    },
    shareClo: function() {
        this.setData({
            shareShow: 0
        });
    },
    collect: function(t) {
        var e = this, i = t.currentTarget.dataset.name;
        if (1 == e.data.datas.is_saletwo) return wx.showModal({
            title: "提示",
            content: "该商品已下架,请选择其他商品",
            showCancel: !1,
            success: function() {
                wx.redirectTo({
                    url: "/sudu8_page/index/index"
                });
            }
        }), !1;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                var a = wx.getStorageSync("openid");
                app.util.request({
                    url: "entry/wxapp/Collect",
                    data: {
                        openid: a,
                        types: "showPro",
                        id: i
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(t) {
                        var a = t.data.data;
                        "收藏成功" == a ? e.setData({
                            sc: 1
                        }) : e.setData({
                            sc: 0
                        }), wx.showToast({
                            title: a,
                            icon: "succes",
                            duration: 1e3,
                            mask: !0
                        });
                    }
                });
            },
            fail: function() {
                var t = wx.getStorageSync("appcode");
                app.util.request({
                    url: "entry/wxapp/Appbase",
                    data: {
                        code: t
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(t) {
                        var a = t.data.data.openid;
                        wx.setStorage({
                            key: "openid",
                            data: t.data.data.openid,
                            success: function() {
                                app.util.request({
                                    url: "entry/wxapp/Collect",
                                    data: {
                                        openid: a,
                                        types: "showPro",
                                        id: i
                                    },
                                    header: {
                                        "content-type": "application/json"
                                    },
                                    success: function(t) {
                                        var a = t.data.data;
                                        "收藏成功" == a ? e.setData({
                                            sc: 1
                                        }) : e.setData({
                                            sc: 0
                                        }), wx.showToast({
                                            title: a,
                                            icon: "succes",
                                            duration: 1e3,
                                            mask: !0
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
    tobuy_before: function() {
        this.checkvip();
    },
    tobuy: function() {
        if (1 == this.data.datas.is_saletwo) return wx.showModal({
            title: "提示",
            content: "该商品已下架,请选择其他商品",
            showCancel: !1,
            success: function() {
                wx.redirectTo({
                    url: "/sudu8_page/index/index"
                });
            }
        }), !1;
        wx.navigateTo({
            url: "/sudu8_page/order_dan/order_dan?id=" + this.data.datas.id
        });
    }
}, "swiperChange", function(t) {
    this.setData({
        currentSwiper: t.detail.current
    });
}), _defineProperty(_Page, "goevaluate", function() {
    var t = this.data.id;
    wx.navigateTo({
        url: "/sudu8_page/evaluate_list/evaluate_list?id=" + t + "&protype=miaosha"
    });
}), _Page));