var app = getApp();

Page({
    data: {
        page: 1,
        minHeight: 180,
        morePro: !1,
        ProductsList: [],
        baseinfo: [],
        footer: {
            i_tel: app.globalData.i_tel,
            i_add: app.globalData.i_add,
            i_time: app.globalData.i_time,
            i_view: app.globalData.i_view,
            close: app.globalData.close,
            v_ico: app.globalData.v_ico
        },
        orderOrBusiness: "order",
        block: !1,
        logs: [],
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
        heighthave: 0
    },
    onPullDownRefresh: function() {
        this.getBase(), this.getList(), this.setData({
            page: 1
        }), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        t.setData({
            isIphoneX: app.globalData.isIphoneX
        }), t.setData({
            page_sign: "listCon" + a.cid,
            page_signs: "/sudu8_page/listPro/listPro?cid=" + a.cid,
            cid: a.cid,
            options: a
        });
        var e = 0;
        a.fxsid && (e = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), t.getBase(), app.util.getUserInfo(t.getinfos, e);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                t.setData({
                    openid: a.data
                }), t.getList();
            }
        });
    },
    getBase: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "0",
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    handleTap: function(a) {
        var t = a.currentTarget.id.slice(1);
        t && (this.setData({
            cid: t,
            page: 1
        }), this.getList(t));
    },
    getList: function(a) {
        var p = this;
        null == a && (a = p.data.cid), app.util.request({
            url: "entry/wxapp/listPic",
            cachetime: "0",
            data: {
                cid: a
            },
            success: function(a) {
                10 < a.data.data.num.length ? p.setData({
                    morePro: !0
                }) : p.setData({
                    morePro: !1
                }), p.setData({
                    cateinfo: a.data.data,
                    cate_list: a.data.data.list,
                    cateslide: a.data.data.cateslide
                }), wx.setNavigationBarTitle({
                    title: p.data.cateinfo.this.name
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
                var t = p.data.cateinfo.topcid;
                if (2 == p.data.cateinfo.list_style_more && 0 == t) {
                    var e = p.data.options, o = wx.getStorageSync("systemInfo"), i = e;
                    p.busPos = {}, p.busPos.x = 45, p.busPos.y = app.globalData.hh - 56, p.setData({
                        mechine: i,
                        systemInfo: o,
                        goodsH: o.windowHeight - 55
                    });
                    var s = {};
                    s.catList = a.data.data.newlist;
                    for (var n = [], r = 0; r < a.data.data.length; r++) for (var d = 0; d < a.data.data[r].goodsList.length; d++) n.push(a.data.data[r].goodsList[d]);
                    p.setData({
                        chessRoomDetail: s,
                        allpro: n
                    }), p.setData({
                        toView: p.GOODVIEWID + p.data.chessRoomDetail.catList[0].id,
                        catHighLightIndex: 0
                    });
                    for (var l = 0; l < p.data.chessRoomDetail.catList.length; l++) {
                        p.data.goodsNumArr.push(p.data.chessRoomDetail.catList[l].goodsList.length);
                        var c = p.data.chessRoomDetail.catList[l].goodsList;
                        if (0 < c.length) for (var h = 0; h < c.length; h++) p.data.goodMap[c[h].id] = c[h];
                    }
                    for (var g = [], u = 0; u < p.data.goodsNumArr.length; u++) 0 == u ? g.push(0) : g.push(98 * p.data.goodsNumArr[u] + g[u - 1]);
                    p.data.goodsNumArr = g;
                }
            },
            fail: function(a) {}
        });
    },
    onReachBottom: function() {
        var t = this, e = t.data.page + 1, a = t.data.cid;
        app.util.request({
            url: "entry/wxapp/listPic",
            data: {
                cid: a,
                page: e
            },
            success: function(a) {
                "" != a.data.data.list ? t.setData({
                    cate_list: t.data.cate_list.concat(a.data.data.list),
                    page: e
                }) : t.setData({
                    morePro: !1
                });
            }
        });
    },
    swiperLoad: function(o) {
        var i = this;
        wx.getSystemInfo({
            success: function(a) {
                var t = o.detail.width / o.detail.height, e = a.windowWidth / t;
                i.data.heighthave || i.setData({
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
    onShareAppMessage: function() {
        return {
            title: this.data.cateinfo.name + "-" + this.data.baseinfo.name
        };
    },
    goodsViewScrollFn: function(a) {
        this.getIndexFromHArr(a.detail.scrollTop);
    },
    getIndexFromHArr: function(a) {
        for (var t = 0; t < this.data.goodsNumArr.length; t++) {
            var e = a - 40 * t;
            e >= this.data.goodsNumArr[t] && e < this.data.goodsNumArr[t + 1] && (this.data.fromClickScroll || this.setData({
                catHighLightIndex: t
            }));
        }
        this.setData({
            fromClickScroll: !1
        });
    },
    catClickFn: function(a) {
        var t = a.target.id.split("_")[1], e = a.target.id.split("_")[2];
        this.setData({
            fromClickScroll: !0
        }), this.setData({
            catHighLightIndex: t
        }), this.setData({
            toView: this.data.GOODVIEWID + e
        });
    },
    tabChange: function(a) {
        var t = a.currentTarget.dataset.id;
        this.setData({
            orderOrBusiness: t
        });
    },
    tiaozhuang: function(a) {
        var t = a.currentTarget.dataset.id, e = a.currentTarget.dataset.types, o = a.currentTarget.dataset.ismore, i = "";
        "showPro" == e ? (0 == o && (i = "/sudu8_page/showPro/showPro?id=" + t), 1 == o && (i = "/sudu8_page/showPro_lv/showPro_lv?id=" + t)) : i = "/sudu8_page/" + e + "/" + e + "?id=" + t, 
        wx.navigateTo({
            url: i
        });
    }
});