var t = require("../../../../wxParse/wxParse.js"), a = new getApp(), o = a.siteInfo.uniacid;

Page({
    data: {
        isIphoneX: a.globalData.isIphoneX,
        statusBarHeight: a.globalData.statusBarHeight,
        titleBarHeight: a.globalData.titleBarHeight,
        pageScrollTop: 0,
        isShow: !1,
        scrollShow: !1,
        currentIndex: 1,
        goodsData: [],
        goodsid: "",
        is_show: "1",
        specItem: [],
        count: 1,
        price: "",
        spec_src: "",
        spec_id: "",
        buy_type: 1,
        specVal: [],
        sku_name_str: "",
        currentLsit: [],
        fertilizerList: [],
        pesticidesList: [],
        traceData: [],
        is_fumier: 1,
        user_uid: "",
        farmSetData: [],
        show_haibao: !1,
        show_goods_shop_model_mask: !1,
        bottom: 0,
        slideCurrentIndex: 1,
        commentCount: 0,
        commentList: [],
        is_create_poster: !1,
        local_src: "",
        post_src: "",
        showHome: !1,
        showIcon: !0,
        kefu: {
            cover: "",
            url: "/kundian_farm/pages/shop/prodeteils/index",
            title: ""
        },
        isHideVideo: !0,
        is_loading: !0,
        isServer: !1,
        istopShow: !0,
        nav_opacity: 0,
        scrollTop: 0
    },
    onLoad: function(t) {
        var e = this, s = t.goodsid;
        if (s) {
            var i = t.user_uid, n = wx.getStorageSync("kundian_farm_uid");
            a.loginBindParent(i, n), void 0 != i && 0 != i && e.setData({
                user_uid: i,
                showHome: !0,
                showIcon: !1
            });
            var r = 0;
            a.globalData.sysData.model.indexOf("iPhone X") > -1 && (r = 68), e.getGoodsDetailData(s), 
            a.util.setNavColor(o);
            var c = this.data.kefu;
            c.url = "/kundian_farm/pages/shop/prodeteils/index?goodsid=" + s, e.setData({
                farmSetData: wx.getStorageSync("kundian_farm_setData"),
                bottom: r,
                kefu: c,
                goodsid: s
            });
        } else wx.showModal({
            title: "提示",
            content: "当前商品不存在或已下架！",
            showCancel: "false",
            success: function() {
                wx.navigateBack({
                    delta: 1
                });
            }
        });
    },
    onShow: function(t) {
        var o = this.data.user_uid, e = wx.getStorageSync("kundian_farm_uid");
        a.loginBindParent(o, e);
    },
    setCurrent: function(t) {
        this.setData({
            slideCurrentIndex: parseInt(t.detail.current) + 1
        });
    },
    hideVideo: function(t) {
        this.setData({
            isHideVideo: !this.data.isHideVideo
        });
    },
    play: function(t) {
        this.setData({
            is_loading: !1
        });
    },
    getGoodsDetailData: function(e) {
        var s = this, i = this.data.kefu, n = wx.getStorageSync("kundian_farm_setData");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "shop",
                op: "getGoodsDetail",
                uniacid: o,
                goodsid: e
            },
            success: function(a) {
                var o = [], r = a.data, c = r.goodsData, d = r.specItem, l = r.commentCount, u = r.commentList;
                if (a.data.traceData && (o = a.data.traceData), n.kefu_card) {
                    var h = n.kefu_card;
                    i.title = h.title || c.goods_name, i.cover = h.cover || c.cover;
                }
                var p = [];
                c.live_src && (p = c.live_src.split(":")), s.setData({
                    goodsData: c,
                    goodsid: e,
                    specItem: d,
                    traceData: o,
                    commentCount: l,
                    commentList: u,
                    kefu: i,
                    src_xy: p
                }), "" != a.data.goodsData.goods_desc && t.wxParse("article", "html", a.data.goodsData.goods_desc, s, 5);
            }
        });
    },
    showMode: function(t) {
        var e = this, s = e.data.goodsData, i = wx.getStorageSync("kundian_farm_uid");
        if (i) if (1 == s.is_open_sku) e.setData({
            is_show: 2,
            buy_type: 2
        }); else {
            var n = e.data, r = n.goodsid, c = n.count;
            a.util.request({
                url: "entry/wxapp/class",
                data: {
                    control: "cart",
                    op: "addCart",
                    goods_id: r,
                    uniacid: o,
                    count: c,
                    uid: i
                },
                success: function(t) {
                    1 == t.data.code ? wx.showToast({
                        title: "已加入购物车"
                    }) : wx.showToast({
                        title: "操作失败"
                    });
                }
            });
        } else wx.navigateTo({
            url: "../../login/index"
        });
    },
    hideModal: function() {
        this.setData({
            is_show: 1
        });
    },
    reduceNum: function() {
        1 != this.data.count && this.setData({
            count: this.data.count - 1
        });
    },
    addNum: function() {
        var t = parseInt(this.data.count) + 1;
        this.setData({
            count: t
        });
    },
    chooseNum: function(t) {
        var a = t.detail.value;
        a <= 1 ? this.setData({
            count: 1
        }) : this.setData({
            count: a
        });
    },
    selectSpec: function(t) {
        for (var e = this, s = e.data, i = s.goodsid, n = s.specItem, r = t.currentTarget.dataset, c = r.specid, d = r.valid, l = new Array(), u = 0; u < n.length; u++) {
            n[u].id == c && (n[u].select_spec = 1);
            for (var h = 0; h < n[u].specVal.length; h++) n[u].id == c && (n[u].specVal[h].select_val = 0), 
            n[u].specVal[h].id == d && (n[u].specVal[h].select_val = 1), 1 == n[u].specVal[h].select_val && l.push(n[u].specVal[h].id);
        }
        var p = l.join(",");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "shop",
                op: "getSpec",
                uniacid: o,
                spec_id: p,
                goodsid: i
            },
            success: function(t) {
                if (1 == t.data.code) {
                    t.data.specVal.count <= 0 && wx.showToast({
                        title: "库存不足..."
                    });
                    for (var a = 0; a < n.length; a++) {
                        n[a].id == l && (n[a].is_select = 1);
                        for (var o = 0; o < n[a].specVal.length; o++) {
                            n[a].specVal[o].is_count = 1, n[a].specVal[o].id == d && (n[a].specVal[o].is_select = 0, 
                            t.data.specVal.count <= 0 && (n[a].specVal[o].is_count = 0));
                            for (var s = 0; s < l.length; s++) l[s] == d && l.splice(s, 1);
                        }
                    }
                    var i = t.data.specVal;
                    e.setData({
                        price: i.price,
                        spec_src: i.spec_src,
                        spec_id: i.id,
                        specItem: n,
                        specVal: i
                    });
                } else e.setData({
                    specItem: n
                });
            }
        });
    },
    sureGoods: function(t) {
        var a = this.data, o = a.goodsid, e = a.goodsData, s = a.spec_id, i = a.count, n = a.specVal, r = wx.getStorageSync("kundian_farm_uid");
        if (0 != r && void 0 != r) if (1 == e.is_open_sku) {
            if ("" == s && 0 == s.length) return wx.showToast({
                title: "请选择规格",
                icon: "none"
            }), !1;
            n.sku_name ? n.count >= i ? wx.navigateTo({
                url: "../confrimOrder/index?goodsid=" + o + "&spec_id=" + s + "&count=" + i
            }) : wx.showToast({
                title: "库存不足",
                icon: "none"
            }) : wx.showToast({
                title: "请选择规格",
                icon: "none"
            });
        } else e.count >= i ? wx.navigateTo({
            url: "../confrimOrder/index?goodsid=" + e.id + "&count=" + i
        }) : wx.showToast({
            title: "库存不足",
            icon: "none"
        }); else wx.navigateTo({
            url: "../../login/index"
        });
    },
    buySelectSpec: function(t) {
        this.setData({
            is_show: 2,
            buy_type: 1
        });
    },
    buyNow: function(t) {
        var a = this.data, o = (a.goodsData, a.count, wx.getStorageSync("kundian_farm_uid"));
        0 != o && void 0 != o ? this.setData({
            is_show: 2,
            buy_type: 1
        }) : wx.navigateTo({
            url: "../../login/index"
        });
    },
    addCart: function(t) {
        var e = this, s = e.data, i = s.goodsid, n = s.spec_id, r = s.count, c = s.specVal, d = wx.getStorageSync("kundian_farm_uid");
        if (0 != d && void 0 != d) {
            if ("" == n || void 0 == n) return wx.showToast({
                title: "请选择规格",
                icon: "none"
            }), !1;
            c.count >= r ? a.util.request({
                url: "entry/wxapp/class",
                data: {
                    control: "cart",
                    op: "addCart",
                    goods_id: i,
                    spec_id: n,
                    uniacid: o,
                    count: r,
                    uid: d
                },
                success: function(t) {
                    1 == t.data.code ? (wx.showToast({
                        title: "已加入购物车",
                        icon: "none"
                    }), e.setData({
                        is_show: 1
                    })) : wx.showToast({
                        title: "操作失败",
                        icon: "none"
                    });
                }
            }) : wx.showToast({
                title: "库存不足",
                icon: "none"
            });
        } else wx.navigateTo({
            url: "../../login/index"
        });
    },
    goHome: function(t) {
        wx.reLaunch({
            url: "/kundian_farm/pages/HomePage/index/index?is_tarbar=true"
        });
    },
    onShareAppMessage: function() {
        var t = this.data.goodsData, a = wx.getStorageSync("kundian_farm_uid");
        return {
            path: "/kundian_farm/pages/shop/prodeteils/index?goodsid=" + t.id + "&user_uid=" + a,
            success: function(t) {},
            title: t.goods_name,
            imageUrl: t.cover
        };
    },
    intoCart: function(t) {
        wx.navigateTo({
            url: "../buyCar/index"
        });
    },
    proDetailVideo: function(t) {
        var a = t.currentTarget.dataset.videosrc;
        wx.navigateTo({
            url: "../prodeteilVideo/index?src=" + a
        });
    },
    chengeIndex: function(t) {
        this.setData({
            currentIndex: t.currentTarget.dataset.index
        });
    },
    onPageScroll: function(t) {
        var a = !1;
        t.scrollTop >= 350 && (a = !0), this.setData({
            scrollShow: a,
            scrollTop: t.scrollTop
        }), 0 == this.data.isShow ? this.setData({
            pageScrollTop: t.scrollTop
        }) : wx.pageScrollTo({
            scrollTop: this.data.pageScrollTop,
            duration: 0
        });
    },
    isShow: function(t) {
        var a = t.currentTarget.dataset.index, o = this.data.goodsData;
        1 == a && this.setData({
            currentLsit: o.fumierData,
            isShow: !0,
            is_fumier: a
        }), 2 == a && this.setData({
            currentLsit: o.insecData,
            isShow: !0,
            is_fumier: a
        }), wx.pageScrollTo({
            duration: 0
        });
    },
    scroll: function(t) {
        wx.pageScrollTo({
            scrollTop: this.data.pageScrollTop,
            duration: 0
        });
    },
    noShow: function() {
        this.setData({
            isShow: !1
        });
    },
    returnTop: function() {
        wx.pageScrollTo({
            scrollTop: 0,
            duration: 300
        });
    },
    previewImg: function(t) {
        var a = t.currentTarget.dataset, o = a.index, e = a.id, s = this.data.traceData, i = new Array();
        s.map(function(t) {
            t.id == e && (i = t.img);
        }), wx.previewImage({
            urls: i,
            current: i[o]
        });
    },
    previewSlideImg: function(t) {
        var a = t.currentTarget.dataset.index, o = this.data.goodsData;
        wx.previewImage({
            urls: o.goods_slide,
            current: o[a]
        });
    },
    showGoodsShareModel: function(t) {
        this.setData({
            show_shop_model: !0,
            show_goods_shop_model_mask: !0
        });
    },
    closeGoodsShareModel: function(t) {
        this.setData({
            show_shop_model: !1,
            show_goods_shop_model_mask: !1
        });
    },
    closeGoodsHaihao: function(t) {
        this.setData({
            show_haibao: !1,
            show_goods_shop_model_mask: !1
        });
    },
    createGoodsPost: function(t) {
        var a = this;
        this.data.is_create_poster ? a.setData({
            show_shop_model: !1,
            show_haibao: !0
        }) : (wx.showLoading({
            title: "海报生成中"
        }), a.getPoster());
    },
    intoCommentList: function(t) {
        wx.navigateTo({
            url: "../commentList/index?goods_id=" + this.data.goodsid
        });
    },
    getPoster: function() {
        var t = this, e = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "shop",
                op: "getGoodsQrcode",
                uid: e,
                goods_id: t.data.goodsid,
                uniacid: o
            },
            success: function(a) {
                t.setData({
                    local_src: a.data.local_src,
                    post_src: a.data.post_src,
                    show_shop_model: !1,
                    show_haibao: !0,
                    is_create_poster: !0
                });
            }
        });
    },
    saveGoodsPost: function(t) {
        var a = this.data.local_src;
        wx.downloadFile({
            url: a,
            success: function(t) {
                wx.saveImageToPhotosAlbum({
                    filePath: t.tempFilePath,
                    success: function(t) {
                        wx.showModal({
                            title: "提示",
                            content: "海报保存成功",
                            showCancel: !1
                        });
                    },
                    fail: function(t) {}
                });
            }
        });
    },
    showService: function(t) {
        this.setData({
            isServer: !this.data.isServer
        });
    },
    fanhui: function(t) {
        console.log("dss"), wx.navigateBack({
            delta: 1
        });
    }
});