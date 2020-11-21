var WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        isplay: !1,
        minHeight: 220,
        bg: "",
        picList: [],
        pic_video: "",
        datas: "",
        sc: 0,
        nowcon: "con",
        is_comment: 0,
        comm: 0,
        commSelf: 0,
        comments: [],
        commShow: 0,
        shareShow: 0,
        shareScore: 0,
        shareNotice: 0,
        content: "",
        con2: "",
        con3: "",
        fxsid: 0,
        heighthave: 0,
        shareHome: 0,
        currentSwiper: 0,
        autoplay: !0
    },
    onPullDownRefresh: function() {
        var a = this, t = a.data.id;
        a.getShowPic(t), a.givepscore(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this, e = a.id;
        t.setData({
            id: e,
            autoplay: t.data.autoplay
        }), wx.showShareMenu({
            withShareTicket: !0
        });
        var s = 0;
        a.fxsid && (s = a.fxsid, t.setData({
            fxsid: a.fxsid,
            shareHome: 1
        })), a.userid && t.setData({
            userid: a.userid
        });
        var o = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: o,
            data: {
                vs1: 1
            },
            cachetime: "30",
            success: function(a) {
                a.data.data;
                t.setData({
                    baseinfo: a.data.data,
                    comm: a.data.data.commP,
                    comms: a.data.data.commPs
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(t.getinfos, s);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                e.setData({
                    openid: a.data
                });
                var t = e.data.id;
                e.getShowPic(t), e.givepscore();
            }
        });
    },
    playvideo: function() {
        var a = this;
        a.data.autoplay = !1, a.setData({
            isplay: !0,
            autoplay: a.data.autoplay
        });
    },
    endvideo: function() {
        var a = this;
        a.data.autoplay = !0, a.setData({
            isplay: !1,
            autoplay: a.data.autoplay
        });
    },
    follow: function(a) {
        var t = a.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/commentFollow",
            cachetime: "0",
            data: {
                id: t
            },
            success: function(a) {
                1 == a.data.data.result && wx.showToast({
                    title: "点赞成功",
                    icon: "success",
                    duration: 1e3
                });
            }
        });
    },
    pinglun: function(a) {
        this.setData({
            pinglun_t: a.detail.value
        });
    },
    pinglun_sub: function() {
        var a = this.data.pinglun_t, t = this.data.id, e = wx.getStorageSync("openid");
        if ("" == a || null == a) return wx.showModal({
            content: "评论不能为空"
        }), !1;
        app.util.request({
            url: "entry/wxapp/comment",
            cachetime: "30",
            data: {
                pinglun_t: a,
                id: t,
                openid: e
            },
            success: function(a) {
                1 == a.data.data.result && (wx.showToast({
                    title: "评价提交成功",
                    icon: "success",
                    duration: 2e3
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/sudu8_page_plugin_shop/goods_detail/goods_detail?id=" + t
                    });
                }, 2e3));
            }
        });
    },
    getShowPic: function(t) {
        var e = this, a = wx.getStorageSync("openid"), s = app.util.url("entry/wxapp/globaluserinfo", {
            m: "sudu8_page"
        });
        wx.request({
            url: s,
            data: {
                openid: a
            },
            success: function(a) {
                e.setData({
                    globaluser: a.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/showPro",
            data: {
                id: t,
                openid: a
            },
            cachetime: "30",
            success: function(a) {
                e.setData({
                    pic_video: a.data.data.video,
                    picList: a.data.data.images,
                    title: a.data.data.title,
                    datas: a.data.data,
                    sc: a.data.data.collectcount
                }), a.data.data.descp && WxParse.wxParse("content", "html", a.data.data.descp, e, 5), 
                a.data.data.con2 && WxParse.wxParse("con2", "html", a.data.data.con2, e, 5), a.data.data.con3 && WxParse.wxParse("con3", "html", a.data.data.con3, e, 5), 
                wx.setNavigationBarTitle({
                    title: e.data.title
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
            }
        }), setTimeout(function() {
            if ("1" == e.data.comm && "0" != e.data.commSelf || "1" == e.data.commSelf) {
                var a = e.data.comms;
                e.setData({
                    commShow: 1
                }), app.util.request({
                    url: "entry/wxapp/getComment",
                    cachetime: "0",
                    data: {
                        id: t,
                        comms: a
                    },
                    success: function(a) {
                        "" != a.data && e.setData({
                            comments: a.data.data,
                            is_comment: 1
                        });
                    }
                });
            }
        }, 500);
    },
    collect: function(a) {
        var s = this, o = a.currentTarget.dataset.name;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                var t = wx.getStorageSync("openid"), e = app.util.url("entry/wxapp/Collect", {
                    m: "sudu8_page"
                });
                wx.request({
                    url: e,
                    data: {
                        openid: t,
                        types: "shopsPro",
                        id: o
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(a) {
                        var t = a.data.data;
                        "收藏成功" == t ? s.setData({
                            sc: 1
                        }) : s.setData({
                            sc: 0
                        }), wx.showToast({
                            title: t,
                            icon: "succes",
                            duration: 1e3,
                            mask: !0
                        });
                    }
                });
            },
            fail: function() {
                var a = wx.getStorageSync("appcode"), t = app.util.url("entry/wxapp/Appbase", {
                    m: "sudu8_page"
                });
                wx.request({
                    url: t,
                    data: {
                        code: a
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(a) {
                        var t = a.data.data.openid;
                        wx.setStorage({
                            key: "openid",
                            data: a.data.data.openid,
                            success: function() {
                                var a = app.util.url("entry/wxapp/Collect", {
                                    m: "sudu8_page"
                                });
                                wx.request({
                                    url: a,
                                    data: {
                                        openid: t,
                                        types: "showPro",
                                        id: o
                                    },
                                    header: {
                                        "content-type": "application/json"
                                    },
                                    success: function(a) {
                                        var t = a.data.data;
                                        "收藏成功" == t ? s.setData({
                                            sc: 1
                                        }) : s.setData({
                                            sc: 0
                                        }), wx.showToast({
                                            title: t,
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
    tabChange: function(a) {
        var t = a.currentTarget.dataset.id;
        this.setData({
            nowcon: t
        });
    },
    swiperLoad: function(s) {
        var o = this;
        wx.getSystemInfo({
            success: function(a) {
                var t = s.detail.width / s.detail.height, e = a.windowWidth / t;
                o.data.heighthave || o.setData({
                    minHeight: e,
                    heighthave: 1
                });
            }
        });
    },
    makePhoneCall: function(a) {
        var t = this.data.baseinfo.tel;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    makePhoneCallB: function(a) {
        var t = this.data.baseinfo.tel_b;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    openMap: function(a) {
        wx.openLocation({
            latitude: parseFloat(this.data.baseinfo.latitude),
            longitude: parseFloat(this.data.baseinfo.longitude),
            name: this.data.baseinfo.name,
            address: this.data.baseinfo.address,
            scale: 22
        });
    },
    share_close: function() {
        this.setData({
            share: 0
        });
    },
    share111: function() {
        this.setData({
            share: 1
        });
    },
    onShareAppMessage: function() {
        var a = wx.getStorageSync("openid"), t = this.data.id, e = "";
        return e = 1 == this.data.globaluser.fxs ? "/sudu8_page_plugin_shop/goods_detail/goods_detail?id=" + t + "&userid=" + a : "/sudu8_page_plugin_shop/goods_detail/goods_detail?id=" + t + "&fxsid=" + a + "&userid=" + a, 
        {
            title: this.data.title,
            path: e,
            success: function(a) {}
        };
    },
    givepscore: function() {
        var a = this.data.id, t = this.data.userid, e = wx.getStorageSync("openid");
        if (t != e && 0 != t && "" != t) {
            var s = app.util.url("entry/wxapp/giveposcore", {
                m: "sudu8_page"
            });
            wx.request({
                url: s,
                data: {
                    id: a,
                    types: "shopsPro",
                    openid: e,
                    fxsid: t
                },
                success: function(a) {}
            });
        }
    },
    swiperChange: function(a) {
        this.data.autoplay = !0, this.setData({
            currentSwiper: a.detail.current,
            isplay: !1,
            autoplay: this.data.autoplay
        });
    }
});