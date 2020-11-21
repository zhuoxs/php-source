var app = getApp(), WxParse = require("../../../../../zhy/template/wxParse/wxParse.js");

Page({
    data: {
        show: !1,
        num: 1,
        showModalStatus: !1,
        omask: !1,
        addCarStatus: !1,
        buyNow: !1,
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
        this.setData({
            id: t.id
        });
        var a = wx.getStorageSync("appConfig"), o = a.showgw;
        if (1 == o) {
            var e = {
                wg_title: a.wg_title,
                wg_directions: a.wg_directions,
                wg_img: a.wg_img,
                wg_keyword: a.wg_keyword,
                wg_addicon: a.wg_addicon
            };
            this.setData({
                showgw: o,
                wglist: e
            });
        }
    },
    onShow: function() {
        var o = this;
        this.setData({
            isChecked: !1,
            chooseSpec: "",
            showModalStatus: !1
        }), this.loadData(), app.ajax({
            url: "Corder|getOrderSet",
            data: {
                type: 2,
                lid: 2
            },
            success: function(t) {
                console.log(t.showorderset);
                var a = t.showorderset;
                o.setData({
                    modalHidden: a.modalHidden,
                    fontcolor: a.fontcolor,
                    bgcolor: a.bgcolor,
                    neworder: t.order
                }), o.gotofly(o, 0);
            }
        });
    },
    loadData: function() {
        var o = this, t = wx.getStorageSync("userInfo") || {};
        app.ajax({
            url: "Cgoods|getGoodsDetail",
            data: {
                gid: o.data.id,
                user_id: t.id
            },
            success: function(t) {
                var a = t.data.details;
                WxParse.wxParse("detail", "html", a, o, 0), t.data.name ? (o.setData({
                    goods: t.data,
                    imgroot: t.other.img_root,
                    show: !0,
                    unitPrice: t.data.cost_price || 0,
                    stock: t.data.stock
                }), o.totalPrice()) : wx.showModal({
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
                goods_id: o.data.id,
                page: o.data.list.page,
                length: o.data.list.length
            },
            success: function(t) {
                o.dealList(t.data, 0);
            }
        });
    },
    onShareAppMessage: function() {
        return {
            title: this.data.goods.name
        };
    },
    prewImg: function(t) {
        for (var a = t.currentTarget.dataset.index, o = t.currentTarget.dataset.idx, e = this.data.list.data[a].imgs, s = [], i = 0; i < e.length; i++) s[i] = this.data.imgroot + e[i];
        wx.previewImage({
            urls: s,
            current: s[o]
        });
    },
    totalPrice: function() {
        var t = this, a = t.data.unitPrice, o = t.data.num, e = (parseFloat(a) * parseInt(o)).toFixed(2);
        t.setData({
            totalPrice: e
        });
    },
    spTap: function(t) {
        var a = this, o = !1, e = t.currentTarget.dataset.index, s = t.currentTarget.dataset.idx, i = (t.currentTarget.dataset.id, 
        a.data.goods);
        i.attr_group_list[e].status = !0;
        for (var r = 0; r < i.attr_group_list.length; r++) {
            if (1 != i.attr_group_list[r].status) {
                o = !1;
                break;
            }
            o = !0;
        }
        i.attr_group_list[e].attr_list.forEach(function(t, a) {
            t.status = !1;
        }), i.attr_group_list[e].attr_list[s].status = !0;
        for (var d = ",", n = "", c = 0; c < i.attr_group_list.length; c++) for (var u = 0; u < i.attr_group_list[c].attr_list.length; u++) i.attr_group_list[c].attr_list[u].status && (d += i.attr_group_list[c].attr_list[u].id + ",", 
        n += i.attr_group_list[c].attr_list[u].name + " ");
        o && app.ajax({
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
            chooseSpec: n,
            isChecked: o
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
        var a = this, o = a.data.buyNow, e = a.data.isChecked, s = a.data.num, i = (a.data.stock, 
        a.data.idGroup);
        e ? app.ajax({
            url: "Cgoods|checkGoods",
            data: {
                gid: a.data.id,
                num: s,
                attr_ids: i
            },
            success: function(t) {
                0 == t.code ? o ? a.buyCur() : a.addCarts() : wx.showToast({
                    title: t.msg,
                    icon: "none"
                });
            }
        }) : wx.showToast({
            title: "请选择规格",
            icon: "none"
        });
    },
    buyCur: function() {
        var o = this, t = wx.getStorageSync("userInfo"), a = o.data.num, e = o.data.stock;
        t ? e < a ? wx.showToast({
            title: "商品库存不足",
            icon: "none"
        }) : app.navTo("/sqtg_sun/pages/plugin/order/classifyorder/classifyorder?type=1&gid=" + o.data.id + "&attrid=" + o.data.idGroup + "&num=" + o.data.num) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/plugin/order/goodsdet/goodsdet?id=" + o.data.id);
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
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
        var a = t.target.dataset.id, o = {};
        o.curHdIndex = a, o.curBdIndex = a, this.setData({
            tabArr: o
        });
    },
    collectGoods: function(t) {
        var o = this, a = o.data.goods, e = t.currentTarget.dataset.status, s = wx.getStorageSync("userInfo");
        s ? 0 == e ? app.ajax({
            url: "Ccollection|addCollection",
            data: {
                user_id: s.id,
                goods_id: o.data.id
            },
            success: function(t) {
                0 == t.code && (wx.showToast({
                    title: "收藏成功"
                }), a.collect_id = t.data, a.collect_status = 1, o.setData({
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
                }), a.collect_status = 0, o.setData({
                    goods: a
                }));
            }
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/plugin/order/goodsdet/goodsdet?id=" + o.data.id);
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    gotofly: function(t, a) {
        var o = t.data.neworder.length;
        a < o && 0 <= a || (a = 0), console.log(a), this.slideupshow(t, 2e3, a, 80, 1), 
        app.globalData.timer_slideupshoworder = setTimeout(function() {
            this.slideupshow(t, 0, a, -80, 0);
        }.bind(this), 5e3);
    },
    slideupshow: function(t, a, o, e, s) {
        var i = t.data.neworder, r = wx.createAnimation({
            duration: a,
            timingFunction: "ease"
        });
        r.translateY(e).opacity(s).step(), i[o].neworderfly = r.export(), t.setData({
            neworder: i
        }), 0 == s && (o++, console.log(o), t.gotofly(t, o));
    },
    showwgtable: function(t) {
        var a = t.currentTarget.dataset.flag;
        this.setData({
            wg_flag: a
        });
    }
});