function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var a, e = require("../../../utils/base.js"), i = require("../../../../api.js"), d = new e.Base(), n = getApp();

Page((a = {
    data: {
        specSwitch: !1,
        limittab: 1,
        linged: !1,
        notice_mask: !1,
        nav_H: 0,
        markers: [ {
            iconPath: "../../pages/img/address_module.png",
            id: 0,
            latitude: "",
            longitude: "",
            width: 20,
            height: 20,
            zIndex: 999,
            callout: {
                content: "",
                color: "#000000",
                fontSize: "14",
                borderRadius: 3,
                padding: 3,
                display: "ALWAYS",
                textAlign: "center"
            }
        } ],
        infoAuth: !0,
        newCoupon: !0,
        sceneData: ""
    },
    onLoad: function(t) {
        var a = this;
        t.scene && (this.data.sceneData = t.scene), this.getIndexData(), n.getInformation(function(t) {
            wx.setNavigationBarTitle({
                title: t.info.name
            }), a.setData({
                platform: t
            });
        }), this.getUserData(), n.getTabBar();
    },
    onShow: function() {
        var t = this;
        this.setData({
            specSwitch: !1
        }), n.userInfoAuth(function(a) {
            t.setData({
                infoAuth: a
            });
        });
    },
    onReady: function() {
        this.videoContext = wx.createVideoContext("myVideo");
    },
    onPullDownRefresh: function() {
        n.pageOnLoad(), this.getIndexData(), wx.showNavigationBarLoading(), setTimeout(function() {
            wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
        }, 500);
    },
    onShareAppMessage: function() {
        var t = wx.getStorageSync("userData").user_info.id, a = encodeURIComponent("parentId=" + t + " & id= & type=share");
        return {
            title: this.data.platform.name,
            path: "/boguan_mall/pages/Tab/index/index?pageId=&scene=" + a
        };
    },
    myCatchTouch: function(t) {
        return !1;
    },
    play: function(t) {
        console.log(t);
        var a = this, e = "myVideo" + t.currentTarget.dataset.index, i = (this.data.diy, 
        t.currentTarget.dataset.index);
        a.setData({
            play: i
        }), wx.createVideoContext(e).play();
    },
    videoEnded: function(t) {
        this.setData({
            play: -1
        });
    },
    getIndexData: function() {
        var t = this, a = wx.getStorageSync("indexData");
        this.setData({
            diy: a
        });
        var e = {
            url: i.default.index
        };
        d.getData(e, function(a) {
            if (console.log("首页数据=>", a), 1 == a.errorCode) {
                for (var e in a.diy_data) {
                    if ("cenNav" == a.diy_data[e].name && 1 == a.diy_data[e].data.perpage) {
                        a.diy_data[e].data.page = Math.ceil(a.diy_data[e].data.data.length / Number(a.diy_data[e].data.maxperpage));
                        for (var i = [], d = 0, n = 0; n < a.diy_data[e].data.data.length; n += a.diy_data[e].data.maxperpage) i.push(a.diy_data[e].data.data.slice(n, n + a.diy_data[e].data.maxperpage)), 
                        d = 170 * Math.ceil(a.diy_data[e].data.maxperpage / a.diy_data[e].data.selectNum) + 20;
                        a.diy_data[e].data.result = i, a.diy_data[e].data.navHeight = d;
                    }
                    if ("customGoods" == a.diy_data[e].name) for (var n in a.diy_data[e].data.data) a.diy_data[e].data.data[n].price = parseFloat(a.diy_data[e].data.data[n].price), 
                    a.diy_data[e].data.data[n].o_price = parseFloat(a.diy_data[e].data.data[n].o_price), 
                    a.diy_data[e].data.data[n].vip_price = parseFloat(a.diy_data[e].data.data[n].vip_price);
                    if ("laymap" == a.diy_data[e].name) {
                        var o = t.data.markers, s = a.diy_data[e].data.location.split(",");
                        o[0].longitude = s[0], o[0].latitude = s[1], o[0].callout.content = a.diy_data[e].data.addressName, 
                        o[0].address = a.diy_data[e].data.address, a.diy_data[e].data.markers = o;
                    }
                }
                wx.setStorageSync("indexData", a), t.setData({
                    diy: a
                });
            } else wx.setStorageSync("indexData", ""), t.setData({
                diy: []
            });
        });
    },
    getUserData: function() {
        var t = this, a = {
            url: i.default.user
        };
        d.getData(a, function(a) {
            var e = 0;
            1 == a.errorCode && (wx.setStorageSync("userData", a), e = a.user_info.is_vip), 
            t.setData({
                userData: a,
                is_vip: e
            });
        });
    },
    buylimitTab: function(t) {
        var a = t.currentTarget.dataset.limittab;
        this.setData({
            limittab: a
        });
    },
    noticePopup: function(t) {
        var a = t.currentTarget.dataset.text;
        this.setData({
            notice_mask: !this.data.notice_mask,
            notice_text: a
        });
    },
    lingCoupon: function(t) {
        var a = this, e = this.data.diy.diy_data[t.currentTarget.dataset.index].data.data, n = {
            url: i.default.ling_coupon,
            data: {
                couponId: t.currentTarget.dataset.id
            }
        };
        d.getData(n, function(i) {
            if (1 == i.errorCode) for (var d in e) e[d].id == t.currentTarget.dataset.id && (e[d].is_receive = 1, 
            a.data.diy.diy_data[t.currentTarget.dataset.index].data.data = e, a.setData({
                diy: a.data.diy
            }));
            wx.showToast({
                title: i.msg,
                icon: "none"
            });
        });
    },
    getUserInfo: function(t) {
        var a = this;
        wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] ? wx.getUserInfo({
                    success: function(t) {
                        n.userInfoAuth(function(t) {
                            a.setData({
                                infoAuth: t
                            });
                        }), "" != a.data.sceneData && n.bind(a.data.sceneData), wx.setStorageSync("userInfo", t.userInfo), 
                        n.updateToken(function(a) {
                            if ("undefined" != a) {
                                var e = {
                                    url: i.default.user_update,
                                    data: {
                                        nickname: t.userInfo.nickName,
                                        avatar: t.userInfo.avatarUrl
                                    }
                                };
                                d.getData(e, function(t) {});
                            }
                        });
                    }
                }) : "" != a.data.sceneData && n.bind(a.data.sceneData);
            }
        });
    },
    openSpec: function(t) {
        var a = t.currentTarget.dataset.goodinfo, e = a.attr, i = [];
        for (var d in e) {
            var n = {
                title: d,
                attr_Spec: e[d]
            };
            i.push(n);
        }
        this.setData({
            specSwitch: !0,
            newSpec: i,
            goodId: a.id,
            product: a,
            attrInfo: [],
            specValue: [],
            goodsNum: 1
        });
    },
    closeSpec: function(t) {
        this.setData({
            specSwitch: !1
        });
    },
    checkSpec: function(t) {
        var a = this, e = this.data.newSpec, n = (t.target.dataset.attr, t.target.dataset.attrid), o = t.target.dataset.spec, s = [], r = [];
        for (var c in e) if (c == o) for (var u in e[c].attr_Spec) e[c].attr_Spec[u].attr_id == n ? e[c].attr_Spec[u].checked = !0 : e[c].attr_Spec[u].checked = !1;
        for (var c in e) for (var u in e[c].attr_Spec) e[c].attr_Spec[u].checked && (s.push(e[c].attr_Spec[u].attr_id), 
        r.push(e[c].attr_Spec[u].attr_name), this.setData({
            newSpec: e,
            specId: s,
            specValue: r,
            specLength: s.length
        }));
        var p = {
            url: i.default.attr_info,
            data: {
                product_id: this.data.goodId,
                attr_id_list: s
            }
        };
        d.getData(p, function(t) {
            console.log(t), 1 == t.errorCode && (t.data.price = parseFloat(t.data.price), a.setData({
                attrInfo: t.data,
                stock: t.data.stock,
                price: t.data.price
            }));
        });
    }
}, t(a, "myCatchTouch", function(t) {
    return 0;
}), t(a, "add", function() {
    var t = this.data.goodsNum;
    1 == this.data.product.is_attr ? this.data.specLength == this.data.newSpec.length ? t >= this.data.stock ? wx.showToast({
        title: "商品数量超出库存",
        icon: "none"
    }) : this.setData({
        goodsNum: t + 1
    }) : wx.showToast({
        title: "请选择规格",
        icon: "none"
    }) : t >= this.data.product.stock ? wx.showToast({
        title: "商品数量超出库存",
        icon: "none"
    }) : this.setData({
        goodsNum: t + 1
    });
}), t(a, "sum", function() {
    var t = this.data.goodsNum;
    this.setData({
        goodsNum: t - 1
    });
}), t(a, "AddCart", function(t) {
    var a = this;
    wx.showLoading({
        title: "请稍后"
    });
    var e = "";
    1 == this.data.product.is_attr ? this.data.specLength == this.data.newSpec.length ? e = {
        url: i.default.addcart,
        data: {
            product_id: this.data.product.id,
            num: this.data.goodsNum,
            attr_id_list: this.data.specId
        }
    } : wx.showToast({
        title: "请选择规格",
        icon: "none"
    }) : e = {
        url: i.default.addcart,
        data: {
            product_id: this.data.product.id,
            num: this.data.goodsNum
        }
    }, "" != e && d.getData(e, function(t) {
        setTimeout(function() {
            wx.hideLoading({
                complete: function(a) {
                    wx.showToast({
                        title: t.msg,
                        icon: "none"
                    });
                }
            });
        }, 500), 1 == t.errorCode && a.setData({
            specSwitch: !1
        }), console.log("加入购物车", t);
    });
}), t(a, "tobuy", function(t) {
    var a = this.data.product;
    1 == this.data.product.is_attr ? this.data.specLength == this.data.newSpec.length ? wx.navigateTo({
        url: "../../User/order/order_pay/order_pay?buyType=0&goodId=" + a.id + "&num=" + this.data.goodsNum + "&attr_id_list=" + this.data.specId + "&specValue=" + this.data.specValue
    }) : wx.showToast({
        title: "请选择规格",
        icon: "none"
    }) : wx.navigateTo({
        url: "../../User/order/order_pay/order_pay?buyType=0&goodId=" + a.id + "&num=" + this.data.goodsNum + "&attr_id_list=&specValue="
    });
}), t(a, "newCoupon_close", function(t) {
    this.setData({
        newCoupon: !1
    });
}), t(a, "navigatorLink", function(t) {
    n.navClick(t, this);
}), a));