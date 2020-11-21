function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var a, e = require("../../../utils/base.js"), d = require("../../../../api.js"), i = new e.Base(), o = getApp();

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
        sceneData: ""
    },
    onLoad: function(t) {
        var a = this;
        t.scene && (this.data.sceneData = t.scene), o.getTabBar(), o.getInformation(function(t) {
            a.setData({
                platform: t
            });
        }), this.getUserData(), this.getIndexData(t.pageId);
    },
    onShow: function() {
        var t = this;
        this.setData({
            specSwitch: !1
        }), o.userInfoAuth(function(a) {
            t.setData({
                infoAuth: a
            });
        });
    },
    onReady: function() {
        this.videoContext = wx.createVideoContext("myVideo");
    },
    onPullDownRefresh: function() {
        this.getIndexData(), wx.showNavigationBarLoading(), setTimeout(function() {
            wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
        }, 1e3);
    },
    onShareAppMessage: function() {
        var t = wx.getStorageSync("userData").user_info.id, a = encodeURIComponent("parentId=" + t + " & id= & type=share");
        return {
            title: this.data.diy.home.title,
            path: "/boguan_mall/pages/Tab/index_diy/index_diy?pageId=" + this.data.diy.id + "&scene=" + a
        };
    },
    myCatchTouch: function(t) {
        return !1;
    },
    play: function(t) {
        console.log(t);
        var a = this, e = "myVideo" + t.currentTarget.dataset.index, d = (this.data.diy, 
        t.currentTarget.dataset.index);
        a.setData({
            play: d
        }), wx.createVideoContext(e).play();
    },
    videoEnded: function(t) {},
    getIndexData: function(t) {
        var a = this, e = {
            url: d.default.index,
            data: {
                pageId: t
            }
        };
        i.getData(e, function(t) {
            if (1 == t.errorCode) {
                console.log(t);
                for (var e in t.diy_data) {
                    if ("cenNav" == t.diy_data[e].name && 1 == t.diy_data[e].data.perpage) {
                        t.diy_data[e].data.page = Math.ceil(t.diy_data[e].data.data.length / Number(t.diy_data[e].data.maxperpage));
                        for (var d = [], i = 0, o = 0; o < t.diy_data[e].data.data.length; o += t.diy_data[e].data.maxperpage) d.push(t.diy_data[e].data.data.slice(o, o + t.diy_data[e].data.maxperpage)), 
                        i = 170 * Math.ceil(t.diy_data[e].data.maxperpage / t.diy_data[e].data.selectNum) + 20;
                        t.diy_data[e].data.result = d, t.diy_data[e].data.navHeight = i;
                    }
                    if ("customGoods" == t.diy_data[e].name) for (var o in t.diy_data[e].data.data) t.diy_data[e].data.data[o].price = parseFloat(t.diy_data[e].data.data[o].price), 
                    t.diy_data[e].data.data[o].o_price = parseFloat(t.diy_data[e].data.data[o].o_price), 
                    t.diy_data[e].data.data[o].vip_price = parseFloat(t.diy_data[e].data.data[o].vip_price);
                    if ("laymap" == t.diy_data[e].name) {
                        var n = a.data.markers, r = t.diy_data[e].data.location.split(",");
                        n[0].longitude = r[0], n[0].latitude = r[1], n[0].callout.content = t.diy_data[e].data.addressName, 
                        n[0].address = t.diy_data[e].data.address, t.diy_data[e].data.markers = n;
                    }
                }
                wx.setNavigationBarTitle({
                    title: t.home.title
                }), a.setData({
                    diy: t
                });
            }
        });
    },
    getUserData: function() {
        var t = this, a = {
            url: d.default.user
        };
        i.getData(a, function(a) {
            console.log("用户信息=>", a);
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
        var a = this;
        console.log(t);
        var e = this.data.diy.diy_data[t.currentTarget.dataset.index].data.data;
        console.log(e), console.log(t.currentTarget.dataset.id);
        var o = {
            url: d.default.ling_coupon,
            data: {
                couponId: t.currentTarget.dataset.id
            }
        };
        i.getData(o, function(d) {
            if (1 == d.errorCode) for (var i in e) e[i].id == t.currentTarget.dataset.id && (e[i].is_receive = 1, 
            a.data.diy.diy_data[t.currentTarget.dataset.index].data.data = e, a.setData({
                diy: a.data.diy
            }));
            wx.showToast({
                title: d.msg,
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
                        o.userInfoAuth(function(t) {
                            a.setData({
                                infoAuth: t
                            });
                        }), "" != a.data.sceneData && o.bind(a.data.sceneData), wx.setStorageSync("userInfo", t.userInfo), 
                        o.updateToken(function(a) {
                            if ("undefined" != a) {
                                var e = {
                                    url: d.default.user_update,
                                    data: {
                                        nickname: t.userInfo.nickName,
                                        avatar: t.userInfo.avatarUrl
                                    }
                                };
                                i.getData(e, function(t) {});
                            }
                        });
                    }
                }) : "" != a.data.sceneData && o.bind(a.data.sceneData);
            }
        });
    },
    openSpec: function(t) {
        console.log("e=>", t);
        var a = t.currentTarget.dataset.goodinfo, e = a.attr, d = [];
        for (var i in e) {
            var o = {
                title: i,
                attr_Spec: e[i]
            };
            d.push(o);
        }
        this.setData({
            specSwitch: !0,
            newSpec: d,
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
        var a = this, e = this.data.newSpec, o = (t.target.dataset.attr, t.target.dataset.attrid), n = t.target.dataset.spec, r = [], s = [];
        for (var c in e) if (c == n) for (var u in e[c].attr_Spec) e[c].attr_Spec[u].attr_id == o ? e[c].attr_Spec[u].checked = !0 : e[c].attr_Spec[u].checked = !1;
        for (var c in e) for (var u in e[c].attr_Spec) e[c].attr_Spec[u].checked && (r.push(e[c].attr_Spec[u].attr_id), 
        s.push(e[c].attr_Spec[u].attr_name), this.setData({
            newSpec: e,
            specId: r,
            specValue: s,
            specLength: r.length
        }));
        var p = {
            url: d.default.attr_info,
            data: {
                product_id: this.data.goodId,
                attr_id_list: r
            }
        };
        i.getData(p, function(t) {
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
        url: d.default.addcart,
        data: {
            product_id: this.data.product.id,
            num: this.data.goodsNum,
            attr_id_list: this.data.specId
        }
    } : wx.showToast({
        title: "请选择规格",
        icon: "none"
    }) : e = {
        url: d.default.addcart,
        data: {
            product_id: this.data.product.id,
            num: this.data.goodsNum
        }
    }, "" != e && i.getData(e, function(t) {
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
}), t(a, "navigatorLink", function(t) {
    console.log(t), o.navClick(t, this);
}), a));