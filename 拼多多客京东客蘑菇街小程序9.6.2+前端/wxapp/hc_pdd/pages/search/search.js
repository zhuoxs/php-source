var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(a) {
    return typeof a;
} : function(a) {
    return a && "function" == typeof Symbol && a.constructor === Symbol && a !== Symbol.prototype ? "symbol" : typeof a;
};

function _toConsumableArray(a) {
    if (Array.isArray(a)) {
        for (var t = 0, e = Array(a.length); t < a.length; t++) e[t] = a[t];
        return e;
    }
    return Array.from(a);
}

var app = getApp(), pageNum = 0;

Page({
    data: {
        goodsist: [],
        thiseven: 0,
        gun: !0,
        text: [ "综合", "佣金比例", "销量", "价格" ],
        zoor: 0,
        searchinput: "",
        rankno: 0,
        tiaotwo: 7,
        loding: !0,
        jingxu: [ "拼多多", "蘑菇街" ],
        parameter: 0,
        coupon: !1,
        turn: 0
    },
    bindchange: function(a) {
        this.setData({
            tuhight: a.detail.current
        });
    },
    onLoad: function(a) {
        var t = this;
        t.setData({
            qieone: 0,
            qietwo: 0,
            qiethree: 0
        });
        var e = app.globalData.Headcolor;
        t.setData({
            backgroundColor: e
        }), Promise.all([ t.Headcolor(), t.joggle(), t.History() ]).then(function(a) {}, function(a) {}), 
        a.copytext && (t.setData({
            inputValue: a.copytext,
            searchinput: a.copytext
        }), t.joggle());
    },
    details: function(a) {
        var t = a.currentTarget.dataset.id, e = (a.currentTarget.dataset.jump, a.currentTarget.dataset.hui), i = a.currentTarget.dataset.itemurl, s = a.currentTarget.dataset.skuid, o = this.data.parameter, n = a.currentTarget.dataset.materialurl, r = a.currentTarget.dataset.couponurl;
        0 == o ? wx.navigateTo({
            url: "../details/details?goods_id=" + t + "&hui=" + e + "&parameter=" + o
        }) : 1 == o ? wx.navigateTo({
            url: "../details/details?itemUrl=" + i + "&parameter=" + o
        }) : 2 == o && (app.globalData.couponUrl = r, wx.navigateTo({
            url: "../details/details?skuId=" + s + "&parameter=" + o + "&materialUrl=" + n
        }));
    },
    bindHideKeyboard: function(a) {
        var t = a.detail.value;
        console.log(t), this.setData({
            inputValue: t
        });
    },
    joggle: function() {
        var a = this, t = a.data.parameter;
        if (0 == t) var e = "entry/wxapp/Goodslist", i = "../../resource/images/pd.png"; else if (1 == t) e = "entry/wxapp/Mogugoodslist", 
        i = "../../resource/images/mg.png"; else if (2 == t) e = "entry/wxapp/Jdgoodslist", 
        i = "../../resource/images/jd.png";
        a.setData({
            Goodslist: e,
            sahngf_view_img: i
        }), a.soso();
    },
    bindViewTap: function() {
        console.log("搜索");
        var a = this, t = a.data.inputValue;
        a.setData({
            inputValue: t
        }), a.joggle();
    },
    threeterminal: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            jingxu_index: t,
            parameter: t,
            pageNum: 0
        }), this.joggle();
    },
    soso: function() {
        var s = this;
        "" != s.data.inputValue && null != s.data.inputValue && app.util.request({
            url: s.data.Goodslist,
            method: "POST",
            data: {
                inputValue: s.data.inputValue,
                user_id: app.globalData.user_id
            },
            success: function(a) {
                if (null == a.data.data.list || null == a.data.data.list) var t = []; else t = a.data.data.list;
                var e = a.data.data.banner, i = a.data.data.nav;
                if (console.log(t), "" == t || null == t) {
                    t = null;
                    s.setData({
                        goodsist: t,
                        coupon: !0
                    });
                }
                s.setData({
                    goodsist: t,
                    banner: e,
                    nav: i
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    sio: function(a) {
        var t = a.currentTarget.dataset.text;
        this.setData({
            inputValue: t,
            searchinput: t
        }), this.soso();
    },
    quxiao: function(a) {
        console.log("删除文字");
        this.data.inputValue, this.data.goodsist;
        this.setData({
            searchinput: "",
            inputValue: "",
            goodsist: null
        });
    },
    History: function() {
        var i = this;
        return new Promise(function(e, t) {
            app.util.request({
                url: "entry/wxapp/History",
                method: "POST",
                data: {
                    user_id: app.globalData.user_id
                },
                success: function(a) {
                    var t = a.data.data;
                    i.setData({
                        History: t
                    }), e(a.data.message);
                },
                fail: function(a) {
                    console.log("失败" + a), t(a.data.message);
                }
            });
        });
    },
    shangpin: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/Soso",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list, e = a.data.data.banner, i = a.data.data.nav;
                s.setData({
                    goodsist: t,
                    banner: e,
                    nav: i
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    tu: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Share",
            method: "POST",
            success: function(a) {
                a.data.data.fenxtu;
                t.setData({
                    goodsist: goodsist
                });
            }
        });
    },
    fenlei: function(a) {
        var s = this, t = a.currentTarget.dataset.cateid;
        s.setData({
            cateid: t
        }), app.util.request({
            url: "entry/wxapp/Soso",
            method: "POST",
            data: {
                cateid: t,
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list, e = a.data.data.banner, i = a.data.data.nav;
                s.setData({
                    goodsist: t,
                    banner: e,
                    nav: i
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    jaizai: function(a) {
        var i = this;
        app.util.request({
            url: i.data.Goodslist,
            method: "POST",
            data: {
                pageNum: a,
                rankno: i.data.rankno,
                inputValue: i.data.inputValue,
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t;
                (t = i.data.goodsist).push.apply(t, _toConsumableArray(a.data.data.list));
                var e = [];
                e.push.apply(e, _toConsumableArray(i.data.goodsist)), i.setData({
                    goodsist: e,
                    loding: !0
                });
            }
        });
    },
    onReachBottom: function() {
        "" != this.data.inputValue && null != this.data.inputValue && (pageNum++, this.jaizai(pageNum), 
        this.setData({
            loding: !1
        }));
    },
    submitInfodetails: function(a) {
        this.details(a);
    },
    swiperChange: function(a) {
        this.setData({
            swiperCurrent: a.detail.current
        });
    },
    dianji: function(a) {
        var t = this, e = t.data.inputValue;
        null == e && (e = "");
        var i = a.currentTarget.dataset.index;
        if (0 == i) {
            t.data.qieone;
            0 == t.data.qieone ? (t.setData({
                qieone: 0
            }), t.paixu(0, e)) : (t.setData({
                qieone: 1
            }), t.paixu(1, e));
        }
        if (1 == i) {
            t.data.qieone;
            1 == t.data.qieone ? (t.setData({
                qieone: 2
            }), t.paixu(2, e)) : (t.setData({
                qieone: 1
            }), t.paixu(1, e));
        } else 1 != i && t.setData({
            qieone: 0
        });
        if (2 == i) {
            t.data.qietwo;
            1 == t.data.qietwo ? (t.setData({
                qietwo: 2
            }), t.paixu(6, e)) : (t.setData({
                qietwo: 1
            }), t.paixu(5, e));
        } else 2 != i && t.setData({
            qietwo: 0
        });
        if (3 == i) {
            t.data.qiethree;
            1 == t.data.qiethree ? (t.setData({
                qiethree: 2
            }), t.paixu(4, e)) : (t.setData({
                qiethree: 1
            }), t.paixu(3, e));
        } else 2 != i && t.setData({
            qiethree: 0
        });
        t.setData({
            thiseven: a.currentTarget.dataset.index
        });
    },
    qirw: function(a) {
        this.setData({
            zoor: a.currentTarget.dataset.index
        });
    },
    Headcolor: function() {
        var u = this;
        return new Promise(function(r, t) {
            app.util.request({
                url: "entry/wxapp/Headcolor",
                method: "POST",
                data: {
                    user_id: app.globalData.user_id
                },
                success: function(a) {
                    var t = a.data.data.search_color, e = a.data.data.config.share_icon, i = a.data.data.config.shenhe, s = a.data.data.is_daili, o = a.data.data.config, n = a.data.data.config.kaiguan;
                    u.setData({
                        search_color: t,
                        share_icon: e,
                        shenhe: i,
                        config: o,
                        is_daili: s,
                        kaiguan: n
                    }), console.log(_typeof(u.data.config.is_mogu)), r(a.data.message);
                },
                fail: function(a) {
                    t(a.data.message);
                }
            });
        });
    },
    paixu: function(a, t) {
        var s = this;
        a = a;
        s.setData({
            rankno: a
        }), "" != s.data.inputValue && null != s.data.inputValue && app.util.request({
            url: s.data.Goodslist,
            method: "POST",
            data: {
                rankno: a,
                inputValue: t,
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list, e = a.data.data.banner, i = a.data.data.nav;
                s.setData({
                    goodsist: t,
                    banner: e,
                    nav: i
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    shan: function() {
        this.data.History;
        this.setData({
            History: []
        }), app.util.request({
            url: "entry/wxapp/History",
            method: "POST",
            data: {
                del: 1,
                user_id: app.globalData.user_id
            },
            success: function(a) {},
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    fenxaiocsdad: function() {
        this.setData({
            showModalStatus: !1
        });
    },
    onShareAppMessage: function(a) {
        a.from;
        var t = a.target.dataset.src, e = a.target.dataset.id, i = a.target.dataset.name, s = a.target.dataset.goods_title, o = a.target.dataset.itemurl, n = a.target.dataset.skuid, r = this.data.parameter, u = a.target.dataset.materialurl, d = a.target.dataset.couponurl;
        if (this.setData({
            goods_src: t,
            goods_id: e,
            goods_name: i,
            goods_title: s
        }), 0 == r) var l = "hc_pdd/pages/details/details?goods_id=" + e + "&parameter=" + r + "&user_id=" + app.globalData.user_id; else if (1 == r) l = "hc_pdd/pages/details/details?itemUrl=" + o + "&parameter=" + r + "&user_id=" + app.globalData.user_id; else if (2 == r) l = "hc_pdd/pages/details/details?skuId=" + n + "&parameter=" + r + "&materialUrl=" + u + "&couponUrl=" + d + "&user_id=" + app.globalData.user_id;
        return {
            title: this.data.goods_title,
            path: l,
            imageUrl: this.data.goods_src,
            success: function(a) {},
            fail: function(a) {}
        };
    }
});