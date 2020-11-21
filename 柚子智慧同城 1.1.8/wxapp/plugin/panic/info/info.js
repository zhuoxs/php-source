/*www.lanrenzhijia.com   time:2019-06-01 22:11:49*/
function t(t, a, i) {
    return a in t ? Object.defineProperty(t, a, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = i, t
}
var a = getApp(),
    i = require("../../../zhy/template/wxParse/wxParse.js");
a.Base({
    data: {
        mask: !1,
        share: !1,
        countDown: {
            preventA: !0,
            preventB: !0,
            btnTxtA: "未开始",
            btnTxtB: "未开始",
            flag: 0,
            min: 1,
            max: 2,
            status: 0,
            time: 0,
            timeTxt: "距离开始"
        },
        param: {
            num: 1
        },
        navChoose: 0,
        ladderChoose: 0,
        numType: 0
    },
    onLoad: function(t) {
        this.setData({
            id: t.id,
            reload: !0
        }), this.loadListData(), this.checkDistribution(t)
    },
    getSetting: function(t) {
        this.setData({
            support: t.detail
        })
    },
    onUnload: function() {
        clearInterval(this.timer)
    },
    onShow: function() {
        var t = this;
        this.data.reload && (this.setData({
            reload: !1
        }), this.checkLogin(function(a) {
            t.setData({
                user: a
            });
            var i = (new Date).getTime() / 1e3,
                e = 0;
            e = a.vip_endtime && i <= a.vip_endtime ? 1 : a.vip_endtime && i > a.vip_endtime ? 2 : 0, t.setData({
                vipStatus: e
            }), t.onLoadData()
        }, "/plugin/panic/info/info?id=" + this.data.id, !0))
    },
    onLoadData: function() {
        var e = this;
        a.api.apiPanicPanicDetail({
            pid: this.data.id,
            user_id: this.data.user.id
        }).then(function(n) {
            if (i.wxParse("content", "html", n.data.details, e, 20), (new Date).getTime() / 1e3 - 0 >= n.data.start_time - 0 && e.setData({
                numType: 1
            }), n.data.ladder_list) {
                var s = n.data.sales_num_virtual - 0,
                    o = n.data.sales_num - 0,
                    r = o;
                1 == e.data.numType && (r = o + s);
                for (var d in n.data.ladder_list) {
                    var p = 0;
                    d > 0 && (p = n.data.ladder_list[d - 1].panic_num);
                    var m = n.data.ladder_list[d].panic_num,
                        h = m - p,
                        c = 0;
                    r >= m ? c = m : r < m && r > p && (c = r - p);
                    var l = 1;
                    c < h && (l = (c / h).toFixed(2)), l *= 100, n.data.ladder_list[d].percent = l
                }
            }
            e.setData({
                info: n.data,
                imgRoot: n.other.img_root,
                show: !0
            });
            var f = e.data.info.attr_group_list;
            if (f) {
                var u, _ = ",";
                for (var g in f) f[g].attr_list[0].checked = !0, _ += f[g].attr_list[0].id + ",";
                e.setData((u = {}, t(u, "info.attr_group_list", f), t(u, "param.attr_ids", _), u))
            }
            e.getAttrInfo(), e.data.info.oldoid > 0 && a.alert("您有未支付订单，是否继续支付？", function() {
                a.navTo("/plugin/panic/panicorderinfo/panicorderinfo?page=0&oid=" + e.data.info.oldoid)
            })
        }).
        catch (function(t) {
            "商品不存在" == t.msg ? a.alert("商品不存在！", function() {
                e.data.newPage ? a.lunchTo("/pages/home/home") : wx.navigateBack({
                    delta: 1
                })
            }, 0) : a.tips(t.msg)
        })
    },
    getAttrInfo: function() {
        var i = this,
            e = this.data.info;
        if (0 == e.use_attr) {
            var n = e.is_ladder - 0,
                s = {
                    id: e.id,
                    uniacid: "",
                    key: "",
                    attr_ids: "",
                    goods_id: e.id,
                    stock: e.stock,
                    vip_price: e.vip_price,
                    weight: e.weight,
                    code: "",
                    pic: e.pic,
                    create_time: e.create_time,
                    update_time: e.update_time,
                    panic_price: e.panic_price
                };
            if (1 == n) {
                var o = e.sales_num;
                1 == this.data.numType && (o = e.sales_num + e.sales_num_virtual);
                for (var r in e.ladder_list) if (o < e.ladder_list[r].panic_num) {
                    s.vip_price = e.ladder_list[r].vip_price, s.panic_price = e.ladder_list[r].panic_price, s.stock = e.ladder_list[r].panic_num - o;
                    break
                }
            }
            this.setData(t({
                chooseInfo: s
            }, "param.attr_ids", "")), this.dealTime()
        } else a.api.apiPanicPanicGetAttrInfo({
            pid: this.data.id,
            attr_ids: this.data.param.attr_ids
        }).then(function(a) {
            i.setData({
                chooseInfo: a.data
            }), a.data.stock <= 0 ? i.setData(t({}, "param.num", 0)) : i.setData(t({}, "param.num", 1)), i.dealTime()
        }).
        catch (function(t) {
            i.data.ajax = !1, a.tips(t.msg)
        })
    },
    dealTime: function() {
        var a = this;
        clearInterval(this.timer);
        var i = (new Date).getTime() / 1e3 - 0,
            e = this.data.info.start_time - 0,
            n = this.data.info.end_time - 0,
            s = this.data.info.expire_time - 0,
            o = this.data.chooseInfo.stock - 0,
            r = this.data.chooseInfo.panic_price - 0,
            d = this.data.chooseInfo.vip_price - 0,
            p = this.data.info.only_vip - 0,
            m = this.data.info.vip_free - 0,
            h = this.data.info.free_num - 0,
            c = this.data.info.limit_num - 0,
            l = this.data.info.is_ladder - 0,
            f = this.data.info.use_attr - 0,
            u = this.data.info.oldoid - 0,
            _ = this.data.vipStatus - 0,
            g = this.data.info.mybuytimes ? this.data.info.mybuytimes - 0 : 0,
            v = this.data.info.myfreetimes ? this.data.info.myfreetimes - 0 : 0,
            x = this.delCountDown(i, e, n, s, o, r, d, p, m, h, c, l, f, u, _, g, v);
        this.setData({
            countDown: x
        }), x.max < 1 ? this.setData(t({}, "param.num", 0)) : this.setData(t({}, "param.num", 1)), this.timer = setInterval(function() {
            --x.time, x.time <= 0 && (o = a.data.chooseInfo.stock, r = a.data.chooseInfo.panic_price, d = a.data.chooseInfo.vip_price, i = (new Date).getTime() / 1e3, x = a.delCountDown(i, e, n, s, o, r, d, p, m, h, c, l, f, u, _, g, v)), a.setData({
                countDown: x
            }), x.max < 1 ? a.setData(t({}, "param.num", 0)) : x.max > 0 && 0 == a.data.param.num && a.setData(t({}, "param.num", 1))
        }, 1e3), this.data.ajax = !1
    },
    delCountDown: function(a, i, e, n, s, o, r, d, p, m, h, c, l, f, u, _, g) {
        var v = {
            preventA: !1,
            preventB: !1,
            btnTxtA: "",
            btnTxtB: "",
            flag: 0,
            min: 1,
            max: 2,
            status: 0,
            time: 0,
            timeTxt: "距离开始"
        };
        if (a < i) v = {
            preventA: !0,
            preventB: !0,
            btnTxtA: "即将开始",
            btnTxtB: "即将开始",
            flag: 0,
            min: 0,
            max: 0,
            status: 0,
            time: i - a,
            timeTxt: "距离开始"
        };
        else if (a >= i && a < e) if (1 == d && 1 != u) console.log("3限会员购买且不是会员"), v = {
            preventA: !0,
            preventB: !0,
            btnTxtA: "限会员购买,去开通",
            btnTxtB: "限会员购买,去开通",
            flag: 3,
            min: 0,
            max: 0,
            status: 1,
            time: e - a,
            timeTxt: "距离结束"
        };
        else if (s <= 0) console.log("4没有库存"), v = {
            preventA: !1,
            preventB: !0,
            btnTxtA: "立即购买",
            btnTxtB: "已售完",
            flag: 4,
            min: 0,
            max: 0,
            status: 1,
            time: e - a,
            timeTxt: "距离结束"
        };
        else if (h > 0 && _ >= h) console.log("10超出购买限制次数"), v = {
            preventA: !0,
            preventB: !0,
            btnTxtA: "已超限购",
            btnTxtB: "已超限购",
            flag: 10,
            min: 0,
            max: 0,
            status: 1,
            time: e - a,
            timeTxt: "距离结束"
        };
        else if (1 == u && 1 == p && g < m) {
            console.log("5有会员免单 && 还有免单次数");
            var x = m - g,
                T = s,
                D = "已达可购买的最大库存！";
            h > 0 && h <= s && (T = h, D = "已达可购买的最大次数！"), x < T && (T = x, D = "已达可购买的最大免单次数！");
            var b = h - _;
            h > 0 && T > b && (T = b, D = "已达可购买的最大购买次数！"), v = {
                preventA: !1,
                preventB: !1,
                btnTxtA: "免单购买",
                btnTxtB: "免单购买",
                flag: 5,
                min: 1,
                max: T,
                status: 1,
                time: e - a,
                timeTxt: "距离结束",
                tipsTxt: D
            }
        } else {
            var w = s,
                A = "已达可购买的最大库存！";
            h > 0 && h < s && (w = h, A = "已达可购买的最大次数！");
            var k = h - _;
            h > 0 && w > k && (w = k, A = "已达可购买的最大购买次数！"), v = {
                preventA: !1,
                preventB: !1,
                btnTxtA: "立即购买",
                btnTxtB: "立即购买",
                flag: 6,
                min: 1,
                max: w,
                status: 1,
                time: e - a,
                timeTxt: "距离结束",
                tipsTxt: A
            }
        } else a >= e && a < n ? (v = {
            preventA: !0,
            preventB: !0,
            btnTxtA: "已结束",
            btnTxtB: "已结束",
            flag: 1,
            min: 0,
            max: 0,
            status: 2,
            time: n - a,
            timeTxt: "距离过期"
        }, this.setData(t({}, "param.num", 0))) : a >= n ? (v = {
            preventA: !0,
            preventB: !0,
            btnTxtA: "已过期",
            btnTxtB: "已过期",
            flag: 2,
            min: 0,
            max: 0,
            status: 3,
            time: 0,
            timeTxt: "已过期"
        }, this.setData(t({}, "param.num", 0)), clearInterval(this.timer)) : (v = {
            preventA: !0,
            preventB: !0,
            btnTxtA: "未知",
            btnTxtB: "未知",
            flag: -1,
            min: 0,
            max: 0,
            status: -1,
            time: -1,
            timeTxt: "未知"
        }, this.setData(t({}, "param.num", 0)));
        return v
    },
    getAttrIds: function(a) {
        var i;
        if (!this.data.ajax) {
            this.data.ajax = !0;
            var e = a.currentTarget.dataset.index,
                n = a.currentTarget.dataset.idx,
                s = this.data.info.attr_group_list,
                o = ",";
            for (var r in s[e].attr_list) s[e].attr_list[r].checked = r == n;
            for (var d in s) for (var p in s[d].attr_list) s[d].attr_list[p].checked && (o += s[d].attr_list[p].id + ",");
            this.setData((i = {}, t(i, "param.attr_ids", o), t(i, "info.attr_group_list", s), i)), this.getAttrInfo()
        }
    },
    onAddressTap: function() {
        a.map(this.data.info.store_info.lat, this.data.info.store_info.lng)
    },
    onTelTap: function() {
        a.phone(this.data.info.store_info.tel)
    },
    onMemberTap: function() {
        a.navTo("/pages/member/member")
    },
    getNum: function(i) {
        i.detail == this.data.countDown.max && a.tips(this.data.countDown.tipsTxt), this.setData(t({}, "param.num", i.detail))
    },
    toggleMask: function() {
        var t = this;
        1 != this.data.info.only_vip || 1 == this.data.vipStatus ? (3 == this.data.countDown.flag && a.navTo("/plugin/panic/panicorderinfo/panicorderinfo?oid=" + this.data.info.oldoid), this.data.countDown.preventA || this.setData({
            mask: !this.data.mask
        })) : a.alert("对不起，本商品需会员才能购买", function() {
            t.onMemberTap()
        })
    },
    formSubmit: function(i) {
        var e;
        if (this.data.param.num < 1) a.tips("购买数量至少为1");
        else {
            var n = i.detail.formId,
                s = 1 == this.data.vipStatus ? this.data.chooseInfo.vip_price : this.data.chooseInfo.panic_price,
                o = ((s - 0) * (this.data.param.num - 0)).toFixed(2);
            this.setData((e = {}, t(e, "param.pid", this.data.id), t(e, "param.user_id", this.data.user.id), t(e, "param.order_amount", o), t(e, "param.money", s), t(e, "param.prepay_id", n), t(e, "param.use_attr", this.data.info.use_attr), t(e, "param.attr_list", this.data.chooseInfo.key), e)), this.onOrderCheckTap()
        }
    },
    onOrderCheckTap: function() {
        this.setData({
            mask: !1
        });
        var t = this.data.param;
        t.store_pic = this.data.imgRoot + this.data.info.store_info.logo, t.store_name = this.data.info.store_info.name, t.store_address = this.data.info.store_info.address, t.store_tel = this.data.info.store_info.tel, t.store_lat = this.data.info.store_info.lat, t.store_lng = this.data.info.store_info.lng, t.goods_name = this.data.info.name, t.goods_pic = this.data.chooseInfo.pic, t.goods_mpic = this.data.info.pic, t.goods_root = this.data.imgRoot, t.goods_key = this.data.chooseInfo.key, t.btn_flag = this.data.countDown.flag, t.all_sendtype = this.data.info.sendtype, t.distribution = this.data.info.postagerules_id, t.oldoid = this.data.info.oldoid;
        var i = JSON.stringify(t);
        a.navTo("/plugin/panic/ordercheck/ordercheck?page=0&id=" + i)
    },
    onNavTap: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            navChoose: a
        })
    },
    taggleLadderTap: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            ladderChoose: a
        })
    },
    onPosterTab: function() {
        var t = this;
        if (this.data.info.pic && "" != this.data.info.pic) if (this.setData({
            share: !1
        }), wx.showLoading({
            title: "海报生成中..."
        }), this.data.posterUrl) wx.hideLoading(), wx.previewImage({
            current: this.data.posterUrl,
            urls: [this.data.posterUrl]
        });
        else {
            var i = {
                link: "plugin/panic/info/info?id=" + this.data.id + "&s_id=" + this.data.user.id,
                width: 120
            };
            a.api.apiGetQRCode(i).then(function(a) {
                wx.showLoading({
                    title: "海报生成中..."
                }), t.setData({
                    posterinfo: {
                        delRoot: a.data.path,
                        bg: t.data.support.config.poster_goods ? t.data.imgRoot + t.data.support.config.poster_goods : "",
                        img: a.other.img_root + t.data.info.pic,
                        avatar: t.data.user.avatar,
                        qr: a.other.img_root + a.data.path,
                        title: t.data.info.name,
                        price: "抢购价￥" + t.data.info.vip_price,
                        name: t.data.user.nickname,
                        hot: t.data.info.read_num_virtual - 0 + (t.data.info.read_num - 0) + "人喜欢",
                        is_pic: t.data.info.posterpic ? a.other.img_root + t.data.info.posterpic : null,
                        recommend: "特别推荐"
                    },
                    loadImgKey: !0
                })
            }).
            catch (function(t) {
                a.tips(t.msg)
            })
        } else a.tips("没有商品封面图！")
    },
    createPoster: function(t) {
        var a = t.detail;
        this.setData({
            posterUrl: a.url
        }), wx.hideLoading(), wx.previewImage({
            current: this.data.posterUrl,
            urls: [this.data.posterUrl]
        })
    },
    toggleShare: function() {
        this.setData({
            share: !this.data.share
        })
    },
    loadListData: function() {
        var i = this;
        if (!this.data.list.over) {
            this.setData(t({}, "list.load", !0));
            var e = {
                goods_id: this.data.id,
                type: 2,
                page: this.data.list.page,
                length: this.data.list.length
            };
            a.api.apiCommentBaseCommentList(e).then(function(t) {
                i.dealList(t.data, i.data.list.page)
            }).
            catch (function(t) {
                a.tips(t.msg)
            })
        }
    },
    onReachBottom: function() {
        1 == this.data.navChoose && this.loadListData()
    },
    onCommentPicTap: function(t) {
        for (var a = t.currentTarget.dataset.index, i = t.currentTarget.dataset.idx, e = this.data.list.data[a].imgs, n = [], s = 0; s < e.length; s++) n[s] = this.data.imgRoot + e[s];
        wx.previewImage({
            urls: n,
            current: n[i]
        })
    },
    onShareAppMessage: function() {
        return this.setData({
            share: !1
        }), {
            title: "一起来抢购（" + this.data.info.name + ")",
            path: "/plugin/panic/info/info?id=" + this.data.id + "&s_id=" + this.data.user.id
        }
    }
});