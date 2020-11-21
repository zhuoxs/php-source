function t(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var e, a, o = getApp(), i = o.requirejs("core"), s = (o.requirejs("icons"), o.requirejs("foxui")), n = o.requirejs("biz/diypage"), r = o.requirejs("biz/diyform"), c = o.requirejs("biz/goodspicker"), d = o.requirejs("jquery"), l = o.requirejs("wxParse/wxParse"), u = 0, g = o.requirejs("biz/selectdate");

Page((a = {
    data: (e = {
        diypages: {},
        usediypage: !1,
        specs: [],
        options: [],
        icons: o.requirejs("icons"),
        goods: {},
        indicatorDots: !0,
        autoplay: !0,
        interval: 5e3,
        duration: 500,
        circular: !0,
        play: "/static/images/video_play.png",
        mute: "/static/images/icon/mute.png",
        voice: "/static/images/icon/voice.png",
        active: "",
        slider: "",
        tempname: "",
        info: "active",
        preselltimeend: "",
        presellsendstatrttime: "",
        advWidth: 0,
        dispatchpriceObj: 0,
        now: parseInt(Date.now() / 1e3),
        day: 0,
        hour: 0,
        minute: 0,
        second: 0,
        timer: 0,
        discountTitle: "",
        istime: 1,
        istimeTitle: "",
        isSelected: !1,
        params: {},
        total: 1,
        optionid: 0,
        audios: {},
        audiosObj: {},
        defaults: {
            id: 0,
            merchid: 0
        },
        buyType: "",
        pickerOption: {},
        specsData: [],
        specsTitle: "",
        canBuy: "",
        diyform: {},
        showPicker: !1,
        showcoupon: !1,
        pvalOld: [ 0, 0, 0 ],
        pval: [ 0, 0, 0 ],
        areas: [],
        noArea: !0,
        commentObj: {},
        commentObjTab: 1,
        loading: !1,
        commentEmpty: !1,
        commentPage: 1,
        commentTotal: 1,
        commentLevel: "all",
        commentList: [],
        closeBtn: !1,
        soundpic: !0,
        animationData: {},
        uid: "",
        stararr: [ "all", "good", "normal", "bad", "pic" ],
        nav_mask: !1,
        nav_mask2: !1,
        nav: 0,
        giftid: "",
        limits: !0,
        modelShow: !1,
        showgoods: !0
    }, t(e, "timer", 0), t(e, "lasttime", 0), t(e, "hour", "-"), t(e, "min", "-"), t(e, "sec", "-"), 
    t(e, "currentDate", ""), t(e, "dayList", ""), t(e, "currentDayList", ""), t(e, "currentObj", ""), 
    t(e, "currentDay", ""), t(e, "checkedDate", ""), t(e, "showDate", ""), t(e, "scope", ""), 
    t(e, "goods_hint_show", !1), t(e, "presellisstart", 0), t(e, "advHeight", 1), t(e, "show_goods", !0), 
    e),
    imageLoad: function(t) {
        var e = t.detail.height, a = t.detail.width, o = Math.floor(750 * e / a);
        e == a ? this.setData({
            advHeight: 750
        }) : this.setData({
            advHeight: o
        });
    },
    favorite: function(t) {
        o.checkAuth();
        var e = this;
        if (e.data.limits) {
            var a = t.currentTarget.dataset.isfavorite ? 0 : 1;
            i.get("member/favorite/toggle", {
                id: e.data.options.id,
                isfavorite: a
            }, function(t) {
                t.isfavorite ? e.setData({
                    "goods.isfavorite": 1
                }) : e.setData({
                    "goods.isfavorite": 0
                });
            });
        }
    },
    goodsTab: function(t) {
        var e = this, a = t.currentTarget.dataset.tap;
        if ("info" == a) this.setData({
            info: "active",
            para: "",
            comment: ""
        }); else if ("para" == a) this.setData({
            info: "",
            para: "active",
            comment: ""
        }); else if ("comment" == a) {
            if (e.setData({
                info: "",
                para: "",
                comment: "active"
            }), e.data.commentList.length > 0) return void e.setData({
                loading: !1
            });
            e.setData({
                loading: !0
            }), i.get("goods/get_comment_list", {
                id: e.data.options.id,
                level: e.data.commentLevel,
                page: e.data.commentPage
            }, function(t) {
                t.list.length > 0 ? e.setData({
                    loading: !1,
                    commentList: t.list,
                    commentTotal: t.total,
                    commentPage: t.page
                }) : e.setData({
                    loading: !1,
                    commentEmpty: !0
                });
            });
        }
    },
    onReachBottom: function() {
        var t = this;
        if (t.data.commentTotal <= 10) return !1;
        var e = t.data.commentObjTab, a = "";
        1 == e ? a = "all" : 2 == e ? a = "good" : 3 == e ? a = "normal" : 4 == e ? a = "bad" : 5 == e && (a = "pic"), 
        t.setData({
            loading: !0
        }), i.get("goods/get_comment_list", {
            id: t.data.options.id,
            level: a,
            page: t.data.commentPage
        }, function(e) {
            0 == e.error && (t.setData({
                loading: !1
            }), e.list.length > 0 && t.setData({
                commentPage: t.data.commentPage + 1,
                commentTotal: e.total,
                commentList: t.data.commentList.concat(e.list)
            }));
        });
    },
    comentTap: function(t) {
        var e = this, a = t.currentTarget.dataset.type, o = "";
        1 == a ? (o = "all", e.data.commentPage = 1) : 2 == a ? (e.data.commentPage = 1, 
        o = "good") : 3 == a ? (e.data.commentPage = 1, o = "normal") : 4 == a ? (e.data.commentPage = 1, 
        o = "bad") : 5 == a && (e.data.commentPage = 1, o = "pic"), a != e.data.commentObjTab && i.get("goods/get_comment_list", {
            id: e.data.options.id,
            level: o,
            page: e.data.commentPage
        }, function(t) {
            t.list.length > 0 && e.setData({
                loading: !1,
                commentList: t.list,
                commentTotal: t.total,
                commentPage: t.page,
                commentObjTab: a,
                commentEmpty: !1
            });
        });
    },
    preview: function(t) {
        wx.previewImage({
            current: t.currentTarget.dataset.src,
            urls: t.currentTarget.dataset.urls
        });
    },
    getDetail: function(t) {
        var e = this, a = parseInt(Date.now() / 1e3);
        e.setData({
            loading: !0
        }), i.get("goods/get_detail", {
            id: t.id
        }, function(t) {
            if (0 != t.error) return e.setData({
                show: !0,
                showgoods: !1
            }), s.toast(e, t.message), void setTimeout(function() {
                wx.navigateBack();
            }, 1500);
            [ "marketprice", "productprice" ].forEach(function(e) {
                void 0 !== t.goods[e] && (t.goods[e] = parseFloat(t.goods[e]));
            });
            var o = t.goods.coupons, n = t.goods.thumbMaxHeight;
            t.goods.thumbMaxWidth;
            if (e.setData({
                coupon: o,
                coupon_l: o.length,
                packagegoods: t.goods.packagegoods,
                packagegoodsid: t.goods.packagegoods.goodsid || 0,
                credittext: t.goods.credittext,
                activity: t.goods.activity,
                bottomFixedImageUrls: t.goods.bottomFixedImageUrls,
                phonenumber: t.goods.phonenumber || "",
                showDate: t.goods.showDate || "",
                scope: t.goods.scope || "",
                show_goods: t.goods.show_goods
            }), t.goods.packagegoods && e.package(), l.wxParse("wxParseData", "html", t.goods.content, e, "0"), 
            l.wxParse("wxParseData_buycontent", "html", t.goods.buycontent, e, "0"), e.setData({
                show: !0,
                goods: t.goods,
                minprice: t.goods.minprice,
                maxprice: t.goods.maxprice,
                preselltimeend: t.goods.preselltimeend,
                style: t.goods.labelstyle.style || "",
                navbar: t.goods.navbar,
                labels: t.goods.labels
            }), t.goods.gifts && 1 == t.goods.gifts.length && e.setData({
                giftid: t.goods.gifts[0].id
            }), wx.setNavigationBarTitle({
                title: t.goods.title || "商品详情"
            }), u = t.goods.hasoption, d.isEmptyObject(t.goods.dispatchprice) || "string" == typeof t.goods.dispatchprice ? e.setData({
                dispatchpriceObj: 0
            }) : e.setData({
                dispatchpriceObj: 1
            }), t.goods.isdiscount > 0 && t.goods.isdiscount_time >= a) {
                clearInterval(e.data.timer);
                r = setInterval(function() {
                    e.countDown(0, t.goods.isdiscount_time);
                }, 1e3);
                e.setData({
                    timer: r
                });
            } else e.setData({
                discountTitle: "活动已结束"
            });
            if (t.goods.istime > 0) {
                clearInterval(e.data.timer);
                r = setInterval(function() {
                    e.countDown(t.goods.timestart, t.goods.timeend, "istime");
                }, 1e3);
                e.setData({
                    timer: r
                });
            }
            if (t.goods.ispresell > 0) {
                var r = setInterval(function() {
                    0 == t.goods.canbuy ? e.countDown(a, t.goods.preselltimestart, "istime") : 1 == t.goods.canbuy && e.countDown(a, t.goods.preselltimeend, "istime");
                }, 1e3);
                e.setData({
                    timer: r,
                    presellisstart: t.goods.presellisstart
                }), e.setData({
                    preselltimeend: t.goods.preselltimeend || t.goods.preselltimeend.getMonth() + "月" + t.goods.preselltimeend || t.goods.preselltimeend.getDate() + "日 " + t.goods.preselltimeend || t.goods.preselltimeend.getHours() + ":" + t.goods.preselltimeend || t.goods.preselltimeend.getMinutes() + ":" + t.goods.preselltimeend || t.goods.preselltimeend.getSeconds(),
                    presellsendstatrttime: t.goods.presellsendstatrttime || t.goods.presellsendstatrttime.getMonth() + "月" + t.goods.presellsendstatrttime || t.goods.presellsendstatrttime.getDate() + "日"
                });
            }
            t.goods.getComments > 0 && i.get("goods/get_comments", {
                id: e.data.options.id
            }, function(t) {
                e.setData({
                    commentObj: t
                });
            }), t.goods.fullbackgoods && e.setData({
                fullbackgoods: t.goods.fullbackgoods
            });
            var c = e.data.fullbackgoods;
            if (void 0 != c) {
                var g = c.maxfullbackratio, m = c.maxallfullbackallratio, g = Math.round(g), m = Math.round(m);
                e.setData({
                    maxfullbackratio: g,
                    maxallfullbackallratio: m
                });
            }
            9 == t.goods.type && (e.setData({
                checkedDate: t.goods.nowDate
            }), e.show_cycelbuydate()), t.goods.seckillinfo && e.initSeckill(t.goods);
        });
    },
    initSeckill: function(t) {
        var e = this, a = parseInt(t.seckillinfo.status), i = t.seckillinfo.starttime, s = t.seckillinfo.endtime;
        if (-1 != a) {
            var n = 0, r = 0, c = o.globalData.approot;
            wx.request({
                url: c + "map.json",
                success: function(o) {
                    var c = new Date(o.header.Date) / 1e3;
                    n = 0 == a ? s - c : i - c, e.setData({
                        lasttime: n
                    }), clearInterval(e.data.timer), e.setTimer(t.seckillinfo), r = e.setTimerInterval(t.seckillinfo), 
                    e.setData({
                        timer: r
                    });
                }
            });
        }
    },
    setTimer: function(t) {
        var e = this, a = 0;
        if (-1 != t.status && parseInt(e.data.lasttime) % 10 == 0) {
            var i = parseInt(t.status), s = t.starttime, n = t.endtime;
            if (-1 != i) {
                var r = o.globalData.approot;
                wx.request({
                    url: r + "map.json",
                    success: function(t) {
                        var o = new Date(t.header.Date) / 1e3;
                        a = 0 == i ? n - o : s - o, e.setData({
                            lasttime: a
                        });
                    }
                });
            }
        }
        a = parseInt(e.data.lasttime) - 1;
        var c = e.formatSeconds(a);
        e.setData({
            lasttime: a,
            hour: c.hour,
            min: c.min,
            sec: c.sec
        }), a <= 0 && e.onLoad();
    },
    setTimerInterval: function(t) {
        var e = this;
        return setInterval(function() {
            e.setTimer(t);
        }, 1e3);
    },
    formatSeconds: function(t) {
        var e = parseInt(t), a = 0, o = 0;
        return e > 60 && (a = parseInt(e / 60), e = parseInt(e % 60), a > 60 && (o = parseInt(a / 60), 
        a = parseInt(a % 60))), {
            hour: o < 10 ? "0" + o : o,
            min: a < 10 ? "0" + a : a,
            sec: e < 10 ? "0" + e : e
        };
    },
    countDown: function(t, e, a) {
        var o = parseInt(Date.now() / 1e3), i = (t > o ? t : e) - o, s = parseInt(i), n = Math.floor(s / 86400), r = Math.floor((s - 24 * n * 60 * 60) / 3600), c = Math.floor((s - 24 * n * 60 * 60 - 3600 * r) / 60), d = [ n, r, c, Math.floor(s - 24 * n * 60 * 60 - 3600 * r - 60 * c) ];
        if (this.setData({
            time: d
        }), "istime") {
            var l = "";
            t > o ? l = "距离限时购开始" : t <= o && e > o ? l = "距离限时购结束" : (l = "活动已经结束，下次早点来~", 
            this.setData({
                istime: 0
            })), this.setData({
                istimeTitle: l
            });
        }
    },
    cityPicker: function(t) {
        var e = this;
        t.currentTarget.dataset.tap;
        wx.navigateTo({
            url: "/pages/goods/region/index?id=" + e.data.goods.id + "&region=" + e.data.goods.citys.citys + "&onlysent=" + e.data.goods.citys.onlysent
        });
    },
    giftPicker: function() {
        this.setData({
            active: "active",
            gift: !0
        });
    },
    couponPicker: function() {
        this.setData({
            active: "active",
            showcoupon: !0
        });
    },
    couponrecived: function(t) {
        var e = t.currentTarget.dataset.id, a = this;
        i.post("goods.pay_coupon", {
            id: e
        }, function(t) {
            0 == t.error ? (a.setData({
                showcoupon: !1,
                active: ""
            }), s.toast(a, "已领取")) : s.toast(a, t.message);
        });
    },
    selectPicker: function(t) {
        o.checkAuth();
        var e = this, a = t.currentTarget.dataset.time, i = t.currentTarget.dataset.timeout;
        if (e.data.limits) {
            if ("timeout" == a || "access_time" == a) {
                if ("false" == i) return void e.setData({
                    goods_hint_show: !0
                });
                if ("true" == i) {
                    if ("access_time" == a) {
                        e.setData({
                            goods_hint_show: !1
                        });
                        s = "goodsdetail";
                        return void c.selectpicker(t, e, s);
                    }
                    if ("timeout" == a) return void e.setData({
                        goods_hint_show: !1
                    });
                }
            }
            var s = "goodsdetail";
            c.selectpicker(t, e, s);
        }
    },
    specsTap: function(t) {
        var e = this;
        c.specsTap(t, e);
    },
    emptyActive: function() {
        this.setData({
            active: "",
            slider: "out",
            tempname: "",
            showcoupon: !1,
            gift: !1,
            cycledate: !1
        });
    },
    buyNow: function(t) {
        var e = this;
        c.buyNow(t, e, "goods_detail");
    },
    getCart: function(t) {
        var e = this;
        c.getCart(t, e);
    },
    select: function() {
        var t = this, e = t.data.optionid;
        t.data.diyform;
        u > 0 && 0 == e ? s.toast(t, "请选择规格") : this.setData({
            active: "",
            slider: "out",
            isSelected: !0,
            tempname: ""
        });
    },
    inputNumber: function(t) {
        var e = this;
        c.inputNumber(t, e);
    },
    number: function(t) {
        var e = this;
        c.number(t, e);
    },
    onLoad: function(t) {
        var e = this;
        e.setData({
            imgUrl: o.globalData.approot
        }), i.get("black", {}, function(t) {
            t.isblack && wx.showModal({
                title: "无法访问",
                content: "您在商城的黑名单中，无权访问！",
                success: function(t) {
                    t.confirm && this.close(), t.cancel && this.close();
                }
            });
        }), n.get(this, "goodsdetail", function(t) {
            var a = t.diypage.items;
            for (var o in a) "copyright" == a[o].id && e.setData({
                copyright: a[o]
            });
        }), t = t || {};
        var a = decodeURIComponent(t.scene);
        if (!t.id && a) {
            var s = i.str2Obj(a);
            t.id = s.id, s.mid && (t.mid = s.mid);
        }
        this.setData({
            id: t.id
        }), o.url(t), wx.getSystemInfo({
            success: function(t) {
                e.setData({
                    windowWidth: t.windowWidth,
                    windowHeight: t.windowHeight
                });
            }
        }), e.getDetail(t), e.setData({
            uid: t.id,
            options: t,
            success: !0,
            cover: !0,
            showvideo: !0
        }), wx.getSystemInfo({
            success: function(t) {
                e.setData({
                    advWidth: t.windowWidth
                });
            }
        }), setTimeout(function() {
            e.setData({
                areas: o.getCache("cacheset").areas
            });
        }, 3e3);
    },
    show_cycelbuydate: function() {
        var t = this, e = g.getCurrentDayString(this, t.data.showDate), a = [ "周日", "周一", "周二", "周三", "周四", "周五", "周六" ];
        t.setData({
            currentObj: e,
            currentDate: e.getFullYear() + "年" + (e.getMonth() + 1) + "月" + e.getDate() + "日 " + a[e.getDay()],
            currentYear: e.getFullYear(),
            currentMonth: e.getMonth() + 1,
            currentDay: e.getDate(),
            initDate: Date.parse(e.getFullYear() + "/" + (e.getMonth() + 1) + "/" + e.getDate()),
            checkedDate: Date.parse(e.getFullYear() + "/" + (e.getMonth() + 1) + "/" + e.getDate()),
            maxday: t.data.scope
        });
    },
    package: function() {
        var t = this;
        i.get("package.get_list", {
            goodsid: this.data.packagegoodsid
        }, function(e) {
            t.setData({
                packageList: e.list[0]
            });
        });
    },
    onShow: function() {
        var t = this;
        o.getCache("isIpx") ? t.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : t.setData({
            isIpx: !1,
            iphonexnavbar: ""
        }), wx.getStorage({
            key: "mydata",
            success: function(e) {
                wx.removeStorage({
                    key: "mydata",
                    success: function(t) {}
                }), t.getDetail(e.data), wx.pageScrollTo({
                    scrollTop: 0
                });
            }
        }), wx.getSetting({
            success: function(e) {
                var a = e.authSetting["scope.userInfo"];
                t.setData({
                    limits: a
                });
            }
        });
    },
    onChange: function(t) {
        return r.onChange(this, t);
    },
    DiyFormHandler: function(t) {
        return r.DiyFormHandler(this, t);
    },
    selectArea: function(t) {
        return r.selectArea(this, t);
    },
    bindChange: function(t) {
        return r.bindChange(this, t);
    },
    onCancel: function(t) {
        return r.onCancel(this, t);
    },
    onConfirm: function(t) {
        return r.onConfirm(this, t);
    },
    getIndex: function(t, e) {
        return r.getIndex(t, e);
    },
    onShareAppMessage: function() {
        return this.setData({
            closeBtn: !1
        }), i.onShareAppMessage("/pages/goods/detail/index?id=" + this.data.options.id, this.data.goods.title);
    },
    showpic: function() {
        this.setData({
            showpic: !0,
            cover: !1,
            showvideo: !1
        }), this.videoContext = wx.createVideoContext("myVideo"), this.videoContext.pause();
    },
    showvideo: function() {
        this.setData({
            showpic: !1,
            showvideo: !0
        }), this.videoContext = wx.createVideoContext("myVideo"), this.videoContext.play();
    },
    startplay: function() {
        this.setData({
            cover: !1
        }), this.videoContext = wx.createVideoContext("myVideo"), this.videoContext.play();
    },
    bindfullscreenchange: function(t) {
        1 == t.detail.fullScreen ? this.setData({
            success: !1
        }) : this.setData({
            success: !0
        });
    },
    phone: function() {
        var t = this.data.phonenumber + "";
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    sharePoster: function() {
        wx.navigateTo({
            url: "/pages/goods/poster/poster?id=" + this.data.uid
        });
    },
    closeBtn: function() {
        this.setData({
            closeBtn: !1
        });
    },
    onHide: function() {
        this.setData({
            closeBtn: !1
        });
    },
    showshade: function() {
        o.checkAuth(), this.setData({
            closeBtn: !0
        });
    },
    nav: function() {
        this.setData({
            nav_mask: !this.data.nav_mask
        });
    },
    nav2: function() {
        this.setData({
            nav_mask2: !this.data.nav_mask2
        });
    },
    changevoice: function() {
        this.data.sound ? this.setData({
            sound: !1,
            soundpic: !0
        }) : this.setData({
            sound: !0,
            soundpic: !1
        });
    },
    radioChange: function(t) {
        this.setData({
            giftid: t.currentTarget.dataset.giftgoodsid,
            gift_title: t.currentTarget.dataset.title
        });
    },
    activityPicker: function() {
        this.setData({
            fadein: "in"
        });
    },
    actOutPicker: function() {
        this.setData({
            fadein: ""
        });
    },
    hintclick: function() {
        wx.openSetting({
            success: function(t) {}
        });
    },
    cancelclick: function() {
        this.setData({
            modelShow: !1
        });
    },
    confirmclick: function() {
        this.setData({
            modelShow: !1
        }), wx.openSetting({
            success: function(t) {}
        });
    },
    sendclick: function() {
        wx.navigateTo({
            url: "/pages/map/index"
        });
    },
    syclecancle: function() {
        this.setData({
            cycledate: !1
        });
    },
    sycleconfirm: function() {
        this.setData({
            cycledate: !1
        });
    },
    editdate: function(t) {
        g.setSchedule(this), this.setData({
            cycledate: !0
        });
    },
    doDay: function(t) {
        g.doDay(t, this);
    },
    selectDay: function(t) {
        g.selectDay(t, this), g.setSchedule(this);
    },
    play: function(t) {
        var e = t.target.dataset.id, a = this.data.audiosObj[e] || !1;
        if (!a) {
            a = wx.createInnerAudioContext("audio_" + e);
            var o = this.data.audiosObj;
            o[e] = a, this.setData({
                audiosObj: o
            });
        }
        var i = this;
        a.onPlay(function() {
            var t = setInterval(function() {
                var o = a.currentTime / a.duration * 100 + "%", s = Math.floor(Math.ceil(a.currentTime) / 60), n = (Math.ceil(a.currentTime) % 60 / 100).toFixed(2).slice(-2), r = Math.ceil(a.currentTime);
                s < 10 && (s = "0" + s);
                var c = s + ":" + n, d = i.data.audios;
                d[e].audiowidth = o, d[e].Time = t, d[e].audiotime = c, d[e].seconds = r, i.setData({
                    audios: d
                });
            }, 1e3);
        });
        var s = t.currentTarget.dataset.audio, n = t.currentTarget.dataset.time, r = t.currentTarget.dataset.pausestop, c = t.currentTarget.dataset.loopplay;
        0 == c && a.onEnded(function(t) {
            d[e].status = !1, i.setData({
                audios: d
            });
        });
        var d = i.data.audios;
        d[e] || (d[e] = {}), a.paused && 0 == n ? (a.src = s, a.play(), 1 == c && (a.loop = !0), 
        d[e].status = !0, i.pauseOther(e)) : a.paused && n > 0 ? (a.play(), 0 == r ? a.seek(n) : a.seek(0), 
        d[e].status = !0, i.pauseOther(e)) : (a.pause(), d[e].status = !1), i.setData({
            audios: d
        });
    },
    pauseOther: function(t) {
        var e = this;
        d.each(this.data.audiosObj, function(a, o) {
            if (a != t) {
                o.pause();
                var i = e.data.audios;
                i[a] && (i[a].status = !1, e.setData({
                    audios: i
                }));
            }
        });
    }
}, t(a, "onHide", function() {
    this.pauseOther();
}), t(a, "onUnload", function() {
    this.pauseOther();
}), t(a, "navigate", function(t) {
    var e = t.currentTarget.dataset.url, a = t.currentTarget.dataset.phone, o = t.currentTarget.dataset.appid, i = t.currentTarget.dataset.appurl;
    e && wx.navigateTo({
        url: e,
        fail: function() {
            wx.switchTab({
                url: e
            });
        }
    }), a && wx.makePhoneCall({
        phoneNumber: a
    }), o && wx.navigateToMiniProgram({
        appId: o,
        path: i
    });
}), t(a, "close", function() {
    o.globalData.flag = !0, wx.reLaunch({
        url: "../index/index"
    });
}), a));