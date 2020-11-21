var _Page;

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), util = require("../../sudu8_page/resource/js/paowux.js");

app = getApp();

Page((_defineProperty(_Page = {
    data: {
        orderOrBusiness: "order",
        block: !1,
        goodsH: 0,
        scrollToGoodsView: 0,
        toView: "",
        toViewType: "",
        GOODVIEWID: "catGood_",
        animation: !0,
        goodsNumArr: [ 0 ],
        shoppingCart: {},
        shoppingCartGoodsId: [],
        goodMap: {},
        chooseGoodArr: [],
        totalNum: 0,
        totalPay: 0,
        showShopCart: !1,
        fromClickScroll: !1,
        timeStart: "",
        timeEnd: "",
        hideCount: !0,
        count: 0,
        needAni: !1,
        hide_good_box: !0,
        url: "",
        protype: 1,
        modalHidden: !0
    },
    onPullDownRefresh: function() {
        this.getIndex(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        if (this.setData({
            options: t
        }), !(a = t.scene)) {
            var a = 0;
            wx.setStorage({
                key: "zid",
                data: a
            });
        }
        0 < a && (this.setData({
            mid: a
        }), this.getzh(a)), this.getIndex(), app.util.getUserInfo(this.getinfos), this.getSjbase(t);
    },
    getinfos: function() {
        var a = this;
        a.data.options;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                });
            }
        });
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getzh: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/getzh",
            data: {
                zid: t
            },
            success: function(t) {
                e.setData({
                    tnum: t.data.data.zh.tnum,
                    zhm: t.data.data.zh.title + t.data.data.zh.tnum
                });
                var a = t.data.data.keys;
                wx.setStorageSync("arrkey", a), wx.setStorageSync("zid", t.data.data.zh.tnum);
            },
            fail: function(t) {}
        });
    },
    getIndex: function() {
        var i = this, t = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: t,
            data: {
                vs1: 1
            },
            success: function(t) {
                if (t.data.data.video) var a = "show";
                if (t.data.data.c_b_bg) var e = "bg";
                i.setData({
                    baseinfo: t.data.data,
                    show_v: a,
                    c_b_bg1: e
                }), wx.setNavigationBarColor({
                    frontColor: i.data.baseinfo.base_tcolor,
                    backgroundColor: i.data.baseinfo.base_color
                });
            },
            fail: function(t) {}
        });
    },
    goodsViewScrollFn: function(t) {
        this.getIndexFromHArr(t.detail.scrollTop);
    },
    getIndexFromHArr: function(t) {
        for (var a = 0; a < this.data.goodsNumArr.length; a++) {
            var e = t - 100 * a + 50 * a;
            e >= this.data.goodsNumArr[a] && e < this.data.goodsNumArr[a + 1] && (this.data.fromClickScroll || this.setData({
                catHighLightIndex: a
            }));
        }
        this.setData({
            fromClickScroll: !1
        });
    },
    catClickFn: function(t) {
        var a = t.target.id.split("_")[1], e = t.target.id.split("_")[2];
        this.setData({
            fromClickScroll: !0
        }), this.setData({
            catHighLightIndex: a
        }), this.setData({
            toView: this.data.GOODVIEWID + e
        });
    },
    addGoodToCartFn1: function(t) {
        for (var a = this, e = t.target.id.split("_")[1], i = a.data.allpro, o = 0; o < i.length; o++) if (i[o].id == e) var s = i[o], r = s.title;
        var n = a.data.gwcdata;
        if (n) {
            for (var d = 0, l = 0, u = 0; u < n.length; u++) if (n[u].title == r && s.id == n[u].id) {
                d = 1, l = u;
                break;
            }
            if (0 == d) (c = {}).id = s.id, c.price = s.price, c.title = r, c.num = 1, n.push(c); else n[l].num = 1 * n[l].num + 1;
        } else {
            var c;
            n = [], (c = {}).id = s.id, c.price = s.price, c.title = r, c.num = 1, n.push(c);
        }
        a.setData({
            gwcdata: n
        }), this._resetTotalNum();
    },
    addGoodToCartFn2: function(t) {
        var a = this, e = (t.target.id.split("_")[1], a.data.allpro, a.data.xgg.target.dataset.index), i = e.title + "[" + a.data.strval + "]", o = a.data.gwcdata;
        if (o) {
            for (var s = 0, r = 0, n = 0; n < o.length; n++) if (e.id == o[n].id) {
                s = 1, r = n;
                break;
            }
            if (0 == s) (d = {}).id = e.id, d.price = e.price, d.title = i, d.num = 1, o.push(d); else o[r].num = 1 * o[r].num + 1;
        } else {
            var d;
            o = [], (d = {}).id = e.id, d.price = e.price, d.title = i, d.num = 1, o.push(d);
        }
        a.setData({
            gwcdata: o
        }), this._resetTotalNum();
    },
    addGoodToCartFn: function(t) {
        var a = this, e = t.target.id.split("_")[1], i = a.data.allpro, o = a.data.protype;
        if (1 == o) for (var s = 0; s < i.length; s++) if (i[s].id == e) var r = (n = i[s]).title;
        if (2 == o) {
            var n;
            r = (n = a.data.xgg.target.dataset.index).title + "[" + a.data.strval + "]";
        }
        var d = {}, l = a.data.gwcdata;
        if (l) {
            for (var u = 0, c = 0, g = 0; g < l.length; g++) {
                if (l[g].title == r && n.id == l[g].id) {
                    u = 1, l[c = g].ggnum = l[g].ggnum + 1;
                    break;
                }
                n.id == l[g].id ? d.ggnum = l[g].ggnum + 1 : d.ggnum = 1;
            }
            0 == u ? (d.id = n.id, d.price = n.price, d.title = r, d.num = 1, null != n.labels ? d.labels = 2 : d.labels = 1, 
            l.push(d)) : l[c].num = 1 * l[c].num + 1;
        } else l = [], d.id = n.id, d.price = n.price, d.title = r, d.num = 1, 2 == o && (d.ggnum = 1), 
        null != n.labels ? d.labels = 2 : d.labels = 1, l.push(d);
        a.setData({
            gwcdata: l
        }), this._resetTotalNum();
    },
    touchOnGoods: function(t) {
        this.addGoodToCartFn(t);
    },
    decreaseGoodToCartFn: function(t) {
        var a = t.target.id, e = this.data.gwcdata;
        e[a].num--, 0 == e[a].num && e.splice(a, 1), this.setData({
            gwcdata: e
        }), this._resetTotalNum();
    },
    makePhoneCall: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.shangjbs.phone
        });
    },
    add2GoodToCartFn: function(t) {
        for (var a = t.currentTarget.dataset.idd, e = this.data.gwcdata, i = e[a].id, o = 0; o < e.length; o++) i == e[o].id && e[o].ggnum++;
        e[a].num++, this.setData({
            gwcdata: e
        }), this._resetTotalNum();
    },
    _resetTotalNum: function() {
        var t = this.data.gwcdata, a = 0, e = 0;
        if (t) for (var i = 0; i < t.length; i++) a = 1 * a + 1 * t[i].num, e = 1 * e + t[i].num * t[i].price;
        this.setData({
            totalNum: a,
            totalPay: e.toFixed(2),
            chooseGoodArr: t
        });
    },
    showShopCartFn: function(t) {
        0 < this.data.totalPay && this.setData({
            showShopCart: !this.data.showShopCart
        });
    },
    goPayFn: function(t) {
        this.data.mid;
        0 < this.data.totalPay && (wx.setStorage({
            key: "gwcdata",
            data: this.data.chooseGoodArr
        }), wx.setStorage({
            key: "gwcprice",
            data: this.data.totalPay
        }), wx.navigateTo({
            url: "/sudu8_page_plugin_food/food_order/food_order"
        }));
    },
    tabChange: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            orderOrBusiness: a
        });
    },
    getSjbase: function(t) {
        var c = this;
        app.util.request({
            url: "entry/wxapp/Shangjbs",
            success: function(t) {
                c.setData({
                    shangjbs: t.data.data
                }), wx.setNavigationBarTitle({
                    title: t.data.data.names
                });
            },
            fail: function(t) {}
        }), app.util.request({
            url: "entry/wxapp/dingcai",
            success: function(t) {
                c.setData({
                    slide: t.data.data.slide
                });
                var a = wx.getStorageSync("systemInfo"), e = a.windowWidth, i = 750 * a.windowHeight / e;
                c.setData({
                    goodsH: i - 416
                });
                var o = {};
                o.catList = t.data.data;
                for (var s = [], r = 0; r < t.data.data.length; r++) for (var n = 0; n < t.data.data[r].goodsList.length; n++) s.push(t.data.data[r].goodsList[n]);
                c.setData({
                    chessRoomDetail: o,
                    allpro: s
                }), c.setData({
                    toView: c.GOODVIEWID + c.data.chessRoomDetail.catList[0].id,
                    catHighLightIndex: 0
                });
                for (var d = 0; d < c.data.chessRoomDetail.catList.length; d++) {
                    c.data.goodsNumArr.push(c.data.chessRoomDetail.catList[d].goodsList.length);
                    c.data.chessRoomDetail.catList[d].goodsList;
                }
                for (var l = [], u = 0; u < c.data.goodsNumArr.length; u++) 0 == u ? l.push(0) : l.push(100 * c.data.goodsNumArr[u] + l[u - 1]);
                c.data.goodsNumArr = l;
            },
            fail: function(t) {}
        });
    },
    huoqusq: function() {
        var d = this, l = wx.getStorageSync("openid");
        wx.getUserInfo({
            success: function(t) {
                var a = t.userInfo, e = a.nickName, i = a.avatarUrl, o = a.gender, s = a.province, r = a.city, n = a.country;
                app.util.request({
                    url: "entry/wxapp/Useupdate",
                    data: {
                        openid: l,
                        nickname: e,
                        avatarUrl: i,
                        gender: o,
                        province: s,
                        city: r,
                        country: n
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(t) {
                        wx.setStorageSync("golobeuid", t.data.data.id), wx.setStorageSync("golobeuser", t.data.data), 
                        d.setData({
                            isview: 0
                        });
                    }
                });
            },
            fail: function() {
                app.util.selfinfoget(d.chenggfh);
            }
        });
    },
    chenggfh: function() {
        wx.getStorageSync("golobeuser");
        this.setData({
            isview: 0
        });
    },
    add: function(t) {
        for (var a = t.target.dataset.index, e = a.labels, i = 0; i < e.length; i++) e[i].xuanz = e[i].val[0];
        this.setData({
            block: !0,
            type_title: a.otitle,
            type_arr: a.labels,
            lables: e,
            xgg: t
        });
    },
    radioChange: function(t) {
        var a = t.currentTarget.dataset.id, e = t.detail.value, i = this.data.lables;
        i[a].xuanz = i[a].val[e], this.setData({
            lables: i
        });
    },
    proadd: function(t) {
        this.setData({
            protype: 1
        }), this.addGoodToCartFn(t);
    },
    decreaseGoodToCartFn1: function(t) {
        var a = t.target.id, e = this.data.gwcdata;
        e[a].num--, 0 == e[a].num && e.splice(a, 1), this.setData({
            gwcdata: e
        }), this._resetTotalNum();
    }
}, "makePhoneCall", function(t) {
    wx.makePhoneCall({
        phoneNumber: this.data.shangjbs.phone
    });
}), _defineProperty(_Page, "submit", function() {
    for (var t = this.data.xgg, a = this.data.lables, e = "", i = 0; i < a.length; i++) i == a.length - 1 ? e += a[i].xuanz : e += a[i].xuanz + ",";
    this.setData({
        block: !1,
        strval: e,
        protype: 2
    }), this.addGoodToCartFn(t);
}), _defineProperty(_Page, "buttonTap", function(t) {
    var a = this, e = t.currentTarget.id;
    a.setData({
        modalHidden: !1
    }), app.util.request({
        url: "entry/wxapp/getproinfo",
        data: {
            id: e
        },
        success: function(t) {
            a.setData({
                imgurl: t.data.data.imgurl,
                desccon: t.data.data.desccon
            });
        },
        fail: function(t) {}
    });
}), _defineProperty(_Page, "bindconfirm1", function() {
    this.setData({
        modalHidden: !0
    });
}), _defineProperty(_Page, "closeBlock", function() {
    this.setData({
        block: !1
    });
}), _Page));