var Page = require("../../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page, app = getApp(), setIndex = 0, WxParse = require("../../../../../zhy/template/wxParse/wxParse.js");

Page({
    data: {
        show: !1,
        num: 1,
        showModalStatus: !1,
        omask: !1,
        addCarStatus: !1,
        buyNow: !1,
        hidden: !0,
        specification: {
            spindex: 0
        },
        unitPrice: 0,
        addCount: 1,
        shareMask: !1,
        protect: !0,
        currenttab: 0,
        options: []
    },
    onLoad: function(t) {
        var a = this;
        app.ajax({
            url: "Csystem|getSetting",
            success: function(t) {
                a.setData({
                    setting: t.data
                });
            }
        }), t = app.Func.func.decodeScene(t), this.data.num = 0, this.setData({
            id: t.id,
            num: 1,
            options: t
        }), (t.s_id || t.share_user_id) && wx.setStorageSync("share_user_id", t.s_id || t.share_user_id);
    },
    onHide: function() {
        clearInterval(setIndex), clearTimeout(app.globalData.timer_slideupshoworder);
    },
    onUnload: function() {
        this.onHide();
    },
    shareJudge: function() {
        var s = this, t = wx.getStorageSync("userInfo") || {};
        if (t && 0 < t.id) if (s.setData({
            uInfo: t
        }), s.data.options.l_id || s.data.options.leader_id) {
            a = wx.getStorageSync("linkaddress");
            var o = s.data.options.l_id || s.data.options.leader_id, n = a ? a.id : 0;
            s.setData({
                newleader_id: o,
                oldleader_id: n,
                linkaddress: a
            }), console.log("newleader_id：" + o), console.log("oldleader_id：" + n), o != n ? wx.getLocation({
                type: "wgs84",
                success: function(t) {
                    console.log("地址信息"), console.log(t);
                    var a = t.latitude, e = t.longitude;
                    app.ajax({
                        url: "Cleader|getLeader",
                        data: {
                            longitude: e,
                            latitude: a,
                            leader_id: o
                        },
                        success: function(a) {
                            console.log("切换团长信息"), console.log(a), console.log(s.data.setting), console.log(s.data.setting.leader_replace), 
                            wx.showModal({
                                title: "提示",
                                content: a.data.community + "小区的" + a.data.name + s.data.setting.leader_replace + "距离您" + a.data.distance / 1e3 + "Km",
                                success: function(t) {
                                    if (console.log("显示点击确定和取消"), console.log(t), t.confirm) wx.setStorageSync("linkaddress", a.data), 
                                    s.setData({
                                        linkaddress: a.data
                                    }), s.loadData(); else if (t.cancel) {
                                        console.log("用户点击取消"), !s.data.goods.leader_has && 0 < n ? (app.tips("当前" + s.data.setting.leader_replace + "没有此商品！"), 
                                        setTimeout(function() {
                                            app.lunchTo("/sqtg_sun/pages/home/index/index");
                                        }, 1e3)) : 0 < !n && (app.tips("当前没有" + s.data.setting.leader_replace + "！"), setTimeout(function() {
                                            app.lunchTo("/sqtg_sun/pages/home/index/index");
                                        }, 1e3));
                                    }
                                }
                            });
                        }
                    });
                },
                fail: function(t) {
                    console.log("获取地址失败"), o || n ? s.setData({
                        popAllow: !0
                    }) : app.lunchTo("/sqtg_sun/pages/home/index/index");
                }
            }) : s.setData({
                linkaddress: a
            });
        } else {
            var a;
            (a = wx.getStorageSync("linkaddress")) ? s.setData({
                linkaddress: a
            }) : app.navTo("/sqtg_sun/pages/zkx/pages/nearleaders/nearleaders");
        } else wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/zkx/pages/classifydetail/classifydetail?id=" + s.data.id + "&l_id=" + s.data.options.l_id);
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    onShow: function() {
        var a = this, t = wx.getStorageSync("appConfig"), e = t.showgw;
        if (1 == e) {
            var s = {
                wg_title: t.wg_title,
                wg_directions: t.wg_directions,
                wg_img: t.wg_img,
                wg_keyword: t.wg_keyword,
                wg_addicon: t.wg_addicon
            };
            a.setData({
                showgw: e,
                wglist: s
            });
        }
        setIndex = setInterval(function() {
            var t = new Date().getTime();
            a.setData({
                curr: t
            });
        }, 1e3), a.setData({
            isChecked: !1,
            chooseSpec: "",
            showModalStatus: !1
        }), this.loadData(), this.shareJudge();
    },
    loadData: function() {
        var e = this, t = wx.getStorageSync("linkaddress"), a = t ? t.id : 0, s = wx.getStorageSync("userInfo") || {};
        app.ajax({
            url: "Cgoods|getGoods",
            data: {
                goods_id: e.data.id,
                leader_id: a,
                user_id: s.id
            },
            success: function(t) {
                if (t.data) {
                    var a = t.data.details;
                    WxParse.wxParse("detail", "html", a, e, 0), t.data.delivery_single = parseInt(t.data.delivery_single), 
                    e.setData({
                        goods: t.data,
                        imgroot: t.other.img_root,
                        show: !0,
                        unitPrice: t.data.price || 0,
                        stock: t.data.stock,
                        limit: t.data.limit,
                        bought: t.data.bought
                    }), e.totalPrice();
                }
            },
            fail: function(t) {
                e.setData({
                    show: !0
                }), wx.showModal({
                    title: "提示",
                    content: "未找到该商品",
                    showCancel: !1,
                    success: function(t) {
                        app.reTo("/sqtg_sun/pages/home/index/index");
                    }
                });
            }
        }), app.ajax({
            url: "Corder|getOrderSet",
            data: {
                goods_id: e.data.id
            },
            success: function(t) {
                console.log(t);
                var a = t.showorderset;
                e.setData({
                    modalHidden: a.modalHidden,
                    fontcolor: a.fontcolor,
                    bgcolor: a.bgcolor,
                    neworder: t.order
                }), e.gotofly(e, 0);
            }
        });
    },
    totalPrice: function() {
        var t = this, a = t.data.unitPrice, e = t.data.num, s = (parseFloat(a) * parseInt(e)).toFixed(2);
        t.setData({
            totalPrice: s
        });
    },
    spTap: function(t) {
        var a = this, e = a.data.protect, s = !1, o = t.currentTarget.dataset.index, n = t.currentTarget.dataset.idx, i = (t.currentTarget.dataset.id, 
        a.data.goods);
        i.attrgroups[o].status = !0;
        for (var d = 0; d < i.attrgroups.length; d++) {
            if (1 != i.attrgroups[d].status) {
                s = !1;
                break;
            }
            s = !0;
        }
        i.attrgroups[o].attrs.forEach(function(t, a) {
            t.status = !1;
        }), i.attrgroups[o].attrs[n].status = !0;
        for (var r = ",", c = "", l = 0; l < i.attrgroups.length; l++) for (var u = 0; u < i.attrgroups[l].attrs.length; u++) i.attrgroups[l].attrs[u].status && (r += i.attrgroups[l].attrs[u].id + ",", 
        c += i.attrgroups[l].attrs[u].name + " ");
        e && s && (a.setData({
            protect: !1
        }), a.setData({
            show: !1
        }), app.ajax({
            url: "Cgoods|getGoodsAttrs",
            data: {
                goods_id: a.data.id,
                attr_ids: r
            },
            success: function(t) {
                console.log(t), a.setData({
                    protect: !0
                }), a.setData({
                    show: !0
                }), 0 == t.code && (a.setData({
                    chooseGoods: t.data,
                    unitPrice: t.data[0].price,
                    stock: t.data[0].stock,
                    idGroup: r,
                    choosePic: t.data[0].pic
                }), a.totalPrice());
            },
            fail: function(t) {
                a.setData({
                    protect: !0
                }), a.setData({
                    show: !0
                }), app.tips(t.data.msg);
            }
        })), a.setData({
            goods: i,
            chooseSpec: c,
            isChecked: s
        });
    },
    addNum: function(t) {
        var a = this, e = t.currentTarget.dataset.num, s = a.data.stock, o = a.data.limit, n = a.data.bought;
        console.log(o), s <= e ? wx.showToast({
            title: "商品库存不足",
            icon: "none"
        }) : 0 < o && o <= e + n ? (console.log(0 < e), wx.showToast({
            title: "已到限购数量",
            icon: "none"
        })) : (a.setData({
            num: ++e
        }), a.totalPrice());
    },
    reduceNum: function(t) {
        var a = t.currentTarget.dataset.num;
        1 < a ? (this.setData({
            num: --a
        }), this.totalPrice()) : wx.showToast({
            title: "商品不得少于1件",
            icon: "none"
        });
    },
    formSubmit: function(t) {
        var a = this, e = a.data.buyNow, s = a.data.isChecked, o = a.data.num, n = (a.data.stock, 
        a.data.idGroup, a.data.goods), i = a.data.limit, d = a.data.bought;
        s || !n.use_attr || n.attrgroups.length < 1 ? 0 < i && i < o + d ? wx.showToast({
            title: "超过限购数量",
            icon: "none"
        }) : this.data.protect && (e ? a.buyCur() : a.addCarts()) : wx.showToast({
            title: "请选择规格",
            icon: "none"
        });
    },
    addCarts: function() {
        var e = this, t = wx.getStorageSync("userInfo"), a = e.data.goods;
        t ? app.ajax({
            url: "Ccart|joinCart",
            data: {
                user_id: t.id,
                leader_id: e.data.linkaddress.id,
                goods_id: a.id,
                store_id: a.store_id,
                num: e.data.num,
                attr_ids: a.use_attr ? e.data.idGroup : "",
                attr_names: a.use_attr ? e.data.chooseSpec : ""
            },
            success: function(t) {
                wx.showToast({
                    title: "加入购物车成功！",
                    icon: "none"
                }), e.setData({
                    addCount: ++e.data.addCount
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/zkx/pages/classifydetail/classifydetail?id=" + e.data.id);
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    buyCur: function() {
        var e = this, t = wx.getStorageSync("userInfo") || {};
        if (t) {
            var a = e.data.num;
            if (e.data.stock < a) wx.showToast({
                title: "商品库存不足",
                icon: "none"
            }); else {
                var s = e.data.goods;
                s.num = a, s.attr_ids = e.data.idGroup, s.attr_names = e.data.chooseSpec, s.price = e.data.unitPrice, 
                s.goods_id = s.id, s.user_id = t.id, e.data.newLeader ? s.leader_id = e.data.newleader_id : s.leader_id = e.data.linkaddress.id, 
                s.use_attr ? s.pic = e.data.choicePic || s.pics[0] || s.pic : s.pics && s.pics.length && (s.pic = s.pics[0]), 
                delete s.id, e.setData({
                    goodses: [ s ]
                }), app.navTo("/sqtg_sun/pages/zkx/pages/classifyorder/classifyorder");
            }
        } else wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/zkx/pages/classifydetail/classifydetail?id=" + e.data.id);
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    addCar: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.data.goods;
        if ("open" != a) return !1;
        this.setData({
            omask: !0,
            addCarStatus: !0,
            buyNow: !1,
            showModalStatus: !0
        });
    },
    buy: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.data.goods;
        if ("open" != a) return !1;
        this.setData({
            omask: !0,
            addCarStatus: !1,
            buyNow: !0,
            showModalStatus: !0
        });
    },
    close: function(t) {
        if ("close" != t.currentTarget.dataset.statu) return !1;
        this.setData({
            omask: !1,
            buyNow: !1,
            showModalStatus: !1
        });
    },
    shareCanvas: function() {
        var t = this, a = wx.getStorageSync("appConfig"), e = wx.getStorageSync("userInfo"), s = t.data.goods, o = [];
        o.gid = s.id, o.bname = s.name, o.url = t.data.imgroot, o.logo = s.pics[0], o.goodspicbg = a.goods_pic_b, 
        o.price = s.price, o.original_price = s.original_price, o.stock = s.stock, o.sales_num = s.sales_num, 
        o.scene = "id=" + t.data.id, o.scene += "&s_id=" + e.id, o.scene += "&l_id=" + t.data.linkaddress.id, 
        app.Func.func.creatPoster2("sqtg_sun/pages/zkx/pages/classifydetail/classifydetail", 430, o, 1, "shareImg"), 
        t.setData({
            shareMask: !1
        });
    },
    hidden: function(t) {
        this.setData({
            hidden: !0
        });
    },
    save: function() {
        var a = this;
        wx.saveImageToPhotosAlbum({
            filePath: a.data.prurl,
            success: function(t) {
                console.log("成功"), wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(t) {
                        t.confirm && (console.log("用户点击确定"), a.setData({
                            hidden: !0
                        }));
                    }
                });
            },
            fail: function(t) {
                console.log("失败"), wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    gotofly: function(t, a) {
        var e = (t.data.neworder || []).length;
        e && (a < e && 0 <= a || (a = 0), this.slideupshow(t, 2e3, a, 80, 1), app.globalData.timer_slideupshoworder = setTimeout(function() {
            t.slideupshow(t, 0, a, -80, 0);
        }, 5e3));
    },
    slideupshow: function(t, a, e, s, o) {
        var n = t.data.neworder, i = wx.createAnimation({
            duration: a,
            timingFunction: "ease"
        });
        i.translateY(s).opacity(o).step(), n[e].neworderfly = i.export(), t.setData({
            neworder: n
        }), 0 == o && (e++, t.gotofly(t, e));
    },
    showwgtable: function(t) {
        var a = t.currentTarget.dataset.flag;
        this.setData({
            wg_flag: a
        });
    },
    unshare: function() {
        this.setData({
            shareMask: !1
        });
    },
    tapShare: function() {
        this.setData({
            shareMask: !0
        });
    },
    toIndex: function() {
        app.lunchTo("/sqtg_sun/pages/home/index/index");
    },
    onShareAppMessage: function(t) {
        var a = wx.getStorageSync("userInfo");
        return {
            title: this.data.goods.name,
            path: "/sqtg_sun/pages/zkx/pages/classifydetail/classifydetail?id=" + this.data.id + "&s_id=" + a.id + "&l_id=" + this.data.linkaddress.id
        };
    },
    handler: function(t) {
        var s = this;
        if (t.detail.authSetting["scope.userLocation"]) {
            var o = s.data.newleader_id, n = s.data.oldleader_id;
            o != n ? wx.getLocation({
                type: "wgs84",
                success: function(t) {
                    var a = t.latitude, e = t.longitude;
                    app.ajax({
                        url: "Cleader|getLeader",
                        data: {
                            longitude: e,
                            latitude: a,
                            leader_id: o
                        },
                        success: function(a) {
                            s.setData({
                                popAllow: !1
                            }), wx.showModal({
                                title: "提示",
                                content: a.data.community + "小区的" + a.data.name + s.data.setting.leader_replace + "距离您" + a.data.distance / 1e3 + "Km",
                                success: function(t) {
                                    if (t.confirm) wx.setStorageSync("linkaddress", a.data), s.setData({
                                        linkaddress: a.data
                                    }), s.loadData(); else if (t.cancel) {
                                        console.log("用户点击取消"), !s.data.goods.leader_has && 0 < n ? (app.tips("当前" + s.data.setting.leader_replace + "没有此商品！"), 
                                        setTimeout(function() {
                                            app.lunchTo("/sqtg_sun/pages/home/index/index");
                                        }, 1e3)) : 0 < !n && (app.tips("当前没有" + s.data.setting.leader_replace + "！"), setTimeout(function() {
                                            app.lunchTo("/sqtg_sun/pages/home/index/index");
                                        }, 1e3));
                                    }
                                }
                            });
                        }
                    });
                },
                fail: function(t) {
                    console.log("获取地址失败"), o || n ? s.setData({
                        popAllow: !0
                    }) : app.lunchTo("/sqtg_sun/pages/home/index/index");
                }
            }) : s.setData({
                linkaddress: linkaddress
            });
        } else app.lunchTo("/sqtg_sun/pages/home/index/index");
    },
    allowAddress: function() {
        wx.getLocation({
            success: function(t) {
                console.log(t);
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    addPlat: function(t) {
        var a = this.data.num + 1;
        this.setData({
            num: a
        });
    },
    reducePlat: function(t) {
        var a = this.data.num - 1;
        0 < a ? this.setData({
            num: a
        }) : wx.showToast({
            title: "数量不能为0",
            icon: "none"
        });
    },
    onCommodityDetails: function(t) {
        if (t) {
            if (this.data.currenttab == t.currentTarget.dataset.tabid) return !1;
            this.setData({
                currenttab: t.currentTarget.dataset.tabid
            });
        }
    }
});