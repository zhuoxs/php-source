function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var WxParse = require("../../../../../zhy/template/wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        padding: !1,
        refresh: !0,
        tabArr: {
            curHdIndex: 0,
            curBdIndex: 0
        },
        alert: !1,
        canAlert: {
            flag: 0,
            msg: ""
        },
        param: {
            num: 1,
            goods_id: 0,
            ladder_id: 0,
            groupnum: 0,
            groupmoney: 0,
            shop_id: 0,
            ordertype: 1,
            is_member: 0
        },
        minNum: 1,
        maxNum: 1,
        ajax: !1,
        choose: 0
    },
    onLoad: function(a) {
        var t = a.id.split("-");
        if (this.setData(_defineProperty({
            param_sid: t[0],
            param_hid: t[1]
        }, "param.goods_id", t[0])), 0 < t[1] && this.setData(_defineProperty({}, "param.is_member", 1)), 
        t[2] && wx.setStorageSync("share_user_id", t[2]), t[3]) {
            console.log(54);
            var e = wx.getStorageSync("linkaddress"), i = t[3], o = e ? e.id : 0, n = this;
            n.setData({
                newleader_id: i,
                oldleader_id: o,
                linkaddress: e
            }), console.log(i), console.log(o), i != o ? wx.getLocation({
                type: "wgs84",
                success: function(a) {
                    var t = a.latitude, e = a.longitude;
                    app.ajax({
                        url: "Cleader|getLeader",
                        data: {
                            longitude: e,
                            latitude: t,
                            leader_id: i
                        },
                        success: function(t) {
                            wx.showModal({
                                title: "提示",
                                content: t.data.community + "小区的" + t.data.name + "团长距离您" + t.data.distance / 1e3 + "Km",
                                success: function(a) {
                                    a.confirm ? (wx.setStorageSync("linkaddress", t.data), n.setData({
                                        linkaddress: t.data
                                    }), n.loadData()) : a.cancel && (console.log("用户点击取消"), app.lunchTo("/sqtg_sun/pages/home/index/index"));
                                }
                            });
                        }
                    });
                },
                fail: function(a) {
                    console.log("获取地址失败"), i || o ? n.setData({
                        popAllow: !0
                    }) : app.lunchTo("/sqtg_sun/pages/home/index/index");
                }
            }) : n.setData({
                linkaddress: e
            });
        }
        this.loadRule();
    },
    onShow: function() {
        this.onLoadData();
        var t = this;
        setInterval(function() {
            var a = new Date().getTime();
            t.setData({
                curr: a
            });
        }, 1e3);
    },
    onUnload: function() {
        clearInterval(this.timer);
    },
    loadRule: function() {
        var t = this;
        app.api.getCpinGetRules().then(function(a) {
            WxParse.wxParse("rule", "html", a.data, t, 0);
        }).catch(function(a) {
            a.code, app.tips(a.msg);
        }), this.loadList();
    },
    onLoadData: function() {
        var h = this, i = this, a = wx.getStorageSync("userInfo"), t = wx.getStorageSync("linkaddress");
        if (a) {
            this.setData(_defineProperty({
                uInfo: a
            }, "param.user_id", a.id));
            var e = {
                goods_id: this.data.param_sid,
                heads_id: this.data.param_hid,
                user_id: this.data.uInfo.id,
                leader_id: t.id
            };
            this.data.refresh && (this.setData(_defineProperty({
                refresh: !1,
                alert: !1
            }, "param.num", 1)), app.api.getCpinGoodsDetails(e).then(function(a) {
                var t;
                WxParse.wxParse("detail", "html", a.data.details, h, 0);
                var e = a.data.limit_times - a.data.my_buy_num, i = "";
                0 == a.data.limit_times ? e = 1.0000000001e21 : i = "已达购买上限";
                var o = new Date().getTime() / 1e3, n = a.data.start_time - 0, r = a.data.end_time - 0, d = {};
                o < n ? (d = {
                    status: 1,
                    time: n - o
                }, e = 0, i = "即将开始") : n <= o && o < r ? d = {
                    status: 2,
                    time: r - o
                } : (d = {
                    status: 3,
                    time: 0
                }, e = 0, i = "活动已结束", h.setData({
                    countDown: d
                })), 3 != d.status && (clearInterval(h.timer), h.timer = setInterval(function() {
                    --d.time, d.time <= 0 && ((o = new Date().getTime() / 1e3) < n ? (d = {
                        status: 1,
                        time: n - o
                    }, e = 0, i = "即将开始") : n <= o && o < r ? (d = {
                        status: 2,
                        time: r - o
                    }, e = a.data.limit_times - a.data.my_buy_num) : (d = {
                        status: 3,
                        time: 0
                    }, e = 0, i = "活动已结束", clearInterval(h.timer))), h.setData({
                        countDown: d,
                        canAlert: {
                            flag: e,
                            msg: i
                        }
                    });
                }, 1e3));
                var s = "", p = a.data.choose_type.stock - 0, u = a.data.limit_num - 0;
                s = 0 == u ? p : u <= p ? u : p;
                var _ = 0;
                if (1 == a.data.is_group_coupon && (0 < a.data.coupon_money && (_ = a.data.coupon_money), 
                0 < a.data.coupon_discount)) {
                    var f = (a.data.coupon_discount - 0) / 10;
                    _ = (a.data.groupmoney - f * a.data.groupmoney).toFixed(2);
                }
                if (s < 1 && h.setData(_defineProperty({
                    minNum: 0
                }, "param.num", 0)), h.setData((_defineProperty(t = {
                    imgRoot: a.other.img_root,
                    info: a.data,
                    show: !0,
                    maxNum: s,
                    canAlert: {
                        flag: e,
                        msg: i
                    }
                }, "param.attr_list", a.data.attr_list), _defineProperty(t, "param.attr_ids", a.data.attr_ids), 
                _defineProperty(t, "param.ladder_id", a.data.ladder_id), _defineProperty(t, "param.groupnum", a.data.groupnum), 
                _defineProperty(t, "param.groupmoney", a.data.groupmoney), _defineProperty(t, "param.money", a.data.groupmoney), 
                _defineProperty(t, "param.coupon_moneys", _), _defineProperty(t, "param.delivery_single", a.data.delivery_single), 
                t)), 0 < h.data.param_hid && 1 == a.data.is_ladder) {
                    var m = 0, l = a.data.heads_info.ladder_id;
                    for (var c in a.data.ladder_info) a.data.ladder_info[c].id == l && (m = c);
                    h.onGroupSelectTab(m);
                }
            }).catch(function(a) {
                -1 == a.code ? app.tips(a.msg) : "商品不存在" == a.msg ? wx.showModal({
                    title: "提示",
                    content: "商品不存在！",
                    showCancel: !1,
                    success: function(a) {
                        clearInterval(i.timer), app.lunchTo("/sqtg_sun/pages/plugin/spell/list/list");
                    }
                }) : app.tips(a.msg);
            }));
        } else wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(a) {
                if (a.confirm) {
                    var t = i.data.param_sid + "-" + i.data.param_hid, e = encodeURIComponent("/sqtg_sun/pages/plugin/spell/info/info?id=" + t);
                    clearInterval(i.timer), app.reTo("/sqtg_sun/pages/home/login/login?id=" + e);
                } else a.cancel && (clearInterval(i.timer), app.lunchTo("/sqtg_sun/pages/home/index/index"));
            }
        });
    },
    toggleMask: function(a) {
        var t, e = a.currentTarget.dataset.key;
        0 < this.data.canAlert.flag && this.setData((_defineProperty(t = {}, "param.ordertype", e), 
        _defineProperty(t, "alert", !this.data.alert), t));
    },
    toggleMask1: function() {
        this.setData({
            alert: !this.data.alert
        });
    },
    getNum: function(a) {
        this.setData(_defineProperty({}, "param.num", a.detail));
    },
    onGroupSelectTab: function(a) {
        var t, e = 0;
        e = 0 <= a - 0 ? a : a.currentTarget.dataset.index;
        var i = this.data.info.ladder_info;
        for (var o in i) i[o].choose = o == e;
        var n = 0;
        if (1 == this.data.info.is_group_coupon && (0 < this.data.info.coupon_money && (n = this.data.info.coupon_money), 
        0 < this.data.info.coupon_discount)) {
            var r = (this.data.info.coupon_discount - 0) / 10;
            n = (this.data.info.ladder_info[e].groupmoney - r * this.data.info.ladder_info[e].groupmoney).toFixed(2);
        }
        this.setData((_defineProperty(t = {}, "info.ladder_info", i), _defineProperty(t, "param.ladder_id", this.data.info.ladder_info[e].id), 
        _defineProperty(t, "param.groupnum", this.data.info.ladder_info[e].groupnum), _defineProperty(t, "param.groupmoney", this.data.info.ladder_info[e].groupmoney), 
        _defineProperty(t, "param.money", this.data.info.ladder_info[e].groupmoney), _defineProperty(t, "param.coupon_moneys", n), 
        _defineProperty(t, "info.choose_type.pin_price", this.data.info.ladder_info[e].groupmoney), 
        _defineProperty(t, "info.reduce_mopney", "拼团立省： ￥" + (this.data.info.original_price - this.data.info.ladder_info[e].groupmoney).toFixed(2)), 
        t));
    },
    onGroupSelectTabBuy: function(a) {
        var t, e = 0;
        e = 0 <= a - 0 ? a : a.currentTarget.dataset.index;
        var i = this.data.info.ladder_info;
        for (var o in i) i[o].choose = o == e;
        var n = 0;
        if (1 == this.data.info.is_group_coupon && (0 < this.data.info.coupon_money && (n = this.data.info.coupon_money), 
        0 < this.data.info.coupon_discount)) {
            var r = (this.data.info.coupon_discount - 0) / 10;
            n = (this.data.info.ladder_info[e].groupmoney - r * this.data.info.ladder_info[e].groupmoney).toFixed(2);
        }
        this.setData((_defineProperty(t = {}, "info.ladder_info", i), _defineProperty(t, "param.ladder_id", this.data.info.ladder_info[e].id), 
        _defineProperty(t, "param.groupnum", this.data.info.ladder_info[e].groupnum), _defineProperty(t, "param.groupmoney", this.data.info.ladder_info[e].groupmoney), 
        _defineProperty(t, "param.money", this.data.info.ladder_info[e].groupmoney), _defineProperty(t, "param.coupon_moneys", n), 
        _defineProperty(t, "info.choose_type.pin_price", this.data.info.ladder_info[e].groupmoney), 
        _defineProperty(t, "info.reduce_mopney", "拼团立省： ￥" + (this.data.info.original_price - this.data.info.ladder_info[e].groupmoney).toFixed(2)), 
        t));
        var d, s = a.currentTarget.dataset.key;
        0 < this.data.canAlert.flag && this.setData((_defineProperty(d = {}, "param.ordertype", s), 
        _defineProperty(d, "alert", !this.data.alert), d));
    },
    onSelectTab: function(a) {
        var d = this;
        if (!this.data.ajax) {
            this.setData({
                ajax: !0
            });
            var t = a.currentTarget.dataset.index, e = a.currentTarget.dataset.idx, s = this.data.info.attr_group_list;
            for (var i in s[t].attr_list) s[t].attr_list[i].choose = i == e;
            var p = ",", u = ",", _ = "";
            for (var o in s) for (var n in s[o].attr_list) s[o].attr_list[n].choose && (p += s[o].attr_list[n].id + ",", 
            u += s[o].attr_list[n].name + ",", _ += s[o].attr_list[n].name + " ");
            var r = {
                goods_id: this.data.param_sid,
                attr_ids: p
            };
            app.api.getCpinGetAttrInfo(r).then(function(a) {
                var t, e = "", i = a.data.stock - 0, o = d.data.limit_num - 0;
                e = 0 == o ? i : o <= i ? o : i;
                var n = 0;
                if (1 == d.data.info.is_group_coupon && (0 < d.data.info.coupon_money && (n = d.data.info.coupon_money), 
                0 < d.data.info.coupon_discount)) {
                    var r = (d.data.info.coupon_discount - 0) / 10;
                    n = (a.data.pin_price - r * (a.data.pin_price - 0)).toFixed(2);
                }
                e < 1 ? d.setData(_defineProperty({
                    minNum: 0
                }, "param.num", 0)) : d.setData(_defineProperty({}, "param.num", 1)), d.setData((_defineProperty(t = {}, "info.attr_group_list", s), 
                _defineProperty(t, "info.choose_name", _), _defineProperty(t, "maxNum", e), _defineProperty(t, "ajax", !1), 
                _defineProperty(t, "info.choose_type", a.data), _defineProperty(t, "info.reduce_mopney", "拼团立省： ￥" + (d.data.info.original_price - a.data.pin_price).toFixed(2)), 
                _defineProperty(t, "param.attr_list", u), _defineProperty(t, "param.attr_ids", p), 
                _defineProperty(t, "param.groupmoney", a.data.pin_price), _defineProperty(t, "param.money", a.data.pin_price), 
                _defineProperty(t, "param.coupon_moneys", n), t));
            }).catch(function(a) {
                d.setData({
                    ajax: !1
                }), a.code, app.tips(a.msg);
            });
        }
    },
    formSubmit: function(a) {
        var t = a.detail.formId;
        if (this.setData(_defineProperty({}, "param.prepay_id", t)), !(this.data.param.num < 1)) {
            var e = this.data.param;
            e.showname = this.data.info.name, e.show_choose_name = this.data.info.choose_name, 
            e.showpic = this.data.imgRoot + this.data.info.choose_type.pic, 1 == this.data.info.is_group_coupon && 0 < this.data.info.coupon_discount && (e.coupon_moneys = (e.coupon_moneys * e.num).toFixed(2)), 
            e.coupon_money = e.coupon_moneys, 2 == e.ordertype && (e.groupmoney = this.data.info.choose_type.price, 
            e.money = this.data.info.choose_type.price), e.postagerules_id = this.data.info.postagerules_id, 
            e.weight = this.data.info.choose_type.weight, e.sincetype = 1 == this.data.info.sendtype ? 2 : 1, 
            e.store_id = this.data.info.store_id, e.heads_id = this.data.param_hid, e.delivery_fee = this.data.info.delivery_fee, 
            e = JSON.stringify(e), clearInterval(this.timer), app.navTo("/sqtg_sun/pages/plugin/spell/order/order?id=" + e);
        }
    },
    onOpenReloadTab: function() {
        var a = this.data.param_sid + "-0";
        app.reTo("/sqtg_sun/pages/plugin/spell/info/info?id=" + a);
    },
    onHomeOrShopTab: function() {
        app.lunchTo("/sqtg_sun/pages/home/index/index");
    },
    onHomeTab: function() {
        app.lunchTo("/sqtg_sun/pages/home/index/index");
    },
    onNavTab: function(a) {
        this.setData({
            choose: a.currentTarget.dataset.id
        });
    },
    loadList: function() {
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            this.data.list.page, this.data.list.length, this.data.param_sid;
        }
    },
    prewImg: function(a) {
        for (var t = a.currentTarget.dataset.index, e = a.currentTarget.dataset.idx, i = this.data.list.data[t].imgs, o = [], n = 0; n < i.length; n++) o[n] = this.data.imgRoot + i[n];
        wx.previewImage({
            urls: o,
            current: o[e]
        });
    },
    onReachBottom: function() {
        this.loadList();
    },
    onShareAppMessage: function() {
        var a = wx.getStorageSync("linkaddress"), t = this.data.param_sid + "-" + this.data.param_hid + "-" + this.data.uInfo.id + "-" + a.id;
        return console.log(t), {
            title: this.data.info.name,
            path: "/sqtg_sun/pages/plugin/spell/info/info?id=" + t
        };
    },
    joinpage: function(a) {
        var t = a.currentTarget.dataset.headid + "-" + a.currentTarget.dataset.goodsid + "-" + a.currentTarget.dataset.user + "-" + a.currentTarget.dataset.leaderid;
        console.log(t), app.lunchTo("/sqtg_sun/pages/plugin/spell/join/join?id=" + t);
    }
});