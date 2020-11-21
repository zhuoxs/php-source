var app = getApp();

Page({
    data: {
        joinGroup: !0,
        indicatorDots: !0,
        autoplay: !0,
        interval: 3e3,
        duration: 1e3,
        circular: !0,
        statusType: [ "商品详情" ],
        currentType: 0,
        buyNumber: 1,
        buyNumMin: 1,
        buyNumMax: 10,
        shopNum: 0,
        shopType: "addShopCar",
        hideShopPopup: !0,
        goodsDetail: [ {
            taname: "商品规格",
            tavalue: [ "大", "中", "小", "大", "中", "小", "大", "中", "小" ]
        } ]
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), console.log(t);
        var o = t.gid, r = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), r.setData({
                    url: t.data,
                    system: wx.getStorageSync("system")
                });
            }
        }), wx.getLocation({
            type: "wgs84",
            success: function(t) {
                console.log(t), wx.setStorageSync("latitude", t.latitude), wx.setStorageSync("longitude", t.longitude);
                var e = t.latitude, a = t.longitude;
                app.util.request({
                    url: "entry/wxapp/GoodsDetails",
                    cachetime: "0",
                    data: {
                        id: o,
                        latitude: e,
                        longitude: a
                    },
                    success: function(t) {
                        console.log(t), r.setData({
                            goodinfo: t.data.data
                        });
                    }
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "请授权获得地理信息",
                    content: '点击右上角...，进入关于页面，再点击右上角...，进入设置,开启"使用我的地理位置"'
                });
            }
        });
    },
    joinGroup: function(t) {
        this.setData({
            joinGroup: !1
        });
    },
    closeWelfare: function(t) {
        this.setData({
            joinGroup: !0
        });
    },
    statusTap: function(t) {
        this.setData({
            currentType: t.currentTarget.dataset.index
        });
    },
    gotoStore: function(t) {
        console.log(t), wx.navigateTo({
            url: "../shops/shops?id=" + t.currentTarget.dataset.sid
        });
    },
    toAddShopCar: function(t) {
        console.log("------加入购物车------");
        var e = this, a = e.data.goodinfo, o = wx.getStorageSync("is_vip");
        1 == a.is_vip ? 1 == o ? (e.setData({
            shopType: "addShopCar"
        }), e.bindGuiGeTap()) : wx.showToast({
            title: "该商品仅限会员购买",
            icon: "none"
        }) : (e.setData({
            shopType: "addShopCar"
        }), e.bindGuiGeTap());
    },
    tobuy: function(t) {
        console.log("------立即购买------");
        var e = this, a = e.data.goodinfo, o = wx.getStorageSync("is_vip");
        console.log(o), 1 == a.is_vip ? 1 == o ? (e.setData({
            shopType: "tobuy"
        }), e.bindGuiGeTap()) : wx.showToast({
            title: "该商品仅限会员购买",
            icon: "none"
        }) : (e.setData({
            shopType: "tobuy"
        }), e.bindGuiGeTap());
    },
    closePopupTap: function(t) {
        this.setData({
            hideShopPopup: !0
        });
    },
    bindGuiGeTap: function() {
        this.setData({
            hideShopPopup: !1
        });
    },
    labelItemTap: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.propertychildindex;
        this.setData({
            currentIndex: e,
            currentName: t.currentTarget.dataset.propertychildname
        });
    },
    labelItemTaB: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.propertychildindex;
        this.setData({
            currentSel: e,
            currentNamet: t.currentTarget.dataset.propertychildname
        });
    },
    numJianTap: function() {
        if (this.data.buyNumber > this.data.buyNumMin) {
            var t = this.data.buyNumber;
            t--, this.setData({
                buyNumber: t
            });
        }
    },
    numJiaTap: function() {
        if (this.data.buyNumber < this.data.buyNumMax) {
            var t = this.data.buyNumber;
            t++, this.setData({
                buyNumber: t
            });
        }
    },
    goShopCar: function(t) {
        wx.navigateTo({
            url: "../shop-cart/index"
        });
    },
    addShopCar: function(e) {
        var a = this;
        console.log(a.data);
        var o = e.currentTarget.dataset.gid;
        if (a.data.currentIndex) r = a.data.currentNamet; else var r = "";
        if ("" != a.data.goodinfo.spec_name && "" != a.data.goodinfo.spec_names) {
            if (!a.data.currentName || !a.data.currentNamet) return wx.showModal({
                title: "提示",
                content: "请选择商品规格！",
                showCancel: !1
            }), void a.bindGuiGeTap();
            if (console.log(a.data), !t) var t = "";
            if (!r) r = "";
            var n = a.data.buyNumber;
            wx.setStorage({
                key: "order",
                data: {
                    spec: a.data.currentName,
                    spect: a.data.currentNamet,
                    num: n
                }
            }), wx.getStorage({
                key: "openid",
                success: function(t) {
                    app.util.request({
                        url: "entry/wxapp/AddShopCart",
                        cachetime: "0",
                        data: {
                            uid: t.data,
                            gid: o,
                            num: n,
                            combine: a.data.currentName + r,
                            gname: e.currentTarget.dataset.gname,
                            price: e.currentTarget.dataset.price,
                            pic: e.currentTarget.dataset.pic
                        },
                        success: function(t) {
                            console.log(t);
                        }
                    });
                }
            }), a.closePopupTap(), wx.showToast({
                title: "加入购物车成功",
                icon: "success",
                duration: 2e3
            });
        } else if ("" != a.data.goodinfo.spec_name) {
            if (!a.data.currentName) return wx.showModal({
                title: "提示",
                content: "请选择商品规格！",
                showCancel: !1
            }), void a.bindGuiGeTap();
            console.log(a.data);
            n = a.data.buyNumber;
            wx.setStorage({
                key: "order",
                data: {
                    spec: a.data.currentName,
                    spect: a.data.currentNamet,
                    num: n
                }
            }), wx.getStorage({
                key: "openid",
                success: function(t) {
                    app.util.request({
                        url: "entry/wxapp/AddShopCart",
                        cachetime: "0",
                        data: {
                            uid: t.data,
                            gid: o,
                            num: n,
                            combine: a.data.currentName + r,
                            gname: e.currentTarget.dataset.gname,
                            price: e.currentTarget.dataset.price,
                            pic: e.currentTarget.dataset.pic
                        },
                        success: function(t) {
                            console.log(t);
                        }
                    });
                }
            }), a.closePopupTap(), wx.showToast({
                title: "加入购物车成功",
                icon: "success",
                duration: 2e3
            });
        } else if ("" != a.data.goodinfo.spec_names) {
            if (!a.data.currentNamet) return wx.showModal({
                title: "提示",
                content: "请选择商品规格！",
                showCancel: !1
            }), void a.bindGuiGeTap();
            console.log(a.data);
            n = a.data.buyNumber;
            wx.setStorage({
                key: "order",
                data: {
                    spec: a.data.currentName,
                    spect: a.data.currentNamet,
                    num: n
                }
            }), wx.getStorage({
                key: "openid",
                success: function(t) {
                    app.util.request({
                        url: "entry/wxapp/AddShopCart",
                        cachetime: "0",
                        data: {
                            uid: t.data,
                            gid: o,
                            num: n,
                            combine: a.data.currentName + r,
                            gname: e.currentTarget.dataset.gname,
                            price: e.currentTarget.dataset.price,
                            pic: e.currentTarget.dataset.pic
                        },
                        success: function(t) {
                            console.log(t);
                        }
                    });
                }
            }), a.closePopupTap(), wx.showToast({
                title: "加入购物车成功",
                icon: "success",
                duration: 2e3
            });
        } else {
            console.log(a.data);
            n = a.data.buyNumber;
            wx.setStorage({
                key: "order",
                data: {
                    num: n
                }
            }), wx.getStorage({
                key: "openid",
                success: function(t) {
                    app.util.request({
                        url: "entry/wxapp/AddShopCart",
                        cachetime: "0",
                        data: {
                            uid: t.data,
                            gid: o,
                            num: n,
                            combine: "",
                            gname: e.currentTarget.dataset.gname,
                            price: e.currentTarget.dataset.price,
                            pic: e.currentTarget.dataset.pic
                        },
                        success: function(t) {
                            console.log(t);
                        }
                    });
                }
            }), a.closePopupTap(), wx.showToast({
                title: "加入购物车成功",
                icon: "success",
                duration: 2e3
            });
        }
        a.onShow();
    },
    buyNow: function(t) {
        console.log(this.data);
        var e = this;
        if (wx.removeStorageSync("coupon_id"), wx.removeStorageSync("down_price"), "" != e.data.goodinfo.spec_name && "" != e.data.goodinfo.spec_names) {
            if (!e.data.currentName || !e.data.currentNamet) return wx.showModal({
                title: "提示",
                content: "请选择商品规格！",
                showCancel: !1
            }), void e.bindGuiGeTap();
            console.log(e.data);
            var a = e.data.buyNumber;
            wx.navigateTo({
                url: "../to-pay-order/index?gid=" + t.currentTarget.dataset.gid
            }), wx.setStorage({
                key: "order",
                data: {
                    spec: e.data.currentName,
                    spect: e.data.currentNamet,
                    num: a
                }
            }), e.closePopupTap();
        } else if ("" != e.data.goodinfo.spec_name) {
            if (!e.data.currentName) return wx.showModal({
                title: "提示",
                content: "请选择商品规格！",
                showCancel: !1
            }), void e.bindGuiGeTap();
            console.log(e.data);
            a = this.data.buyNumber;
            wx.navigateTo({
                url: "../to-pay-order/index?gid=" + t.currentTarget.dataset.gid
            }), wx.setStorage({
                key: "order",
                data: {
                    spec: e.data.currentName,
                    spect: e.data.currentNamet,
                    num: a
                }
            }), e.closePopupTap();
        } else if ("" != e.data.goodinfo.spec_names) {
            if (!e.data.currentNamet) return wx.showModal({
                title: "提示",
                content: "请选择商品规格！",
                showCancel: !1
            }), void e.bindGuiGeTap();
            console.log(e.data);
            a = e.data.buyNumber;
            wx.navigateTo({
                url: "../to-pay-order/index?gid=" + t.currentTarget.dataset.gid
            }), wx.setStorage({
                key: "order",
                data: {
                    spec: e.data.currentName,
                    spect: e.data.currentNamet,
                    num: a
                }
            }), e.closePopupTap();
        } else {
            console.log(e.data);
            a = e.data.buyNumber;
            wx.navigateTo({
                url: "../to-pay-order/index?gid=" + t.currentTarget.dataset.gid
            }), wx.setStorage({
                key: "order",
                data: {
                    spec: e.data.currentName,
                    spect: e.data.currentNamet,
                    num: a
                }
            }), e.closePopupTap();
        }
        e.bindGuiGeTap();
    },
    onShow: function(t) {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/GetShopCar",
                    cachetime: "0",
                    data: {
                        uid: t.data
                    },
                    success: function(t) {
                        console.log(t), e.setData({
                            shopCarNum: t.data.data.length
                        });
                    }
                });
            }
        });
    },
    callMe: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        });
    }
});