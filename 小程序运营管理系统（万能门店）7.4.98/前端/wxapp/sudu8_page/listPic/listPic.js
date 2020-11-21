var app = getApp();

Page({
    data: {
        page: 1,
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
        minHeight: 180,
        heighthave: 0,
        currentSwiper: 0
    },
    onPullDownRefresh: function() {
        this.getBase(), this.getList(), this.setData({
            page: 1
        }), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            isIphoneX: app.globalData.isIphoneX
        }), a.setData({
            page_sign: "listCon" + t.cid,
            page_signs: "/sudu8_page/listPic/listPic?cid=" + t.cid,
            cid: t.cid
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        })), a.getBase(), app.util.getUserInfo(a.getinfos, e);
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                }), a.getList();
            }
        });
    },
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(t) {
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                });
            },
            fail: function(t) {}
        });
    },
    handleTap: function(t) {
        var a = t.currentTarget.id.slice(1);
        a && (this.setData({
            cid: a,
            page: 1
        }), this.getList(a));
    },
    getList: function(t) {
        var u = this;
        null == t && (t = u.data.cid), app.util.request({
            url: "entry/wxapp/listPic",
            cachetime: "30",
            data: {
                cid: t
            },
            success: function(t) {
                if (10 < t.data.data.num.length ? u.setData({
                    morePro: !0
                }) : u.setData({
                    morePro: !1
                }), u.setData({
                    cateinfo: t.data.data,
                    cate_list: t.data.data.list,
                    cateslide: t.data.data.cateslide
                }), wx.setNavigationBarTitle({
                    title: u.data.cateinfo.name
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh(), 
                2 == u.data.cateinfo.list_style_more) {
                    var a = u.data.options, e = wx.getStorageSync("systemInfo"), i = a;
                    u.busPos = {}, u.busPos.x = 45, u.busPos.y = app.globalData.hh - 56, u.setData({
                        mechine: i,
                        systemInfo: e,
                        goodsH: e.windowHeight - 55,
                        minHeight: 200,
                        goodsRh: e.windowHeight - 55 + 200
                    });
                    var o = {};
                    o.catList = t.data.data.newlist;
                    for (var s = [], n = 0; n < t.data.data.length; n++) for (var r = 0; r < t.data.data[n].goodsList.length; r++) s.push(t.data.data[n].goodsList[r]);
                    u.setData({
                        chessRoomDetail: o,
                        allpro: s
                    }), u.setData({
                        toView: u.GOODVIEWID + u.data.chessRoomDetail.catList[0].id,
                        catHighLightIndex: 0
                    });
                    for (var d = 0; d < u.data.chessRoomDetail.catList.length; d++) {
                        u.data.goodsNumArr.push(u.data.chessRoomDetail.catList[d].goodsList.length);
                        var l = u.data.chessRoomDetail.catList[d].goodsList;
                        if (0 < l.length) for (var c = 0; c < l.length; c++) u.data.goodMap[l[c].id] = l[c];
                    }
                    for (var h = [], g = 0; g < u.data.goodsNumArr.length; g++) 0 == g ? h.push(0) : h.push(98 * u.data.goodsNumArr[g] + h[g - 1]);
                    u.data.goodsNumArr = h;
                }
            },
            fail: function(t) {}
        });
    },
    onReachBottom: function() {
        var a = this, e = a.data.page + 1, t = a.data.cid;
        app.util.request({
            url: "entry/wxapp/listPic",
            data: {
                cid: t,
                page: e
            },
            success: function(t) {
                "" != t.data.data.list ? a.setData({
                    cate_list: a.data.cate_list.concat(t.data.data.list),
                    page: e
                }) : a.setData({
                    morePro: !1
                });
            }
        });
    },
    swiperLoad: function(i) {
        var o = this;
        wx.getSystemInfo({
            success: function(t) {
                var a = i.detail.width / i.detail.height, e = t.windowWidth / a;
                o.data.heighthave || o.setData({
                    minHeight: e,
                    heighthave: 1
                });
            }
        });
    },
    makePhoneCall: function(t) {
        var a = this.data.baseinfo.tel;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    makePhoneCallB: function(t) {
        var a = this.data.baseinfo.tel_b;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    openMap: function(t) {
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
    goodsViewScrollFn: function(t) {
        this.getIndexFromHArr(t.detail.scrollTop);
    },
    getIndexFromHArr: function(t) {
        for (var a = 0; a < this.data.goodsNumArr.length; a++) {
            var e = t - 40 * a;
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
    tabChange: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            orderOrBusiness: a
        });
    },
    tiaozhuang: function(t) {
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.types, i = t.currentTarget.dataset.ismore, o = "";
        "showPro" == e ? (0 == i && (o = "/sudu8_page/showPro/showPro?id=" + a), 1 == i && (o = "/sudu8_page/showPro_lv/showPro_lv?id=" + a)) : o = "/sudu8_page/" + e + "/" + e + "?id=" + a, 
        wx.navigateTo({
            url: o
        });
    },
    swiperChange: function(t) {
        this.setData({
            currentSwiper: t.detail.current
        });
    }
});