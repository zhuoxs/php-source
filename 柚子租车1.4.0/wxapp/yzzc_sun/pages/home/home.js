var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var o in e) Object.prototype.hasOwnProperty.call(e, o) && (t[o] = e[o]);
    }
    return t;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js");

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        show: !1,
        login: !0,
        gps: !0,
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            none: !1,
            data: []
        },
        imgLink: "",
        once: 0,
        hideQiandao: !0,
        themeWord: [ {
            hT: "上门接送",
            desc: "仅限上门取送范围内",
            id: 1
        }, {
            hT: "到店取还",
            desc: "为您推荐最近的门店",
            id: 2
        } ],
        types: 1
    },
    onLoad: function(t) {
        this.data.once = 1, 0 != app.globalData.havePoster ? this.setData({
            havePoster: !0
        }) : this.setData({
            havePoster: !1
        });
    },
    onShow: function() {
        0 != app.globalData.sunqr && (0, _api.DelimgData)({
            img: app.globalData.sunqr
        }).then(function(t) {
            console.log("ok"), app.globalData.sunqr = !1;
        }).catch(function(t) {
            app.globalData.sunqr = !1, console.log("fail");
        });
    },
    onloadData: function(t) {
        var a = this;
        0 != app.globalData.sunqr && (0, _api.DelimgData)({
            img: app.globalData.sunqr
        }).then(function(t) {
            console.log("ok"), app.globalData.sunqr = !1;
        }).catch(function(t) {
            app.globalData.sunqr = !1, console.log("fail");
        }), t.detail.login && (this.setData({
            show: !0
        }), this.getUrl().then(function(t) {
            return (0, _api.WeData)();
        }).then(function(t) {
            return a.setData({
                shoptitle: t.name
            }), wx.setNavigationBarTitle({
                title: t.name
            }), a.loadGPS();
        }).then(function(t) {
            0 !== t ? a.setData({
                lat: t.latitude,
                lng: t.longitude
            }) : a.setData({
                lat: 0,
                lng: 0
            }), a.getListData();
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        }));
    },
    getListData: function() {
        var e = this;
        if (console.log("刷新"), !this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var o = {
                page: this.data.list.page,
                length: this.data.list.length,
                lat: this.data.lat,
                lng: this.data.lng,
                state: this.data.types
            };
            0 != this.data.lat && (o.sort = "distance"), (0, _api.ShouyeData)(o).then(function(t) {
                console.log(t);
                var a = e.data.themeWord;
                a[0].hT = t.icon.doorname, a[0].desc = t.icon.doorlottery, a[1].hT = t.icon.shopname, 
                a[1].desc = t.icon.shoplottery, e.setData({
                    themeWord: a,
                    open_car: t.is_open_car - 0,
                    details: t.ershoucar,
                    open_ys: t.open_ys - 0
                }), 1 === e.data.once && e.dealWithNav(t), e.data.once = 0, e.dealList(t.car, o.page);
            }).catch(function(t) {
                -1 == t.code ? e.tips(t.msg) : e.tips("false");
            });
        }
    },
    onReachBottom: function() {
        0 != this.data.open_ys && this.getListData();
    },
    zucheWay: function(t) {
        1 == t.currentTarget.dataset.id && this.navTo("../choosetime/choosetime?table=5"), 
        2 == t.currentTarget.dataset.id && this.navTo("../choosetime/choosetime?table=4");
    },
    goClassic: function(t) {
        var a = t.currentTarget.dataset.index;
        0 == a && this.navTo("../choosetime/choosetime?table=2"), 1 == a && this.navTo("../couponlist/couponlist"), 
        2 == a && this.qiandaoTap(), 3 == a && this.navTo("../activitylist/activitylist");
    },
    qiandaoTap: function(t) {
        var a = this, e = {
            uid: wx.getStorageSync("userInfo").wxInfo.id
        };
        (0, _api.HomeSign)(e).then(function(t) {
            a.setData({
                hideQiandao: !1,
                scoreTitle: "签到成功",
                score: t.score,
                scoreSuc: !0
            });
        }).catch(function(t) {
            -1 == t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    backIndex: function(t) {
        this.setData({
            hideQiandao: !0
        });
    },
    seeJifen: function(t) {
        this.navTo("../jifen/jifen"), this.setData({
            hideQiandao: !0
        });
    },
    goYuDing: function(t) {
        this.navTo("../choosetime/choosetime?table=1&cid=" + t.currentTarget.dataset.cid);
    },
    dealWithNav: function(a) {
        var e = this, t = a.icon;
        this.setData({
            msg: t
        });
        var o = [ {}, {}, {}, {} ];
        null === t.logo_img_one || "" === t.logo_img_one ? o[0].img = "../../resource/images/tab/tab0.png" : o[0].img = this.data.imgLink + t.logo_img_one, 
        null === t.logo_img_two || "" === t.logo_img_two ? o[1].img = "../../resource/images/tab/tab1.png" : o[1].img = this.data.imgLink + t.logo_img_two, 
        null === t.logo_img_three || "" === t.logo_img_three ? o[2].img = "../../resource/images/tab/tab2.png" : o[2].img = this.data.imgLink + t.logo_img_three, 
        null === t.logo_img_four || "" === t.logo_img_four ? o[3].img = "../../resource/images/tab/tab3.png" : o[3].img = this.data.imgLink + t.logo_img_four, 
        null === t.logo_name_one || "" === t.logo_name_one ? o[0].txt = "超值套餐" : o[0].txt = t.logo_name_one, 
        null === t.logo_name_two || "" === t.logo_name_two ? o[1].txt = "领优惠券" : o[1].txt = t.logo_name_two, 
        null === t.logo_name_three || "" === t.logo_name_three ? o[2].txt = "签到积分" : o[2].txt = t.logo_name_three, 
        null === t.logo_name_four || "" === t.logo_name_four ? o[3].txt = "限时活动" : o[3].txt = t.logo_name_four, 
        this.setData({
            tab: o,
            banner: a.banner
        });
        (0, _api.QrpicData)({
            scene: 1,
            page: ""
        }).then(function(t) {
            e.setData({
                qrimg: t.img,
                posterinfo: {
                    avatar: wx.getStorageSync("userInfo").wxInfo.headimg,
                    banner: e.data.imgLink + a.index_haibao_pic.index_haibao_pic,
                    title: e.data.shoptitle,
                    qr: e.data.imgLink + t.img,
                    have: e.data.havePoster
                }
            }), console.log(e.data.posterinfo), app.globalData.sunqr = t.img;
        });
    },
    closeLocal: function() {
        this.setData({
            gps: !this.data.gps
        });
    },
    getGPS: function(t) {
        var a = this;
        t.detail.authSetting["scope.userLocation"] ? (this.setData({
            gps: !0,
            showPage: !0
        }), this.loadGPS().then(function(t) {
            a.data.gps && a.setData({
                lat: t.latitude,
                lng: t.longitude,
                list: {
                    load: !1,
                    over: !1,
                    page: 1,
                    length: 10,
                    none: !1,
                    data: []
                }
            }), a.onloadData({
                detail: {
                    login: 1
                }
            });
        })) : this.setData({
            gps: !1
        }), t.detail.authSetting["scope.userInfo"] || this.setData({
            login: !1
        });
    },
    loadGPS: function() {
        var o = this;
        if (wx.getStorageSync("gps")) {
            var t = new Date().getTime();
            return wx.getStorageSync("gps").time - 0 + 72e5 < t ? (0, _api.gps)().then(function(e) {
                return 0 === e ? (o.setData({
                    gps: !1
                }), new Promise(function(t, a) {
                    t(0);
                })) : (o.setData({
                    gps: !0
                }), e.time = new Date().getTime(), wx.setStorageSync("gps", e), new Promise(function(t, a) {
                    t(e);
                }));
            }) : new Promise(function(t, a) {
                o.setData({
                    gps: !0
                }), t(wx.getStorageSync("gps"));
            });
        }
        return (0, _api.gps)().then(function(e) {
            return 0 === e ? (o.setData({
                gps: !1
            }), new Promise(function(t, a) {
                t(0);
            })) : (o.setData({
                gps: !0
            }), e.time = new Date().getTime(), wx.setStorageSync("gps", e), new Promise(function(t, a) {
                t(e);
            }));
        });
    },
    createPoster: function(t) {
        var a = t.detail;
        this.setData({
            posterUrl: a.url,
            havePoster: !0
        }), app.globalData.havePoster = this.data.posterUrl, this.data.posterFlagB && this.onShowPosterTab(), 
        (0, _api.DelimgData)({
            img: this.data.qrimg
        }).then(function(t) {
            console.log("ok"), app.globalData.sunqr = !1;
        }).catch(function(t) {
            app.globalData.sunqr = !1, console.log("fail");
        });
    },
    onShowPosterTab: function() {
        0 != app.globalData.havePoster ? wx.previewImage({
            current: app.globalData.havePoster + "",
            urls: [ app.globalData.havePoster + "" ]
        }) : this.data.havePoster ? (wx.previewImage({
            current: this.data.posterUrl,
            urls: [ this.data.posterUrl ]
        }), wx.hideLoading()) : (wx.showLoading({
            title: "海报生成中..."
        }), this.setData({
            posterFlagB: !0
        }));
    },
    onShareAppMessage: function() {
        return {
            title: this.data.shoptitle,
            path: "/yzzc_sun/pages/home/home"
        };
    },
    toScond: function() {
        this.navTo("../Second/Second");
    },
    types: function(t) {
        this.setData({
            types: t.currentTarget.dataset.index,
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            }
        }), this.getListData();
    },
    toInfo: function(t) {
        this.navTo("../Second/Second_info/Second_info?id=" + t.currentTarget.dataset.cid);
    }
}));