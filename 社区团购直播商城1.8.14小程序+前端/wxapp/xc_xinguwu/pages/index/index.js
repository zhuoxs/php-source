var app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {
        labelact: 0,
        style: 1,
        ppt: null,
        voucher: null,
        slideWidth: "",
        slideLeft: 0,
        totalLength: "",
        slideShow: !1,
        alllist: [ {
            one: [ {
                name: "拼团1",
                icon: "../../images/group-menu.png"
            }, {
                name: "拼团2",
                icon: "../../images/group-menu.png"
            }, {
                name: "拼团3",
                icon: "../../images/group-menu.png"
            }, {
                name: "拼团1",
                icon: "../../images/group-menu.png"
            }, {
                name: "拼团1",
                icon: "../../images/group-menu.png"
            }, {
                name: "拼团1",
                icon: "../../images/group-menu.png"
            } ],
            two: [],
            three: []
        } ],
        navbar_param: {
            icon_size: 80,
            spacing: 10,
            text_size: 24,
            text_color: "#5a5a5a"
        },
        curIndex: 4
    },
    bindtransition: function(a) {},
    imageLoad: function(a) {
        var t = a.detail.width, e = 100 * a.detail.height / t;
        this.setData({
            bannerHeight: e
        });
    },
    get_voucher: function(a) {
        var t = this, e = a.currentTarget.dataset.index, o = this.data.voucher, l = o[e].id;
        wx.showLoading({
            title: "领取中"
        }), 2 != o[e].status ? 1 == o[e].numlimt && o[e].num <= 0 ? wx.showToast({
            title: "已取完"
        }) : app.util.request({
            url: "entry/wxapp/index",
            showLoading: !1,
            method: "POST",
            data: {
                op: "get_voucher",
                id: l
            },
            success: function(a) {
                wx.showToast({
                    title: a.data.message
                }), o.splice(e, 1), t.setData({
                    voucher: o
                });
            }
        }) : wx.showToast({
            title: "已领取"
        });
    },
    swiperChange: function(a) {
        this.setData({
            swiperIndex: a.detail.current
        });
    },
    change: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            curIndex: t
        });
    },
    labelchange: function(a) {
        var t = a.currentTarget.dataset.value;
        this.setData({
            labelact: t
        });
    },
    onLoad: function(a) {
        4 == app.globalData.webset.home_style && wx.redirectTo({
            url: "/xc_xinguwu/minor/index/index"
        });
        var i = this, t = [], e = [];
        app.globalData.webset.home_club_label_bgcolour && t.push("background-color:" + app.globalData.webset.home_club_label_bgcolour), 
        app.globalData.webset.home_club_label_fontcolour && t.push("color:" + app.globalData.webset.home_club_label_fontcolour), 
        app.globalData.webset.home_club_label_actbgcolour && e.push("background-color:" + app.globalData.webset.home_club_label_actbgcolour), 
        app.globalData.webset.home_club_label_actfontcolour && e.push("color:" + app.globalData.webset.home_club_label_actfontcolour);
        var o = {
            labelsstyles: t.join(";"),
            actlabels: e.join(";"),
            webset: app.globalData.webset,
            group_show: app.globalData.webset.group_buy,
            bargain_show: app.globalData.webset.bargain,
            flash_show: app.globalData.webset.flash_sale,
            score_shop_show: app.globalData.webset.score_shop,
            voucher_index_style: app.globalData.webset.voucher_index_style,
            voucher_index_diy: app.globalData.webset.voucher_index_diy,
            voucher_index_bg: app.globalData.webset.voucher_index_bg,
            official_account: app.globalData.webset.official_account,
            flow_main: app.globalData.webset.flow_main,
            flow_main_id: app.globalData.webset.flow_main_id,
            community: app.globalData.webset.community,
            live: app.globalData.webset.live,
            home_style_2_bg: app.globalData.webset.home_style_2_bg,
            home_style_2_color: app.globalData.webset.home_style_2_color,
            vip: app.globalData.webset.vip,
            discount: app.globalData.userInfo && app.globalData.userInfo.member ? app.globalData.userInfo.member.discount : null
        };
        1 == app.globalData.webset.openlabel && app.util.request({
            url: "entry/wxapp/label",
            showLoading: !1,
            method: "POST",
            data: {
                op: "getdata"
            },
            success: function(a) {
                var t = a.data.data, e = 0;
                for (var o in t) {
                    e = o;
                    break;
                }
                0 != e && i.setData({
                    labeldata: t,
                    labelact: e
                });
            }
        }), i.setData(o), wx.setNavigationBarTitle({
            title: app.globalData.webset.webname
        }), app.util.request({
            url: "entry/wxapp/index",
            showLoading: !1,
            method: "POST",
            data: {
                op: "home_page"
            },
            success: function(a) {
                i.setData({
                    style: app.globalData.webset.home_style
                });
                var t = app.globalData.webset.home_style;
                if (3 == t) ; else {
                    var e = a.data;
                    if (e.data.voucher && 0 < e.data.voucher.length && i.setData({
                        voucher: e.data.voucher
                    }), e.data.goods && i.setData({
                        goods: e.data.goods
                    }), e.data.bargain && i.setData({
                        bargain: e.data.bargain
                    }), e.data.group && i.setData({
                        group: e.data.group
                    }), e.data.flash && (i.count_limit_time(e.data.flash.date_end), i.setData({
                        flash: e.data.flash
                    })), e.data.ppt && i.setData({
                        ppt: e.data.ppt
                    }), e.data.special && i.setData({
                        special: e.data.special
                    }), e.data.ad && i.setData({
                        ad: e.data.ad
                    }), e.data.navbar) {
                        var o = JSON.parse(JSON.stringify(e.data.navbar)), l = i.data.alllist;
                        l[0].one = o.list, i.setData({
                            alllist: l,
                            navbar_param: o.param
                        }), i.countnav();
                    }
                    if (e.data.navbar && (app.toolbar = e.data.navbar), (2 == t || 1 == t) && 1 == app.globalData.webset.community) {
                        var n = app.club;
                        null == n ? wx.getLocation({
                            success: function(a) {
                                i.setData({
                                    longitude: a.longitude,
                                    latitude: a.latitude
                                }), app.util.request({
                                    url: "entry/wxapp/community",
                                    showLoading: !0,
                                    data: {
                                        op: "clubList",
                                        longitude: a.longitude,
                                        latitude: a.latitude,
                                        page: 1,
                                        pagesize: 1
                                    },
                                    success: function(a) {
                                        i.setData({
                                            club: a.data.data.clubList[0]
                                        }), app.club = a.data.data.clubList[0];
                                    },
                                    fail: function() {
                                        i.setData({
                                            loadend: !0
                                        });
                                    }
                                });
                            }
                        }) : i.setData({
                            club: n
                        });
                    }
                }
            }
        });
    },
    todetail: function(a) {
        wx.navigateTo({
            url: "../detail/detail?id=" + this.data.goods[a.currentTarget.dataset.index].id
        });
    },
    onReady: function() {
        app.look.footer(this), app.look.navbar(this), app.look.accredit(this);
        var a = {};
        a.toLive = app.module_url + "resource/wxapp/index/toLive.png", 2 == app.globalData.webset.home_style && (a.index_nav1 = app.module_url + "resource/wxapp/index/index-nav1.png", 
        a.index_nav2 = app.module_url + "resource/wxapp/index/index-nav2.png", a.index_nav3 = app.module_url + "resource/wxapp/index/index-nav3.png", 
        a.index_nav4 = app.module_url + "resource/wxapp/index/index-nav4.png", a.index_snav1 = app.module_url + "resource/wxapp/index/index-snav1.png", 
        a.index_snav2 = app.module_url + "resource/wxapp/index/index-snav2.png", a.index_snav3 = app.module_url + "resource/wxapp/index/index-snav3.png", 
        a.index_snav4 = app.module_url + "resource/wxapp/index/index-snav4.png", a.living = app.module_url + "resource/wxapp/index/living.png"), 
        this.setData({
            images: a
        });
    },
    onGotUserInfo: function(a) {
        app.look.getuserinfo(a, this);
    },
    sortsvoucher: function(a) {
        for (var t = [], e = [], o = 0, l = a.length; o < l; o++) 1 == a[o].status ? t.push(a[o]) : e.push(a[o]);
        return t.concat(e);
    },
    onShow: function() {
        null != app.club && this.setData({
            club: app.club
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var l = this;
        app.util.request({
            url: "entry/wxapp/index",
            showLoading: !0,
            method: "POST",
            data: {
                op: "home_page"
            },
            success: function(a) {
                if (wx.stopPullDownRefresh(), l.setData({
                    style: app.globalData.webset.home_style
                }), 3 == l.data.style) ; else {
                    var t = a.data;
                    if (t.data.voucher && (l.setData({
                        voucher: t.data.voucher
                    }), l.onShow()), t.data.goods && l.setData({
                        goods: t.data.goods
                    }), t.data.bargain && l.setData({
                        bargain: t.data.bargain
                    }), t.data.group && l.setData({
                        group: t.data.group
                    }), t.data.flash && (l.count_limit_time(t.data.flash.date_end), l.setData({
                        flash: t.data.flash
                    })), t.data.ppt && l.setData({
                        ppt: t.data.ppt
                    }), t.data.special && l.setData({
                        special: t.data.special
                    }), t.data.ad && l.setData({
                        ad: t.data.ad
                    }), t.data.navbar) {
                        var e = JSON.parse(JSON.stringify(t.data.navbar)), o = l.data.alllist;
                        o[0].one = e.list, l.setData({
                            alllist: o,
                            navbar_param: e.param
                        }), l.countnav();
                    }
                }
            }
        });
    },
    count_limit_time: function(a) {
        var t = new Date(), e = new Date(app.look.change_date(a));
        this.countDown(parseInt((e - t) / 1e3));
    },
    onReachBottom: function() {},
    onShareAppMessage: function(a) {
        wx.showShareMenu({
            withShareTicket: !0
        });
        var t = app.globalData.webset;
        if ("menu" == a.from) {
            var e = "", o = "";
            return e = "" != t.title && null != t.title ? t.title : t.webname, o = "" != t.imgurl && null != t.imgurl ? t.imgurl : "", 
            {
                title: e,
                path: "/xc_xinguwu/pages/base/base?userid=" + app.globalData.userInfo.id,
                imageUrl: o,
                success: function(a) {
                    wx.showToast({
                        title: "转发成功"
                    });
                },
                fail: function(a) {}
            };
        }
    },
    countnav: function() {
        var a = this.data.alllist, t = this.data.alllist[0].one, e = Math.floor(t.length / 2);
        a[0].two, a[0].three;
        10 <= t.length && t.length % 2 != 0 ? (a[0].two = t.slice(0, e + 1), a[0].three = t.slice(e + 1, t.length)) : 10 <= t.length && t.length % 2 == 0 ? (a[0].two = t.slice(0, e), 
        a[0].three = t.slice(e, t.length)) : 5 < t.length < 10 && (a[0].two = t.slice(0, 5), 
        a[0].three = t.slice(5, t.length));
        var o = wx.getSystemInfoSync();
        this.setData({
            alllist: a,
            windowHeight: o.windowHeight,
            windowWidth: o.windowWidth
        }), this.getRatio();
    },
    getRatio: function() {
        var a = this.data.alllist, t = (this.data.alllist[0].one, a[0].two);
        if (!t.length || t.length <= 5) this.setData({
            slideShow: !1
        }); else {
            var e = 150 * this.data.alllist[0].two.length, o = 230 / e * (750 / this.data.windowWidth), l = 750 / e * 230;
            this.setData({
                slideWidth: l,
                totalLength: e,
                slideShow: !0,
                slideRatio: o,
                alllist: a
            });
        }
    },
    getleft: function(a) {
        this.setData({
            slideLeft: a.detail.scrollLeft * this.data.slideRatio
        });
    },
    countDown: function(p) {
        console.log("cc");
        var u = this;
        clearInterval(this.data.interval);
        var d = setInterval(function() {
            var a = p, t = Math.floor(a / 3600 / 24), e = t.toString();
            1 == e.length && (e = "0" + e);
            var o = Math.floor((a - 3600 * t * 24) / 3600), l = o.toString();
            1 == l.length && (l = "0" + l);
            var n = Math.floor(a / 3600).toString();
            1 == n.length && (n = "0" + n);
            var i = Math.floor((a - 3600 * t * 24 - 3600 * o) / 60), s = i.toString();
            1 == s.length && (s = "0" + s);
            var r = (a - 3600 * t * 24 - 3600 * o - 60 * i).toString();
            1 == r.length && (r = "0" + r), u.setData({
                countHour: n,
                countDownDay: e,
                countDownHour: l,
                countDownMinute: s,
                countDownSecond: r
            }), --p < 0 && (clearInterval(d), u.setData({
                countHour: "00",
                countDownDay: "00",
                countDownHour: "00",
                countDownMinute: "00",
                countDownSecond: "00"
            }));
        }.bind(u), 1e3);
        u.setData({
            interval: d
        });
    }
});