var app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {
        goHome: {
            top: 150,
            left: 30
        },
        curIndex: 0,
        chooseSize: !1,
        animationData: {},
        id: "",
        num: 1,
        price: 0,
        totalprice: 0,
        attr: "",
        buystyle: 0,
        stock: 1e3,
        QRcode: null
    },
    bindTap: function(t) {
        this.setData({
            curIndex: t.currentTarget.dataset.index
        });
    },
    immediatelyBuy: function() {
        this.data.buystyle = 2, this.chooseSezi();
    },
    addToCar: function() {
        console.log("sdfasdf"), this.data.buystyle = 1, this.chooseSezi();
    },
    chooseSezi: function(t) {
        var a = this, e = wx.createAnimation({
            duration: 500,
            timingFunction: "linear"
        });
        (a.animation = e).translateY(100).step(), a.setData({
            animationData: e.export(),
            chooseSize: !0
        }), setTimeout(function() {
            e.translateY(0).step(), a.setData({
                animationData: e.export()
            });
        }, 200);
    },
    share: function(t) {
        var a = this, e = wx.createAnimation({
            duration: 500,
            timingFunction: "linear"
        });
        (a.animation = e).translateY(100).step(), a.setData({
            animationData1: e.export(),
            share: !0
        }), setTimeout(function() {
            e.translateY(0).step(), a.setData({
                animationData1: e.export()
            });
        }, 200);
    },
    hideshare: function() {
        var t = this, a = wx.createAnimation({
            duration: 1e3,
            timingFunction: "linear"
        });
        (t.animation = a).translateY(100).step(), t.setData({
            animationData1: a.export()
        }), setTimeout(function() {
            a.translateY(0).step(), t.setData({
                animationData1: a.export(),
                share: !1
            });
        }, 200);
    },
    closeModal: function() {
        var t = this, a = wx.createAnimation({
            duration: 1e3,
            timingFunction: "linear"
        });
        (t.animation = a).translateY(100).step(), t.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.translateY(0).step(), t.setData({
                animationData: a.export(),
                chooseSize: !1
            });
        }, 200);
    },
    confirm: function(t) {
        var a = this, e = this.data.totalprice, i = this.data.buystyle, o = this.data.detail.id, n = this.data.num, s = this.data.price, r = this.data.attr, c = a.data.detail;
        if ("" != r && null != r || "" == c.attrs) {
            if (console.log("app.globalData.webset.vip"), 1 == app.globalData.webset.vip && (console.log(a.data.member), 
            app.globalData.userInfo.member = a.data.member, app.globalData.userInfo.member && (e = 0 < c.vprice ? (c.vprice * e / 100 + .001).toFixed(2) : (e * app.globalData.userInfo.member.discount / 100 + .001).toFixed(2))), 
            this.closeModal(), !(a.data.stock < a.data.num)) {
                if (1 == i) {
                    var d = a.data.carnum, u = wx.getStorageSync("cars") || [], l = !1;
                    if (u && (u.forEach(function(t, a) {
                        t.id == o && t.attr == r && (l = !0, wx.showToast({
                            title: "该商品已经在购物车中",
                            icon: "none"
                        }));
                    }), l)) return;
                    u.push({
                        id: o,
                        num: n,
                        price: s,
                        attr: r,
                        cid: 1
                    }), wx.setStorage({
                        key: "cars",
                        data: u,
                        success: function() {
                            a.setData({
                                carnum: d + 1
                            }), wx.showToast({
                                title: "已加入购物车"
                            });
                        }
                    });
                }
                if (2 == i) {
                    var p = [], m = [];
                    p.push({
                        id: c.id,
                        img: c.bimg,
                        num: n,
                        price: s,
                        name: c.name,
                        attr: r,
                        attr_name: c.attr_name,
                        weight: c.weight,
                        vprice: c.vprice,
                        v_privce: 0
                    }), m = {
                        content: p,
                        totalPrice: e,
                        totalNum: n,
                        cid: 1
                    }, m = JSON.stringify(m), m = encodeURIComponent(m), console.log(m), wx.navigateTo({
                        url: "../submit/submit?order=" + m
                    });
                }
            }
        } else wx.showToast({
            title: "请先选择属性",
            icon: "none"
        });
    },
    addCount: function(t) {
        var a = this.data.price, e = this.data.num;
        if (!(this.data.stock < (e += 1))) {
            var i = a * e;
            this.setData({
                num: e,
                totalprice: (i + .001).toFixed(2)
            });
        }
    },
    minusCount: function(t) {
        var a = this.data.price, e = this.data.num;
        if (!(e <= 1)) {
            var i = a * (e -= 1);
            this.setData({
                num: e,
                totalprice: (i + .001).toFixed(2)
            });
        }
    },
    changeAttr: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.detail.attrs;
        this.setData({
            attr: a,
            price: e[a].price,
            totalprice: e[a].price,
            num: 1,
            stock: e[a].stock,
            show_img: e[a].img
        });
    },
    toindex: function() {
        wx.reLaunch({
            url: "../index/index"
        });
    },
    tocart: function() {
        wx.reLaunch({
            url: "../cart/cart"
        });
    },
    onLoad: function(t) {
        this.setData({
            webset_voucher: app.globalData.webset.voucher,
            comment: app.globalData.webset.comment,
            vip: app.globalData.webset.vip,
            discount: app.globalData.userInfo.member ? app.globalData.userInfo.member.discount : null,
            id: t.id,
            "goHome.blackhomeimg": app.globalData.blackhomeimg,
            member: null
        });
        var n = this;
        t.id && app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            method: "POST",
            data: {
                op: "detail",
                id: t.id
            },
            success: function(t) {
                var a = t.data;
                if (n.data.member = a.data.member, a.data.pro) {
                    WxParse.wxParse("article", "html", a.data.pro.contents, n, 10);
                    var e = {
                        detail: a.data.pro,
                        price: a.data.pro.prices,
                        totalprice: a.data.pro.prices,
                        show_img: a.data.pro.bimg,
                        comment: a.data.comment,
                        comment_total: a.data.comment_total
                    }, i = a.data.pro;
                    if (i.attrs) {
                        var o = Object.keys(i.attrs)[0];
                        e.attr = o, e.price = i.attrs[o].price, e.totalprice = i.attrs[o].price, e.num = 1, 
                        e.stock = i.attrs[o].stock, e.show_img = i.attrs[o].img;
                    }
                    n.setData(e);
                }
            }
        });
    },
    onReady: function() {
        app.look.navbar(this), app.look.accredit(this), app.look.goHome(this);
    },
    onShow: function() {
        var t = wx.getStorageSync("cars") || [];
        this.setData({
            carnum: t.length
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this, t = this.data.id;
        "" != t ? app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            method: "POST",
            data: {
                op: "detail",
                id: t
            },
            success: function(t) {
                var a = t.data;
                wx.stopPullDownRefresh(), a.data.pro && e.setData({
                    detail: a.data.pro,
                    price: a.data.pro.prices,
                    totalprice: a.data.pro.prices,
                    num: 1,
                    attred: "",
                    buystyle: "",
                    stock: 1e3,
                    show_img: a.data.pro.bimg
                });
            }
        }) : wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        this.setData({
            share: !1
        }), wx.showShareMenu({
            withShareTicket: !0
        });
        var a = this, e = "", i = "", o = "";
        return i = app.look.istrue(a.data.detail.share.title) ? a.data.detail.share.title : a.data.detail.name, 
        app.look.istrue(a.data.detail.share.img) && (o = a.data.detail.share.img), "menu" == t.from ? (e = "../detail/detail?id=" + this.data.id, 
        {
            title: i,
            path: "/xc_xinguwu/pages/base/base?share=" + (e = encodeURIComponent(e)) + "&userid=" + app.globalData.userInfo.id,
            imageUrl: o,
            success: function(t) {
                wx.showToast({
                    title: "转发成功"
                });
            },
            fail: function(t) {}
        }) : "button" == t.from ? (e = "../detail/detail?id=" + this.data.id, {
            title: i,
            path: "/xc_xinguwu/pages/base/base?share=" + (e = encodeURIComponent(e)) + "&userid=" + app.globalData.userInfo.id,
            imageUrl: o,
            success: function(t) {
                a.hideshare(), wx.showToast({
                    title: "转发成功"
                });
            },
            fail: function(t) {}
        }) : void 0;
    },
    shengcheng: function() {
        var a = this, t = a.data.detail;
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            method: "POST",
            data: {
                op: "detail_poster",
                good_img: t.bimg,
                good_name: t.name,
                old_price: t.oprice,
                price: t.prices,
                id: t.id
            },
            success: function(t) {
                console.log(t.data.data), a.setData({
                    poster: t.data.data,
                    shengc: !0,
                    share: !1
                });
            }
        });
    },
    saveImageToPhotosAlbum: function() {
        wx.downloadFile({
            url: this.data.poster,
            success: function(t) {
                console.log(t);
                var a = t.tempFilePath;
                wx.authorize({
                    scope: "scope.writePhotosAlbum",
                    success: function(t) {
                        wx.saveImageToPhotosAlbum({
                            filePath: a,
                            success: function(t) {
                                app.look.alert("保存成功");
                            },
                            fail: function(t) {
                                "saveImageToPhotosAlbum:fail auth deny" === t.errMsg && wx.openSetting({
                                    success: function(t) {}
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    hidesc: function() {
        this.setData({
            shengc: !1
        });
    },
    previewImage: function(t) {
        var a = t.currentTarget.dataset.src, e = this.data.detail;
        wx.previewImage({
            current: a,
            urls: e.imgs
        });
    },
    previewImage_poster: function() {
        wx.previewImage({
            urls: [ this.data.poster ]
        });
    },
    onGotUserInfo: function(t) {
        app.look.getuserinfo(t, this);
    }
});