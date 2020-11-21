var t = require("../../../utils/base.js"), a = require("../../../../wxParse/wxParse.js"), e = require("../../../../api.js"), o = new t.Base(), s = getApp();

Page({
    data: {
        current: 0,
        swicthIndex: 1,
        specSwitch: !1,
        share: !1,
        Explain: !1,
        dis: !1,
        video_hide: "hide",
        maskVisual: "hide",
        goodsNum: 1,
        shareImage: "",
        commentArray: [],
        infoAuth: !0,
        sceneData: ""
    },
    onLoad: function(t) {
        var a = this;
        t.scene ? this.enCode(t) : this.getProduct(t.goodId), t.scene && (this.data.sceneData = t.scene), 
        s.getInformation(function(t) {
            a.setData({
                platform: t
            });
        });
        var e = wx.getStorageSync("userData");
        e.user_info ? this.setData({
            userData: e,
            is_vip: e.user_info.is_vip
        }) : this.getUserData(), s.getTabBar();
    },
    onShow: function() {
        var t = this;
        this.getCart(), s.userInfoAuth(function(a) {
            t.setData({
                infoAuth: a
            });
        }), this.setData({
            specSwitch: !1
        });
    },
    getUserData: function() {
        var t = this, a = {
            url: e.default.user
        };
        o.getData(a, function(a) {
            var e = 0;
            1 == a.errorCode && (wx.setStorageSync("userData", a), e = a.user_info.is_vip, t.setData({
                userData: a,
                is_vip: e
            }));
        });
    },
    getUserInfo: function(t) {
        var a = this;
        wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] ? wx.getUserInfo({
                    success: function(t) {
                        s.userInfoAuth(function(t) {
                            a.setData({
                                infoAuth: t
                            });
                        }), wx.setStorageSync("userInfo", t.userInfo), s.updateToken(function(a) {
                            if ("undefined" != a) {
                                var s = {
                                    url: e.default.user_update,
                                    data: {
                                        nickname: t.userInfo.nickName,
                                        avatar: t.userInfo.avatarUrl
                                    }
                                };
                                o.getData(s, function(t) {});
                            }
                        }), "" != a.data.sceneData && s.bind(a.data.sceneData);
                    }
                }) : "" != a.data.sceneData && s.bind(a.data.sceneData);
            }
        });
    },
    enCode: function(t) {
        var a = [], e = decodeURIComponent(t.scene).split("&");
        for (var o in e) {
            var s = e[o].split("=");
            a.push(s);
        }
        var i = {};
        for (var n in a) i = {
            parentId: a[0][1],
            id: a[1][1],
            type: a[2][1]
        };
        console.log("转码后的参数obj", i), this.getProduct(i.id);
    },
    onShareAppMessage: function() {
        var t = wx.getStorageSync("userData").user_info.id, a = encodeURIComponent("parentId=" + t + " & id=" + this.data.product.id + " & type=share");
        return {
            title: this.data.product.name,
            path: "/boguan_mall/pages/Home/goods/goods?goodId=" + this.data.product.id + "&scene=" + a,
            imageUrl: this.data.product.thumb
        };
    },
    myCatchTouch: function(t) {
        return !1;
    },
    getProduct: function(t) {
        var s = this, i = this, n = {
            url: e.default.product,
            data: {
                productId: t
            },
            method: "GET"
        };
        o.getData(n, function(t) {
            if (console.log("商品数据=>", t), 1 == t.errorCode) {
                t.data.price = parseFloat(t.data.price), t.data.o_price = parseFloat(t.data.o_price), 
                t.data.vip_price = parseFloat(t.data.vip_price);
                var e = t.data.content, o = [], n = t.data.image, r = [];
                e && a.wxParse("content", "html", e, i);
                for (var d in t.data.attr) {
                    var c = {
                        title: d,
                        attr_Spec: t.data.attr[d]
                    };
                    o.push(c);
                }
                r.push(t.data.comment), s.setData({
                    product: t.data,
                    goodId: t.data.id,
                    bannerLength: n ? n.length : 0,
                    newSpec: o,
                    is_collect: t.data.is_collect,
                    commentArray: r
                });
            } else 0 == t.errorCode && wx.showModal({
                title: "提示",
                content: "该商品不存在或者已下架",
                showCancel: !1,
                success: function(t) {
                    wx.reLaunch({
                        url: "/boguan_mall/pages/Tab/index/index"
                    });
                }
            });
        });
    },
    checkSpec: function(t) {
        var a = this, s = this.data.newSpec, i = (t.target.dataset.attr, t.target.dataset.attrid), n = t.target.dataset.spec, r = [], d = [];
        for (var c in s) if (c == n) for (var u in s[c].attr_Spec) s[c].attr_Spec[u].attr_id == i ? s[c].attr_Spec[u].checked = !0 : s[c].attr_Spec[u].checked = !1;
        for (var c in s) for (var u in s[c].attr_Spec) s[c].attr_Spec[u].checked && (r.push(s[c].attr_Spec[u].attr_id), 
        d.push(s[c].attr_Spec[u].attr_name), this.setData({
            newSpec: s,
            specId: r,
            specValue: d,
            specLength: r.length,
            goodsNum: 1
        }));
        var h = {
            url: e.default.attr_info,
            data: {
                product_id: this.data.product.id,
                attr_id_list: r
            }
        };
        o.getData(h, function(t) {
            console.log("规格信息=>", t), 1 == t.errorCode && (t.data.price = parseFloat(t.data.price), 
            a.setData({
                attrInfo: t.data,
                stock: t.data.stock,
                price: t.data.price
            }));
        });
    },
    add: function() {
        var t = this.data.goodsNum;
        1 == this.data.product.is_attr ? this.data.specLength == this.data.newSpec.length ? t >= this.data.stock ? wx.showToast({
            title: "商品数量超出库存",
            icon: "none"
        }) : this.setData({
            goodsNum: t + 1
        }) : wx.showToast({
            title: "请选择规格",
            icon: "none"
        }) : t >= this.data.stock ? wx.showToast({
            title: "商品数量超出库存",
            icon: "none"
        }) : this.setData({
            goodsNum: t + 1
        });
    },
    sum: function() {
        var t = this.data.goodsNum;
        this.setData({
            goodsNum: t - 1
        });
    },
    AddCart: function(t) {
        var a = this;
        wx.showLoading({
            title: "请稍后"
        });
        var s = "";
        1 == this.data.product.is_attr ? this.data.specLength == this.data.newSpec.length ? s = {
            url: e.default.addcart,
            data: {
                product_id: this.data.product.id,
                num: this.data.goodsNum,
                attr_id_list: this.data.specId
            }
        } : wx.showToast({
            title: "请选择规格",
            icon: "none"
        }) : s = {
            url: e.default.addcart,
            data: {
                product_id: this.data.product.id,
                num: this.data.goodsNum
            }
        }, "" != s && o.getData(s, function(t) {
            console.log(t), setTimeout(function() {
                wx.hideLoading({
                    complete: function(a) {
                        wx.showToast({
                            title: t.msg,
                            icon: "none"
                        });
                    }
                });
            }, 200), 1 == t.errorCode && a.setData({
                specSwitch: !1
            }), a.getCart();
        });
    },
    getCart: function() {
        var t = this, a = {
            url: e.default.getCart,
            method: "GET"
        };
        o.getData(a, function(a) {
            if (1 == a.errorCode) {
                for (var e = 0, o = 0; o < a.data.info.length; o++) 1 == a.data.info[o].product.can_buy && (e += a.data.info[o].num);
                t.setData({
                    cartNum: e
                });
            }
        });
    },
    lingCoupon: function(t) {
        var a = this, s = t.currentTarget.dataset.index, i = {
            url: e.default.ling_coupon,
            data: {
                couponId: t.currentTarget.dataset.id
            }
        };
        o.getData(i, function(t) {
            1 == t.errorCode && (a.data.product.coupon[s].is_receive = 1, a.setData({
                product: a.data.product
            })), wx.showToast({
                title: t.msg,
                icon: "none"
            });
        });
    },
    tobuy: function() {
        1 == this.data.product.is_attr ? this.data.specLength == this.data.newSpec.length ? wx.navigateTo({
            url: "../../User/order/order_pay/order_pay?buyType=0&goodId=" + this.data.goodId + "&num=" + this.data.goodsNum + "&attr_id_list=" + this.data.specId + "&specValue=" + this.data.specValue
        }) : wx.showToast({
            title: "请选择规格",
            icon: "none"
        }) : wx.navigateTo({
            url: "../../User/order/order_pay/order_pay?buyType=0&goodId=" + this.data.goodId + "&num=" + this.data.goodsNum + "&attr_id_list=&specValue="
        });
    },
    collection: function(t) {
        var a = this, s = t.currentTarget.dataset.id, i = {
            url: e.default.product_collect,
            data: {
                productId: s
            }
        };
        o.getData(i, function(t) {
            console.log(t), a.setData({
                is_collect: t.data.is_collect
            });
        });
    },
    current: function(t) {
        var a = t.detail.current;
        this.setData({
            current: a,
            bannerLength: this.data.bannerLength
        });
    },
    openSpec: function(t) {
        t.target.dataset.type ? this.setData({
            specSwitch: !0,
            type: t.target.dataset.type
        }) : this.setData({
            specSwitch: !0,
            type: 0
        });
    },
    closeSpec: function(t) {
        this.setData({
            specSwitch: !1
        });
    },
    open_Explain: function(t) {
        this.setData({
            Explain: !this.data.Explain
        });
    },
    colseDis: function(t) {
        this.setData({
            dis: !this.data.dis
        });
    },
    play: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.videourl;
        this.setData({
            videoUrl: a,
            video_hide: ""
        });
        var e = wx.createVideoContext("myVideo");
        e.pause(), setTimeout(function() {
            e.play();
        }, 150);
    },
    palyError: function(t) {
        console.log(t);
    },
    close: function(t) {
        this.setData({
            video_hide: "hide"
        }), wx.createVideoContext("myVideo").pause();
    },
    cascadeToggle: function() {
        var t = this;
        "show" == t.data.maskVisual ? (t.cascadeDismiss(), t.setData({
            noscroll: !1
        })) : (t.cascadePopup(), t.setData({
            noscroll: !0
        }));
    },
    cascadePopup: function() {
        var t = wx.createAnimation({
            duration: 300,
            timingFunction: "ease-in-out"
        });
        this.animation = t, t.bottom(0).step(), this.setData({
            animationData: this.animation.export(),
            maskVisual: "show"
        });
    },
    cascadeDismiss: function() {
        this.animation.bottom(-500).step(), this.setData({
            animationData: this.animation.export(),
            maskVisual: "hidden"
        });
    },
    shareOpen: function(t) {
        var a = this;
        if ("" == this.data.shareImage && !this.data.share) {
            wx.showLoading({
                title: "获取图片中",
                mask: !0
            });
            var s = {
                url: e.default.getShareImage,
                data: {
                    productId: t.currentTarget.dataset.id
                },
                method: "GET"
            };
            o.getData(s, function(t) {
                console.log(t), wx.hideLoading(), 1 == t.errorCode && a.setData({
                    shareImage: t.data
                });
            });
        }
        this.setData({
            share: !this.data.share
        });
    },
    openBannerImg: function(t) {
        var a = t.currentTarget.dataset.index;
        wx.previewImage({
            current: this.data.product.image[a],
            urls: this.data.product.image
        });
    },
    openImg: function(t) {
        console.log(t);
        var a = [];
        a.push(t.currentTarget.dataset.img), wx.previewImage({
            current: a[0],
            urls: a
        });
    },
    downImage: function(t) {
        wx.downloadFile({
            url: t.currentTarget.dataset.img,
            success: function(t) {
                wx.saveImageToPhotosAlbum({
                    filePath: t.tempFilePath,
                    success: function(t) {
                        wx.showModal({
                            title: "下载成功",
                            showCancel: !1
                        });
                    }
                });
            }
        });
    }
});