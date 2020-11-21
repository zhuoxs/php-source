/*www.lanrenzhijia.com   time:2019-06-01 22:11:50*/
function a(a, t, i) {
    return t in a ? Object.defineProperty(a, t, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = i, a
}
function t(a, t, i, o, e, n, d) {
    return a < t ? {
        status: 1,
        time: t - a,
        time_txt: "距离开始：",
        alert_msg: ""
    } : a >= t && a < i ? {
        status: 2,
        time: i - a,
        time_txt: "距离结束：",
        alert_msg: ""
    } : a >= i && a < o ? {
        status: 3,
        time: o - a,
        time_txt: "距离过期：",
        alert_msg: ""
    } : a >= o ? {
        status: 4,
        time: 0,
        time_txt: "已结束",
        alert_msg: ""
    } : {
        status: -1,
        time: "",
        time_txt: "未知",
        alert_msg: ""
    }
}
function i(a, t, i, o) {
    var e = 1,
        n = a,
        d = "已达最大库存！",
        r = !1,
        s = "",
        p = "",
        _ = "一键开团";
    return 0 == a ? (e = n = 0, d = "库存不足！", r = !0, s = p = "已售完", _ = "库存不足") : o >= i && i > 0 ? (e = n = 0, d = "已达限购次数！", r = !0, s = p = "已达限购次数", _ = "已达限购次数") : t > 0 && (t > a ? (n = a, d = "已达最大库存！") : (n = t, d = "已达单次购买最大数量！")), 0 == n && (e = 0), {
        max: n,
        min: e,
        tipsNum: d,
        preventA: !1,
        preventB: r,
        preventTxtA: s,
        preventTxtB: p,
        btnBtxt: _
    }
}
var o = require("../../../zhy/template/wxParse/wxParse.js"),
    e = getApp();
e.Base({
    data: {
        mask: !1,
        share: !1,
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
        choose: 0,
        navChoose: 0,
        numType: 0
    },
    onLoad: function(t) {
        var i, o = t.id.split("-");
        o[2] && o[2] > 0 && (wx.setStorageSync("s_id", o[2]), this.checkDistribution({
            s_id: o[2]
        })), this.setData((i = {
            jumpId: t.id,
            param_sid: o[0],
            param_hid: o[1]
        }, a(i, "param.goods_id", o[0]), a(i, "reload", !0), i)), o[1] > 0 && this.setData(a({}, "param.is_member", 1)), this.loadListData()
    },
    getSetting: function(a) {
        this.setData({
            support: a.detail
        })
    },
    onUnload: function() {
        clearInterval(this.timer)
    },
    onShow: function() {
        var t = this;
        this.data.reload && (this.setData({
            reload: !1,
            mask: !1
        }), this.checkLogin(function(i) {
            t.setData(a({
                user: i
            }, "param.user_id", i.id));
            var o = (new Date).getTime() / 1e3,
                e = 0;
            e = i.vip_endtime && o <= i.vip_endtime ? 1 : i.vip_endtime && o > i.vip_endtime ? 2 : 0, t.setData({
                vipStatus: e
            }), t.onLoadData()
        }, "/plugin/spell/info/info?id=" + this.data.jumpId, !0))
    },
    onLoadData: function() {
        var n = this,
            d = {
                goods_id: this.data.param_sid,
                heads_id: this.data.param_hid,
                user_id: this.data.user.id
            };
        this.setData(a({
            alert: !1
        }, "param.num", 1)), e.api.apiCommonGetNowTime().then(function(a) {
            return n.setData({
                now_time: a.data
            }), e.api.apiPinGoodsDetails(d)
        }).then(function(d) {
            o.wxParse("detail", "html", d.data.details, n, 0);
            var r = n.data.now_time - 0,
                s = d.data.start_time - 0,
                p = d.data.end_time - 0,
                _ = d.data.expire_time - 0,
                m = (d.data.limit_times, d.data.limit_num, d.data.my_buy_num, t(r, s, p, _));
            if (n.setData({
                countDown: m
            }), r > s && n.setData({
                numType: 1
            }), d.data.use_attr > 0) {
                var u = ",",
                    c = ",",
                    h = "";
                for (var l in d.data.attr_group_list) u += d.data.attr_group_list[l].attr_list[0].id + ",", c += d.data.attr_group_list[l].attr_list[0].name + ",", d.data.attr_group_list[l].attr_list[0].choose = !0, h += d.data.attr_group_list[l].attr_list[0].name + " ";
                d.data.choose_name = h;
                var f = {
                    goods_id: d.data.id,
                    attr_ids: u
                };
                e.api.apiPinGetAttrInfo(f).then(function(t) {
                    var o;
                    d.data.choose_type = t.data, d.data.attr_list = c, d.data.attr_ids = u, d.data.ladder_id = 0, d.data.groupnum = d.data.need_num, d.data.groupmoney = t.data.pin_price, d.data.reduce_mopney = "拼团立省： ￥" + (d.data.original_price - t.data.pin_price).toFixed(2);
                    var e = i(t.data.stock - 0, d.data.limit_num - 0, d.data.limit_times - 0, d.data.my_buy_num - 0),
                        r = 0;
                    if (1 == d.data.is_group_coupon && (d.data.coupon_money > 0 && (r = d.data.coupon_money), d.data.coupon_discount > 0)) {
                        var s = (d.data.coupon_discount - 0) / 10;
                        r = (d.data.groupmoney - s * d.data.groupmoney).toFixed(2)
                    }
                    n.setData((o = {}, a(o, "param.num", e.min), a(o, "maxMin", e), a(o, "imgRoot", d.other.img_root), a(o, "info", d.data), a(o, "show", !0), a(o, "info.choose_type", t.data), a(o, "param.attr_list", d.data.attr_list), a(o, "param.attr_ids", d.data.attr_ids), a(o, "param.ladder_id", d.data.ladder_id), a(o, "param.groupnum", d.data.groupnum), a(o, "param.groupmoney", 1 == n.data.vipStatus ? t.data.vip_price : t.data.pin_price), a(o, "param.money", 1 == n.data.vipStatus ? t.data.vip_price : t.data.pin_price), a(o, "param.coupon_moneys", r), o))
                })
            } else {
                var g, v = a({
                    id: 0,
                    goods_id: d.data.id,
                    stock: d.data.stock,
                    price: d.data.price,
                    pin_price: d.data.pin_price,
                    vip_price: d.data.vip_price,
                    alonepay_vip_price: d.data.alonepay_vip_price,
                    weight: d.data.weight,
                    pic: d.data.pic
                }, "pin_price", d.data.pin_price);
                d.data.attr_list = "", d.data.attr_ids = "", d.data.choose_name = "单规格", d.data.is_ladder > 0 ? d.data.ladder_info ? (d.data.ladder_info[0].choose = !0, d.data.reduce_mopney = "拼团立省： ￥" + (d.data.original_price - d.data.ladder_info[0].groupmoney).toFixed(2), d.data.ladder_id = d.data.ladder_info[0].id, d.data.groupnum = d.data.ladder_info[0].groupnum, d.data.groupmoney = d.data.ladder_info[0].groupmoney, d.data.vip_groupmoney = d.data.ladder_info[0].vip_groupmoney) : d.data.reduce_mopney = "阶梯团数据不完整，请商家设置！" : (d.data.ladder_id = 0, d.data.groupnum = d.data.need_num, d.data.groupmoney = d.data.pin_price, d.data.reduce_mopney = "拼团立省： ￥" + (d.data.original_price - d.data.pin_price).toFixed(2)), d.data.choose_type = v;
                var y = 0;
                if (1 == d.data.is_group_coupon && (d.data.coupon_money > 0 && (y = d.data.coupon_money), d.data.coupon_discount > 0)) {
                    var x = (d.data.coupon_discount - 0) / 10;
                    y = (d.data.groupmoney - x * d.data.groupmoney).toFixed(2)
                }
                var D = i(d.data.stock - 0, d.data.limit_num - 0, d.data.limit_times - 0, d.data.my_buy_num - 0);
                n.setData((g = {}, a(g, "param.num", D.min), a(g, "maxMin", D), a(g, "imgRoot", d.other.img_root), a(g, "info", d.data), a(g, "show", !0), a(g, "param.attr_list", d.data.attr_list), a(g, "param.attr_ids", d.data.attr_ids), a(g, "param.ladder_id", d.data.ladder_id), a(g, "param.groupnum", d.data.groupnum), a(g, "param.groupmoney", 1 == n.data.vipStatus ? d.data.vip_price : d.data.pin_price), a(g, "param.money", 1 == n.data.vipStatus ? d.data.vip_price : d.data.pin_price), a(g, "param.coupon_moneys", y), g))
            }
            n.timer = setInterval(function() {
                --m.time, m.time <= 0 && (r = (new Date).getTime() / 1e3) < s && (m = t(r, s, p, _)), n.setData({
                    countDown: m
                })
            }, 1e3)
        }).
        catch (function(a) {
            "商品不存在" == a.msg ? e.alert("商品不存在！", function() {
                n.data.newPage ? e.lunchTo("/pages/home/home") : wx.navigateBack({
                    delta: 1
                })
            }, 0) : e.tips(a.msg)
        })
    },
    onGroupSelectTab: function(t) {
        var i, o = 0;
        o = t - 0 >= 0 ? t : t.currentTarget.dataset.index;
        var e = this.data.info.ladder_info;
        for (var n in e) e[n].choose = n == o;
        var d = 0;
        if (1 == this.data.info.is_group_coupon && (this.data.info.coupon_money > 0 && (d = this.data.info.coupon_money), this.data.info.coupon_discount > 0)) {
            var r = (this.data.info.coupon_discount - 0) / 10;
            d = (this.data.info.ladder_info[o].groupmoney - r * this.data.info.ladder_info[o].groupmoney).toFixed(2)
        }
        this.setData((i = {}, a(i, "info.ladder_info", e), a(i, "param.ladder_id", this.data.info.ladder_info[o].id), a(i, "param.groupnum", this.data.info.ladder_info[o].groupnum), a(i, "param.groupmoney", 1 == this.data.vipStatus ? this.data.info.ladder_info[o].vip_groupmoney : this.data.info.ladder_info[o].groupmoney), a(i, "param.money", 1 == this.data.vipStatus ? this.data.info.ladder_info[o].vip_groupmoney : this.data.info.ladder_info[o].groupmoney), a(i, "param.coupon_moneys", d), a(i, "info.choose_type.pin_price", this.data.info.ladder_info[o].groupmoney), a(i, "info.choose_type.vip_price", this.data.info.ladder_info[o].vip_groupmoney), a(i, "info.reduce_mopney", "拼团立省： ￥" + (this.data.info.original_price - this.data.info.ladder_info[o].groupmoney).toFixed(2)), i))
    },
    onSelectTab: function(t) {
        var o = this;
        if (!this.data.ajax) {
            this.setData({
                ajax: !0
            });
            var n = t.currentTarget.dataset.index,
                d = t.currentTarget.dataset.idx,
                r = this.data.info.attr_group_list;
            for (var s in r[n].attr_list) r[n].attr_list[s].choose = s == d;
            var p = ",",
                _ = ",",
                m = "";
            for (var u in r) for (var c in r[u].attr_list) r[u].attr_list[c].choose && (p += r[u].attr_list[c].id + ",", _ += r[u].attr_list[c].name + ",", m += r[u].attr_list[c].name + " ");
            var h = {
                goods_id: this.data.param_sid,
                attr_ids: p
            };
            e.api.apiPinGetAttrInfo(h).then(function(t) {
                var e, n = 0;
                if (1 == o.data.info.is_group_coupon && (o.data.info.coupon_money > 0 && (n = o.data.info.coupon_money), o.data.info.coupon_discount > 0)) {
                    var d = (o.data.info.coupon_discount - 0) / 10;
                    n = (t.data.pin_price - d * (t.data.pin_price - 0)).toFixed(2)
                }
                var s = i(t.data.stock - 0, o.data.info.limit_num - 0, o.data.info.limit_times - 0, o.data.info.my_buy_num - 0);
                o.setData((e = {}, a(e, "info.attr_group_list", r), a(e, "info.choose_name", m), a(e, "param.num", s.min), a(e, "maxMin", s), a(e, "ajax", !1), a(e, "info.choose_type", t.data), a(e, "info.reduce_mopney", "拼团立省： ￥" + (o.data.info.original_price - t.data.pin_price).toFixed(2)), a(e, "param.attr_list", _), a(e, "param.attr_ids", p), a(e, "param.groupmoney", 1 == o.data.vipStatus ? t.data.vip_price : t.data.pin_price), a(e, "param.money", 1 == o.data.vipStatus ? t.data.vip_price : t.data.pin_price), a(e, "param.coupon_moneys", n), e))
            }).
            catch (function(a) {
                o.setData({
                    ajax: !1
                }), a.code, e.tips(a.msg)
            })
        }
    },
    getNum: function(t) {
        t.detail == this.data.maxMin.max && e.tips(this.data.maxMin.tipsNum), this.setData(a({}, "param.num", t.detail))
    },
    onRickTap: function() {
        e.navTo("/base/rich/rich?id=2")
    },
    toggleMask: function(t) {
        if (this.data.maxMin.preventA) e.tips(preventTxtA);
        else {
            var i = t.currentTarget.dataset.key;
            if (i >= 0) {
                var o;
                this.setData((o = {}, a(o, "param.ordertype", i), a(o, "mask", !this.data.mask), o))
            } else this.setData({
                mask: !1
            })
        }
    },
    formSubmit: function(t) {
        var i = t.detail.formId;
        if (this.setData(a({}, "param.prepay_id", i)), !(this.data.param.num < 1)) {
            var o = this.data.param;
            o.is_ladder = this.data.info.is_ladder, o.use_attr = this.data.info.use_attr, o.store_pic = this.data.imgRoot + this.data.info.store_info.logo, o.store_name = this.data.info.store_info.name, o.store_address = this.data.info.store_info.address, o.store_tel = this.data.info.store_info.tel, o.store_lat = this.data.info.store_info.lat, o.store_lng = this.data.info.store_info.lng, o.goods_name = this.data.info.name, o.goods_pic = this.data.info.choose_type.pic, o.goods_mpic = this.data.info.pic, o.goods_root = this.data.imgRoot, o.all_sendtype = this.data.info.sendtype, o.distribution = this.data.info.postagerules_id, 1 == this.data.info.is_group_coupon && this.data.info.coupon_discount > 0 && (o.coupon_moneys = (o.coupon_moneys * o.num).toFixed(2)), o.coupon_money = o.coupon_moneys, 2 == o.ordertype && (o.groupmoney = 1 == this.data.vipStatus ? this.data.info.choose_type.alonepay_vip_price : this.data.info.choose_type.price, o.money = 1 == this.data.vipStatus ? this.data.info.choose_type.alonepay_vip_price : this.data.info.choose_type.price), o.postagerules_id = this.data.info.postagerules_id, o.weight = this.data.info.choose_type.weight, o.store_id = this.data.info.store_id, o.heads_id = this.data.param_hid, o = JSON.stringify(o), clearInterval(this.timer), e.navTo("/plugin/spell/order/order?id=" + o)
        }
    },
    onOpenReloadTab: function() {
        var a = this.data.param_sid + "-0";
        e.reTo("/plugin/spell/info/info?id=" + a)
    },
    onHomeTab: function() {
        e.lunchTo("/cysc_sun/pages/home/index/index")
    },
    onNavTab: function(a) {
        this.setData({
            choose: a.currentTarget.dataset.id
        })
    },
    onCommentPicTap: function(a) {
        for (var t = a.currentTarget.dataset.index, i = a.currentTarget.dataset.idx, o = this.data.list.data[t].imgs, e = [], n = 0; n < o.length; n++) e[n] = this.data.imgRoot + o[n];
        wx.previewImage({
            urls: e,
            current: e[i]
        })
    },
    onNavTap: function(a) {
        var t = a.currentTarget.dataset.idx;
        this.setData({
            navChoose: t
        })
    },
    loadListData: function() {
        var t = this;
        if (!this.data.list.over) {
            this.setData(a({}, "list.load", !0));
            var i = {
                goods_id: this.data.param_sid,
                type: 4,
                page: this.data.list.page,
                length: this.data.list.length
            };
            e.api.apiCommentBaseCommentList(i).then(function(a) {
                t.dealList(a.data, t.data.list.page)
            }).
            catch (function(a) {
                e.tips(a.msg)
            })
        }
    },
    onReachBottom: function() {
        1 == this.data.navChoose && this.loadListData()
    },
    onTelTap: function() {
        e.phone(this.data.info.store_info.tel)
    },
    toggleShare: function() {
        this.setData({
            share: !this.data.share
        })
    },
    onPosterTab: function() {
        var a = this;
        if (this.data.info.pic && "" != this.data.info.pic) if (this.setData({
            share: !1
        }), wx.showLoading({
            title: "海报生成中..."
        }), this.data.posterUrl) wx.hideLoading(), wx.previewImage({
            current: this.data.posterUrl,
            urls: [this.data.posterUrl]
        });
        else {
            var t = {
                link: "plugin/spell/info/info?id=" + (this.data.param_sid + "-" + this.data.param_hid + "-" + this.data.user.id),
                width: 120
            };
            e.api.apiGetQRCode(t).then(function(t) {
                console.log(t), wx.showLoading({
                    title: "海报生成中..."
                });
                var i = {
                    delRoot: t.data.path,
                    bg: a.data.support.config.poster_goods ? a.data.imgRoot + a.data.support.config.poster_goods : "",
                    img: t.other.img_root + a.data.info.pic,
                    avatar: a.data.user.avatar,
                    qr: t.other.img_root + t.data.path,
                    title: a.data.info.name,
                    price: "抢购价￥" + a.data.info.pin_price,
                    name: a.data.user.nickname,
                    hot: a.data.info.group_num_virtual - 0 + (a.data.info.group_num - 0) + "团已成",
                    is_pic: a.data.info.posterpic ? t.other.img_root + a.data.info.posterpic : null,
                    recommend: "特别值得推荐的拼团"
                };
                a.setData({
                    posterinfo: i,
                    loadImgKey: !0
                })
            }).
            catch (function(a) {
                e.tips(a.msg)
            })
        } else e.tips("没有商品封面图！")
    },
    createPoster: function(a) {
        var t = a.detail;
        this.setData({
            posterUrl: t.url
        }), wx.hideLoading(), wx.previewImage({
            current: this.data.posterUrl,
            urls: [this.data.posterUrl]
        })
    },
    onAddressTap: function() {
        e.map(this.data.info.store_info.lat, this.data.info.store_info.lng)
    },
    onMemberTap: function() {
        e.navTo("/pages/member/member")
    },
    onShareAppMessage: function() {
        var a = this,
            t = a.data.param_sid + "-" + a.data.param_hid + "-" + a.data.user.id;
        return {
            title: "一起来拼团（" + this.data.info.name + ")",
            path: "/plugin/spell/info/info?id=" + t
        }
    }
});