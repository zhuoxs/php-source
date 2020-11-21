var app = getApp(), WxParse = require("../../../../../zhy/template/wxParse/wxParse.js");

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
        tabArr: {
            curHdIndex: 0,
            curBdIndex: 0
        },
        comment: [],
        unitPrice: 0,
        addCount: 1
    },
    onLoad: function(t) {
        t = app.Func.func.decodeScene(t), this.setData({
            id: t.id
        });
        var a = wx.getStorageSync("appConfig"), s = a.showgw;
        if (1 == s) {
            var e = {
                wg_title: a.wg_title,
                wg_directions: a.wg_directions,
                wg_img: a.wg_img,
                wg_keyword: a.wg_keyword,
                wg_addicon: a.wg_addicon
            };
            this.setData({
                showgw: s,
                wglist: e
            });
        }
    },
    onShow: function() {
        var s = this;
        this.setData({
            isChecked: !1,
            chooseSpec: "",
            showModalStatus: !1
        }), this.loadData(), app.ajax({
            url: "Corder|getOrderSet",
            data: {
                type: 1,
                lid: 1
            },
            success: function(t) {
                console.log(t.showorderset);
                var a = t.showorderset;
                s.setData({
                    modalHidden: a.modalHidden,
                    fontcolor: a.fontcolor,
                    bgcolor: a.bgcolor,
                    neworder: t.order
                }), s.gotofly(s, 0);
            }
        });
    },
    loadData: function() {
        var s = this, t = wx.getStorageSync("userInfo") || {};
        app.ajax({
            url: "Cgoods|getGoodsDetail",
            data: {
                gid: s.data.id,
                user_id: t.id
            },
            success: function(t) {
                console.log(t);
                var a = t.data.details;
                WxParse.wxParse("detail", "html", a, s, 0), t.data.name ? (s.setData({
                    goods: t.data,
                    imgroot: t.other.img_root,
                    show: !0,
                    unitPrice: t.data.cost_price || 0,
                    stock: t.data.stock
                }), s.totalPrice()) : wx.showModal({
                    title: "提示",
                    content: "未找到该商品",
                    showCancel: !1,
                    success: function(t) {
                        app.reTo("/sqtg_sun/pages/home/index/index");
                    }
                });
            }
        }), app.ajax({
            url: "Ccomment|commentList",
            data: {
                goods_id: s.data.id,
                page: s.data.list.page,
                length: s.data.list.length
            },
            success: function(t) {
                s.dealList(t.data, 0);
            }
        });
    },
    onShareAppMessage: function() {
        return {
            title: this.data.goods.name
        };
    },
    prewImg: function(t) {
        for (var a = t.currentTarget.dataset.index, s = t.currentTarget.dataset.idx, e = this.data.list.data[a].imgs, o = [], i = 0; i < e.length; i++) o[i] = this.data.imgroot + e[i];
        wx.previewImage({
            urls: o,
            current: o[s]
        });
    },
    totalPrice: function() {
        var t = this, a = t.data.unitPrice, s = t.data.num, e = (parseFloat(a) * parseInt(s)).toFixed(2);
        t.setData({
            totalPrice: e
        });
    },
    spTap: function(t) {
        var a = this, s = !1, e = t.currentTarget.dataset.index, o = t.currentTarget.dataset.idx, i = (t.currentTarget.dataset.id, 
        a.data.goods);
        i.attr_group_list[e].status = !0;
        for (var n = 0; n < i.attr_group_list.length; n++) {
            if (1 != i.attr_group_list[n].status) {
                s = !1;
                break;
            }
            s = !0;
        }
        i.attr_group_list[e].attr_list.forEach(function(t, a) {
            t.status = !1;
        }), i.attr_group_list[e].attr_list[o].status = !0;
        for (var d = ",", r = "", c = 0; c < i.attr_group_list.length; c++) for (var u = 0; u < i.attr_group_list[c].attr_list.length; u++) i.attr_group_list[c].attr_list[u].status && (d += i.attr_group_list[c].attr_list[u].id + ",", 
        r += i.attr_group_list[c].attr_list[u].name + " ");
        s && app.ajax({
            url: "Cgoods|getGoodsAttrInfo",
            data: {
                gid: a.data.id,
                attr_ids: d
            },
            success: function(t) {
                0 == t.code && (a.setData({
                    chooseGoods: t.data,
                    unitPrice: t.data.price,
                    stock: t.data.stock,
                    idGroup: d
                }), a.totalPrice());
            }
        }), a.setData({
            goods: i,
            chooseSpec: r,
            isChecked: s
        });
    },
    addNum: function(t) {
        var a = t.currentTarget.dataset.num;
        this.data.stock <= a ? wx.showToast({
            title: "商品库存不足",
            icon: "none"
        }) : (this.setData({
            num: ++a
        }), this.totalPrice());
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
        var a = this, s = a.data.buyNow, e = a.data.isChecked, o = a.data.num, i = (a.data.stock, 
        a.data.idGroup);
        e ? app.ajax({
            url: "Cgoods|checkGoods",
            data: {
                gid: a.data.id,
                num: o,
                attr_ids: i
            },
            success: function(t) {
                0 == t.code ? s ? a.buyCur() : a.addCarts() : wx.showToast({
                    title: t.msg,
                    icon: "none"
                });
            }
        }) : wx.showToast({
            title: "请选择规格",
            icon: "none"
        });
    },
    addCarts: function() {
        var s = this, t = wx.getStorageSync("userInfo");
        t ? app.ajax({
            url: "Ccart|setCart",
            data: {
                user_id: t.id,
                gid: s.data.id,
                num: s.data.num,
                type: 1,
                attr_ids: s.data.idGroup
            },
            success: function(t) {
                wx.showToast({
                    title: "加入购物车成功！",
                    icon: "none"
                }), s.setData({
                    addCount: ++s.data.addCount
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/hqs/pages/classifydetail/classifydetail?id=" + s.data.id);
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    buyCur: function() {
        var s = this, t = wx.getStorageSync("userInfo"), a = s.data.num, e = s.data.stock;
        t ? e < a ? wx.showToast({
            title: "商品库存不足",
            icon: "none"
        }) : app.navTo("/sqtg_sun/pages/hqs/pages/classifyorder/classifyorder?type=1&gid=" + s.data.id + "&attrid=" + s.data.idGroup + "&num=" + s.data.num) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/hqs/pages/classifydetail/classifydetail?id=" + s.data.id);
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    addCar: function(t) {
        var a = this, s = t.currentTarget.dataset.statu;
        if (a.data.goods.attr_group_list.length < 1) a.data.addCount <= a.data.stock ? a.addCarts() : wx.showToast({
            title: "商品库存不足",
            icon: "none"
        }); else {
            if ("open" != s) return !1;
            a.setData({
                omask: !0,
                addCarStatus: !0,
                buyNow: !1,
                showModalStatus: !0
            });
        }
    },
    buy: function(t) {
        var a = t.currentTarget.dataset.statu;
        if (this.data.goods.attr_group_list.length < 1) this.buyCur(); else {
            if ("open" != a) return !1;
            this.setData({
                omask: !0,
                addCarStatus: !1,
                buyNow: !0,
                showModalStatus: !0
            });
        }
    },
    close: function(t) {
        if ("close" != t.currentTarget.dataset.statu) return !1;
        this.setData({
            omask: !1,
            buyNow: !1,
            showModalStatus: !1
        });
    },
    swichNav: function(t) {
        var a = t.target.dataset.id, s = {};
        s.curHdIndex = a, s.curBdIndex = a, this.setData({
            tabArr: s
        });
    },
    collectGoods: function(t) {
        var s = this, a = s.data.goods, e = t.currentTarget.dataset.status, o = wx.getStorageSync("userInfo");
        o ? 0 == e ? app.ajax({
            url: "Ccollection|addCollection",
            data: {
                user_id: o.id,
                goods_id: s.data.id
            },
            success: function(t) {
                0 == t.code && (wx.showToast({
                    title: "收藏成功"
                }), a.collect_id = t.data, a.collect_status = 1, s.setData({
                    goods: a
                }));
            }
        }) : app.ajax({
            url: "Ccollection|cancelCollection",
            data: {
                id: a.collect_id
            },
            success: function(t) {
                0 == t.code && (wx.showToast({
                    title: "取消成功",
                    icon: "none"
                }), a.collect_status = 0, s.setData({
                    goods: a
                }));
            }
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/hqs/pages/classifydetail/classifydetail?id=" + s.data.id);
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    shareCanvas: function() {
        console.log("生成海报");
        var t = this.data.goods, a = [];
        a.gid = t.id, a.bname = t.name, a.url = this.data.imgroot, a.logo = t.pics[0], a.price = t.price, 
        a.scene = "id=" + this.data.id, app.Func.func.creatPoster("/sqtg_sun/pages/hqs/pages/classifydetail/classifydetail", 430, a, 1, "shareImg");
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
        var s = t.data.neworder.length;
        a < s && 0 <= a || (a = 0), console.log(a), this.slideupshow(t, 2e3, a, 80, 1), 
        app.globalData.timer_slideupshoworder = setTimeout(function() {
            this.slideupshow(t, 0, a, -80, 0);
        }.bind(this), 5e3);
    },
    slideupshow: function(t, a, s, e, o) {
        var i = t.data.neworder, n = wx.createAnimation({
            duration: a,
            timingFunction: "ease"
        });
        n.translateY(e).opacity(o).step(), i[s].neworderfly = n.export(), t.setData({
            neworder: i
        }), 0 == o && (s++, console.log(s), t.gotofly(t, s));
    },
    showwgtable: function(t) {
        var a = t.currentTarget.dataset.flag;
        this.setData({
            wg_flag: a
        });
    }
});