var _Page;

function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        thiseven: 0,
        gun: !0,
        text: [ "综合", "佣金比例", "销量", "价格" ],
        zoor: 0,
        searchinput: "",
        rankno: 0,
        loding: !0,
        jingxu: [ "拼多多", "蘑菇街" ],
        parameter: 0,
        pageNum: 1
    },
    bindchange: function(a) {
        this.setData({
            tuhight: a.detail.current
        });
    },
    threeterminal: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            jingxu_index: t,
            parameter: t,
            pageNum: 0
        }), this.joggle();
    },
    submitInfodetails: function(a) {
        this.submitInfotwo(a), this.details(a);
    },
    joggle: function() {
        var a = this, t = a.data.parameter;
        if (0 == t) var e = "entry/wxapp/Showlist", i = "../../resource/images/pd.png"; else if (1 == t) e = "entry/wxapp/Mogugoodslist", 
        i = "../../resource/images/mg.png"; else if (2 == t) e = "entry/wxapp/Jdgoodslist", 
        i = "../../resource/images/jd.png";
        a.setData({
            Goodslist: e,
            sahngf_view_img: i
        }), a.shangpin(a.data.screen_id);
    },
    onLoad: function(a) {
        var t = a.screen_id, e = this, i = app.globalData.Headcolor, s = app.globalData.title;
        e.setData({
            qieone: 0,
            qietwo: 0,
            qiethree: 0,
            screen_id: t,
            backgroundColor: i,
            title: s
        }), e.Headcolor(), e.joggle();
    },
    fanhui: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    submitInfotwo: function(a) {
        console.log("获取id");
        var t = a.detail.formId;
        console.log(t), console.log("获取formid结束"), this.setData({
            formid: t
        }), app.util.request({
            url: "entry/wxapp/formid",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                formid: this.data.formid
            },
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/Formid",
                    method: "POST",
                    data: {
                        user_id: app.globalData.user_id
                    },
                    success: function(a) {
                        console.log(a);
                    }
                });
            }
        });
    }
}, "submitInfodetails", function(a) {
    this.submitInfotwo(a), this.details(a);
}), _defineProperty(_Page, "bindHideKeyboard", function(a) {
    var t = a.detail.value;
    this.setData({
        inputValue: t
    });
}), _defineProperty(_Page, "bindViewTap", function() {
    console.log("搜索");
    var s = this, a = s.data.inputValue;
    s.setData({
        inputValue: a
    }), app.util.request({
        url: "entry/wxapp/Showlist",
        method: "POST",
        data: {
            inputValue: a,
            user_id: app.globalData.user_id
        },
        success: function(a) {
            var t = a.data.data.list, e = a.data.data.banner, i = a.data.data.nav;
            s.setData({
                goodsist: t,
                banner: e,
                nav: i
            }), console.log(t.length);
        },
        fail: function(a) {
            console.log("失败" + a);
        }
    });
}), _defineProperty(_Page, "quxiao", function(a) {
    console.log("删除文字");
    this.data.inputValue, this.data.goodsist;
    this.setData({
        searchinput: "",
        inputValue: "",
        goodsist: null
    });
}), _defineProperty(_Page, "shangpin", function(a) {
    var i = this;
    app.util.request({
        url: i.data.Goodslist,
        method: "POST",
        data: {
            screen_id: a,
            user_id: app.globalData.user_id
        },
        success: function(a) {
            var t = a.data.data.list, e = a.data.data.toplist;
            i.setData({
                goodsist: t,
                toplist: e
            });
        },
        fail: function(a) {
            console.log("失败" + a);
        }
    });
}), _defineProperty(_Page, "tu", function() {
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
}), _defineProperty(_Page, "fenlei", function(a) {
    var s = this, t = a.currentTarget.dataset.screen_id;
    s.setData({
        screen_id: t
    }), app.util.request({
        url: "entry/wxapp/Showlist",
        method: "POST",
        data: {
            screen_id: t,
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
}), _defineProperty(_Page, "jaizai", function(a) {
    var t, i = this, s = i.data.goodsist;
    app.util.request({
        url: i.data.Goodslist,
        method: "POST",
        data: (t = {
            pageNum: i.data.pageNum,
            screen_id: i.data.screen_id,
            rankno: i.data.rankno
        }, _defineProperty(t, "screen_id", i.data.screen_id), _defineProperty(t, "user_id", app.globalData.user_id), 
        t),
        success: function(a) {
            for (var t = a.data.data.list, e = 0; e < t.length; e++) s.push(t[e]);
            i.setData({
                goodsist: s,
                loding: !0
            });
        }
    });
}), _defineProperty(_Page, "onReachBottom", function() {
    console.log(this.data.goods);
    var a = this.data.pageNum;
    a++, this.jaizai(a), this.setData({
        loding: !1,
        pageNum: a
    });
}), _defineProperty(_Page, "onReady", function() {
    this.imperial = this.selectComponent("#imperial");
}), _defineProperty(_Page, "details", function(a) {
    var t = a.currentTarget.dataset.id, e = (a.currentTarget.dataset.jump, a.currentTarget.dataset.hui), i = a.currentTarget.dataset.itemurl, s = a.currentTarget.dataset.skuid, n = this.data.parameter, r = a.currentTarget.dataset.materialurl, o = a.currentTarget.dataset.couponurl;
    "" != t && (0 == n ? wx.navigateTo({
        url: "../details/details?goods_id=" + t + "&hui=" + e + "&parameter=" + n
    }) : 1 == n ? wx.navigateTo({
        url: "../details/details?itemUrl=" + i + "&parameter=" + n
    }) : 2 == n && (app.globalData.couponUrl = o, wx.navigateTo({
        url: "../details/details?skuId=" + s + "&parameter=" + n + "&materialUrl=" + r
    })));
}), _defineProperty(_Page, "swiperChange", function(a) {
    this.setData({
        swiperCurrent: a.detail.current
    });
}), _defineProperty(_Page, "dianji", function(a) {
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
}), _defineProperty(_Page, "qirw", function(a) {
    this.setData({
        zoor: a.currentTarget.dataset.index
    });
}), _defineProperty(_Page, "Headcolor", function() {
    var o = this;
    app.util.request({
        url: "entry/wxapp/Headcolor",
        method: "POST",
        data: {
            user_id: app.globalData.user_id
        },
        success: function(a) {
            var t = a.data.data.config.search_color, e = a.data.data.config.share_icon, i = a.data.data.config.shenhe, s = a.data.data.config, n = a.data.data.is_daili, r = a.data.data.config.kaiguan;
            o.setData({
                search_color: t,
                share_icon: e,
                shenhe: i,
                config: s,
                is_daili: n,
                kaiguan: r
            });
        },
        fail: function(a) {
            console.log("失败" + a);
        }
    });
}), _defineProperty(_Page, "paixu", function(a, t) {
    var s = this;
    a = a;
    s.setData({
        rankno: a
    }), app.util.request({
        url: s.data.Goodslist,
        method: "POST",
        data: {
            rankno: s.data.rankno,
            inputValue: t,
            screen_id: s.data.screen_id
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
}), _defineProperty(_Page, "onShareAppMessage", function(a) {
    if ("button" === a.from) {
        var t = this, e = a.target.dataset.src, i = a.target.dataset.id, s = a.target.dataset.name, n = a.target.dataset.goods_title, r = a.target.dataset.itemurl, o = a.target.dataset.skuid, d = t.data.parameter, u = a.target.dataset.materialurl, l = a.target.dataset.couponurl;
        if (t.setData({
            goods_src: e,
            goods_id: i,
            goods_name: s,
            goods_title: n
        }), 0 == d) var p = "hc_pdd/pages/details/details?goods_id=" + i + "&parameter=" + d + "&user_id=" + app.globalData.user_id; else if (1 == d) p = "hc_pdd/pages/details/details?itemUrl=" + r + "&parameter=" + d + "&user_id=" + app.globalData.user_id; else if (2 == d) p = "hc_pdd/pages/details/details?skuId=" + o + "&parameter=" + d + "&materialUrl=" + u + "&couponUrl=" + l + "&user_id=" + app.globalData.user_id;
        return {
            title: t.data.goods_title,
            path: p,
            imageUrl: t.data.goods_src,
            success: function(a) {},
            fail: function(a) {}
        };
    }
    var c = (t = this).data.config;
    return t.setData({
        config: c
    }), 0 == t.data.is_daili ? {
        title: t.data.config.indextitle,
        path: "hc_pdd/pages/index/index",
        imageUrl: t.data.config.indexpic,
        success: function(a) {},
        fail: function(a) {}
    } : {
        title: t.data.config.indextitle,
        path: "hc_pdd/pages/index/index?user_id=" + app.globalData.user_id,
        imageUrl: t.data.config.indexpic,
        success: function(a) {},
        fail: function(a) {}
    };
}), _Page));