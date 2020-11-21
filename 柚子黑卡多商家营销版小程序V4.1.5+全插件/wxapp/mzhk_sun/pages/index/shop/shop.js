var app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        navTile: "店铺详情",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        welfareList: [],
        newdata: [],
        list: [],
        phoneNumber: "",
        goods: [],
        hidden: !0,
        viptype: [],
        goodstype: [ "", "普", "砍", "拼", "集", "抢", "免" ],
        goodssaletype: [ "", "已售", "已砍", "已拼", "已集", "已抢", "已有" ],
        goodstype_btn: [ "去购买", "去购买", "去砍价", "去拼团", "去集卡", "去抢购", "抢免单" ],
        isloadWxParse: !1,
        starnums: 5,
        open_payment: 1,
        navname: [],
        curIndex: 0,
        deliveryInfo: [],
        deliveryCar_price: 0,
        delivery_show: 0,
        addClick: !0
    },
    onLoad: function(e) {
        var d = this, o = (e = app.func.decodeScene(e)).id;
        wx.setNavigationBarTitle({
            title: d.data.navTile
        }), d.setData({
            id: o
        });
        var a = app.getSiteUrl();
        a ? d.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), a = e.data, d.setData({
                    url: a
                });
            }
        }), app.wxauthSetting(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor ? wx.getStorageSync("System").fontcolor : "",
            backgroundColor: wx.getStorageSync("System").color ? wx.getStorageSync("System").color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/Payment",
            cachetime: "0",
            showLoading: !1,
            data: {
                bid: o
            },
            success: function(e) {
                2 == e.data && d.setData({
                    open_payment: 0
                });
            }
        });
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/newshopXqAll",
            cachetime: "0",
            showLoading: !1,
            data: {
                bid: o,
                openid: t,
                type: 0
            },
            success: function(e) {
                for (var a = [], t = [], i = wx.getStorageSync("cars"), r = wx.getStorageSync("car_price"), n = 0; n < e.data.length; n++) 0 < e.data[n].goods.length && a.push(e.data[n].name), 
                t.push(e.data[n].goods);
                d.setData({
                    navname: a,
                    newdata: t,
                    is_delivery: wx.getStorageSync("System").is_delivery,
                    deliveryInfo: i[o] ? i[o].info : [],
                    deliveryCar_price: r[o] ? r[o] : 0
                });
            }
        }), app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "0",
            data: {
                openid: t
            },
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                wx.setStorageSync("viptype", e.data), d.setData({
                    viptype: e.data.viptype
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 4
            },
            showLoading: !1,
            success: function(e) {
                var a = 2 != e.data && e.data;
                d.setData({
                    open_fission: a
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 7
            },
            showLoading: !1,
            success: function(e) {
                var a = 2 != e.data && e.data;
                d.setData({
                    open_subcard: a
                });
            }
        }), app.util.request({
            url: "entry/wxapp/shopRec",
            data: {
                bid: o
            },
            showLoading: !1,
            success: function(e) {
                2 != e.data && d.setData({
                    recarr: e.data
                });
            }
        });
    },
    toIndex: function(e) {
        wx.redirectTo({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    onShow: function() {
        var r = this;
        app.func.islogin(app, r);
        var a = r.data.id, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/shopXq",
            cachetime: "0",
            data: {
                id: a,
                openid: t
            },
            success: function(e) {
                var a = e.data.phone, t = e.data;
                t.delivery_start = parseFloat(t.delivery_start).toFixed(2), r.setData({
                    welfareList: t,
                    phoneNumber: a,
                    goods: e.data.goods
                }), r.getUrl();
                var i = t.content;
                r.data.isloadWxParse || (r.setData({
                    isloadWxParse: !0
                }), WxParse.wxParse("content", "html", i, r, 10));
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 4
            },
            showLoading: !1,
            success: function(e) {
                2 != e.data && app.util.request({
                    url: "entry/wxapp/GetShopFission",
                    showLoading: !1,
                    data: {
                        id: a,
                        openid: t,
                        m: app.globalData.Plugin_fission
                    },
                    success: function(e) {
                        2 != e.data ? r.setData({
                            list: e.data
                        }) : r.setData({
                            list: []
                        });
                    }
                });
            }
        });
        var e = wx.getStorageSync("cars"), i = wx.getStorageSync("car_price");
        r.setData({
            is_delivery: wx.getStorageSync("System").is_delivery,
            deliveryInfo: e[a] ? e[a].info : [],
            deliveryCar_price: i[a] ? i[a] : 0
        });
    },
    getUrl: function() {
        var a = this, t = app.getSiteUrl();
        t ? a.setData({
            url: t
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), t = e.data, a.setData({
                    url: t
                });
            }
        });
    },
    dialogue: function(e) {
        var a = this.data.phoneNumber;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    hidden: function(e) {
        this.setData({
            hidden: !0
        });
    },
    toGetGoods: function(e) {
        var a = e.currentTarget.dataset.id, t = (e.currentTarget.dataset.is_vip, wx.getStorageSync("openid"), 
        e.currentTarget.dataset.lid), i = e.currentTarget.dataset.bid;
        1 == t ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/goods/goods?gid=" + a
        }) : 2 == t ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/bardet/bardet?id=" + a
        }) : 3 == t ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/groupdet/groupdet?id=" + a
        }) : 4 == t ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/cardsdet/cardsdet?gid=" + a
        }) : 5 == t ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/package/package?id=" + a
        }) : 6 == t ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/freedet/freedet?id=" + a
        }) : 11 == t ? wx.navigateTo({
            url: "/mzhk_sun/plugin/fission/detail/detail?id=" + a + "&bid=" + i
        }) : 12 == t && wx.navigateTo({
            url: "/mzhk_sun/plugin2/secondary/detail/detail?id=" + a
        });
    },
    lingqu: function(e) {
        var a = this, t = e.currentTarget.dataset.id;
        e.currentTarget.dataset.isvip, a.data.viptype, e.currentTarget.dataset.f_index, 
        wx.getStorageSync("openid"), a.data.welfareList;
        return wx.navigateTo({
            url: "/mzhk_sun/pages/index/welfare/welfare?id=" + t
        }), !1;
    },
    max: function(e) {
        var a = e.currentTarget.dataset.address, t = Number(e.currentTarget.dataset.longitude), i = Number(e.currentTarget.dataset.latitude);
        if (0 == t && 0 == i) return wx.showToast({
            title: "该地址有问题，可能无法显示~",
            icon: "none",
            duration: 1e3
        }), !1;
        wx.openLocation({
            name: a,
            latitude: i,
            longitude: t,
            scale: 18,
            address: a
        });
    },
    onReady: function() {},
    onHide: function() {
        var e = this, a = wx.getStorageSync("cars"), t = wx.getStorageSync("car_price"), i = e.data.deliveryInfo, r = e.data.welfareList.bid, n = (e.data.welfareList.delivery_free, 
        Number.parseFloat(e.data.deliveryCar_price)), d = Number.parseFloat(e.data.welfareList.delivery_start);
        a ? a[r] = {} : (a = new Object())[r] = {}, a[r].info = i, a[r].name = e.data.welfareList.bname, 
        a[r].delivery_start = d, t ? t[r] = parseFloat(n).toFixed(2) : (t = new Object())[r] = parseFloat(n).toFixed(2), 
        wx.setStorageSync("car_price", t), wx.setStorageSync("cars", a);
    },
    onUnload: function() {
        var e = this, a = wx.getStorageSync("cars"), t = wx.getStorageSync("car_price"), i = e.data.deliveryInfo, r = e.data.welfareList.bid, n = (e.data.welfareList.delivery_free, 
        Number.parseFloat(e.data.deliveryCar_price)), d = Number.parseFloat(e.data.welfareList.delivery_start);
        a ? a[r] = {} : (a = new Object())[r] = {}, a[r].info = i, a[r].name = e.data.welfareList.bname, 
        a[r].delivery_start = d, t ? t[r] = parseFloat(n).toFixed(2) : (t = new Object())[r] = parseFloat(n).toFixed(2), 
        wx.setStorageSync("car_price", t), wx.setStorageSync("cars", a);
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var e = this.data.url, a = this.data.welfareList;
        return {
            title: a.bname,
            path: "mzhk_sun/pages/index/shop/shop?id=" + this.data.id,
            imageUrl: e + a.logo[0]
        };
    },
    shareCanvas: function() {
        var e = wx.getStorageSync("System"), a = this.data.welfareList, t = [];
        t.goodspicbg = e.goodspicbg, t.bname = a.bname, t.url = this.data.url, t.logo = a.img, 
        t.starttime = a.starttime, t.endtime = a.endtime, t.scene = "id=" + this.data.id, 
        t.tabletype = 2, app.creatPoster("mzhk_sun/pages/index/shop/shop", 430, t, 1, "shareImg");
    },
    drawText: function(e, a, t, i, r) {
        var n = e.split(""), d = "", o = [];
        r.font = "20px Arial", r.fillStyle = "black", r.textBaseline = "middle";
        for (var s = 0; s < n.length; s++) r.measureText(d).width < i || (o.push(d), d = ""), 
        d += n[s];
        o.push(d);
        for (var l = 0; l < o.length; l++) r.fillText(o[l], a, t + 30 * (l + 1));
    },
    save: function() {
        var a = this;
        wx.saveImageToPhotosAlbum({
            filePath: a.data.prurl,
            success: function(e) {
                wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(e) {
                        e.confirm && a.setData({
                            hidden: !0
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    toDetail: function(e) {
        var a = parseInt(e.currentTarget.dataset.id), t = parseInt(e.currentTarget.dataset.bid);
        wx.navigateTo({
            url: "/mzhk_sun/plugin/fission/detail/detail?id=" + a + "&bid=" + t
        });
    },
    choosenav: function(e) {
        this.setData({
            curIndex: e.currentTarget.dataset.index
        });
    },
    toNewGoods: function(e) {
        var a = e.currentTarget.dataset.gid, t = e.currentTarget.dataset.lid, i = this.data.id;
        this.data.curIndex;
        1 == t ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/goods/goods?gid=" + a
        }) : 2 == t ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/bardet/bardet?id=" + a
        }) : 3 == t ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/groupdet/groupdet?id=" + a
        }) : 4 == t ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/cardsdet/cardsdet?gid=" + a
        }) : 5 == t ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/package/package?id=" + a
        }) : 6 == t ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/freedet/freedet?id=" + a
        }) : 11 == t ? wx.navigateTo({
            url: "/mzhk_sun/plugin/fission/detail/detail?id=" + a + "&bid=" + i
        }) : 12 == t && wx.navigateTo({
            url: "/mzhk_sun/plugin2/secondary/detail/detail?id=" + a
        });
    },
    tocounp: function(e) {
        var a = this.data.id;
        wx.navigateTo({
            url: "/mzhk_sun/pages/index/coupon/coupon?bid=" + a
        });
    },
    toqgGoods: function(e) {
        var a = e.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "/mzhk_sun/pages/index/package/package?id=" + a
        });
    },
    close_modal: function() {
        this.setData({
            delivery_show: 0
        });
    },
    addDelivery: function(e) {
        var a = this, t = a.data.newdata[a.data.curIndex][e.currentTarget.dataset.index], i = (a.data.deliveryCar_price - 0).toFixed(2), r = a.data.deliveryInfo;
        return r.every(function(e) {
            return e.gid != t.gid;
        }) ? 1 == t.is_vip && a.data.viptype <= 0 ? (wx.showToast({
            title: "该商品为会员专属",
            duration: 2e3,
            icon: "none"
        }), !1) : void app.util.request({
            url: "entry/wxapp/psnum",
            data: {
                gid: t.gid,
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                0 < e.data.num - 0 ? 0 < t.is_delivery_limit - 0 ? 1 <= e.data.delivery_limit - 0 - e.data.total ? (t.num = 1, 
                0 < t.vipprice - 0 && 0 < a.data.viptype ? (i = parseFloat((i - 0).toFixed(2)) + parseFloat(t.vipprice - 0), 
                t.money = parseFloat(t.vipprice - 0)) : (i = parseFloat((i - 0).toFixed(2)) + parseFloat(t.price - 0), 
                t.money = parseFloat(t.price - 0)), r.push(t), a.setData({
                    deliveryCar_price: parseFloat(i - 0).toFixed(2),
                    deliveryInfo: r
                })) : wx.showToast({
                    title: "超出商品限购",
                    duration: 2e3,
                    icon: "none"
                }) : (t.num = 1, 0 < t.vipprice - 0 && 0 < a.data.viptype ? (i = parseFloat((i - 0).toFixed(2)) + parseFloat(t.vipprice - 0), 
                t.money = parseFloat(t.vipprice - 0)) : (i = parseFloat((i - 0).toFixed(2)) + parseFloat(t.price - 0), 
                t.money = parseFloat(t.price - 0)), r.push(t), a.setData({
                    deliveryCar_price: parseFloat(i - 0).toFixed(2),
                    deliveryInfo: r
                })) : wx.showToast({
                    title: "商品库存不足",
                    icon: "none",
                    duration: 2e3
                });
            }
        }) : (wx.showToast({
            title: "购物车已存在该商品",
            duration: 2e3,
            icon: "none"
        }), !1);
    },
    showDelivery: function(e) {
        this.setData({
            delivery_show: 0 == this.data.delivery_show ? 1 : 0
        });
    },
    delivery_add: function(a) {
        var t = this, i = t.data.deliveryInfo[a.currentTarget.dataset.index], r = t.data.deliveryInfo, n = t.data.deliveryCar_price;
        t.data.addClick && (t.setData({
            addClick: !1
        }), 0 < i.is_delivery_limit - 0 ? app.util.request({
            url: "entry/wxapp/psnum",
            data: {
                gid: i.gid,
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                if (!(i.num - 0 < e.data.num - 0 && i.num - 0 < e.data.delivery_limit - 0 - (e.data.total - 0))) return i.num - 0 == e.data.num - 0 && wx.showToast({
                    title: "该商品库存不足",
                    duration: 2e3,
                    icon: "none"
                }), i.num - 0 != e.data.delivery_limit - 0 && i.num - 0 != e.data.delivery_limit - 0 - (e.data.total - 0) || wx.showToast({
                    title: "超出商品限购",
                    duration: 2e3,
                    icon: "none"
                }), t.setData({
                    addClick: !0
                }), !1;
                ++i.num, r[a.currentTarget.dataset.index] = i, t.setData({
                    deliveryInfo: r,
                    deliveryCar_price: (parseFloat(n - 0) + parseFloat(i.money - 0)).toFixed(2),
                    addClick: !0
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/psnum",
            data: {
                gid: i.gid,
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                if (i.num - 0 >= e.data.num - 0) return wx.showToast({
                    title: "商品库存不足",
                    duration: 2e3,
                    icon: "none"
                }), t.setData({
                    addClick: !0
                }), !1;
                ++i.num, r[a.currentTarget.dataset.index] = i, t.setData({
                    deliveryInfo: r,
                    deliveryCar_price: (parseFloat(n - 0) + parseFloat(i.money - 0)).toFixed(2),
                    addClick: !0
                });
            }
        }));
    },
    delivery_reduce: function(e) {
        var a = this, t = a.data.deliveryInfo[e.currentTarget.dataset.index], i = a.data.deliveryInfo, r = a.data.deliveryCar_price;
        1 < t.num ? (--t.num, i[e.currentTarget.dataset.index] = t, a.setData({
            deliveryInfo: i,
            deliveryCar_price: (parseFloat(r - 0).toFixed(2) - parseFloat(t.money - 0)).toFixed(2)
        })) : (i.splice(e.currentTarget.dataset.index, 1), a.setData({
            deliveryInfo: i,
            deliveryCar_price: (parseFloat(r - 0).toFixed(2) - parseFloat(t.money - 0)).toFixed(2),
            delivery_show: 0 < i.length ? 1 : 0
        }));
    },
    delivery_pays: function(e) {
        var a = this.data.deliveryInfo, t = this.data.deliveryCar_price;
        this.data.welfareList.delivery_free;
        wx.setStorageSync("deliveryInfo", a), wx.redirectTo({
            url: "/mzhk_sun/plugin3/delivery/delivery_order/delivery_order?deliveryCar_price=" + t + "&bid=" + this.data.welfareList.bid + "&sincetype=0"
        });
    },
    clearCar: function() {
        var r = this;
        wx.showModal({
            title: "提示",
            content: "清空购物车？",
            success: function(e) {
                if (e.confirm) {
                    r.setData({
                        delivery_show: 0,
                        deliveryCar_price: 0,
                        deliveryInfo: []
                    });
                    var a = wx.getStorageSync("cars"), t = wx.getStorageSync("car_price"), i = r.data.welfareList.bid;
                    delete a[i], delete t[i], wx.setStorageSync("cars", a), wx.setStorageSync("car_price", t);
                } else e.cancel && console.log("用户点击取消");
            }
        });
    }
});