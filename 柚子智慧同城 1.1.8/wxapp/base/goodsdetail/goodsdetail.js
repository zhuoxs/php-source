/*www.lanrenzhijia.com   time:2019-06-01 22:11:53*/
var t = getApp(),
    a = require("../../zhy/template/wxParse/wxParse.js");
t.Base({
    data: {
        cur: 0,
        num: 1,
        page: 1,
        length: 10,
        olist: []
    },
    onLoad: function(t) {
        this.setData({
            id: t.id
        })
    },
    onShow: function() {
        var t = this;
        this.checkLogin(function(a) {
            t.setData({
                user: a,
                user_id: a.id
            }), t.onLoadData()
        }, "/base/goodsdetail/goodsdetail?id=" + this.data.id)
    },
    getSetting: function(t) {
        this.setData({
            support: t.detail
        })
    },
    onLoadData: function() {
        var e = this,
            i = e.data.olist,
            o = e.data.page,
            s = e.data.length;
        Promise.all([t.api.apiStoreGetBanner({
            type: 5
        }), t.api.apiGoodsGetGoodsDetail({
            gid: e.data.id,
            user_id: e.data.user_id
        }), t.api.apiCommentBaseCommentList({
            goods_id: e.data.id,
            page: o,
            length: s,
            type: 1
        })]).then(function(t) {
            var n = t[1].data,
                r = 0;
            n.only_num > 0 && n.limit_num > 0 && 1 == n.is_vip ? (n.only_num > n.limit_num ? (r = n.limit_num - n.ygfree_num) > 0 ? e.setData({
                memberfree: 1
            }) : (r = 0, e.setData({
                memberfree: 0
            })) : n.only_num < n.limit_num && ((r = n.only_num - n.ygfree_num) > 0 ? e.setData({
                memberfree: 1
            }) : (r = 0, e.setData({
                memberfree: 0
            }))), e.setData({
                goods: n,
                residue_num: r
            })) : n.only_num > 0 && 0 == n.limit_num && 1 == n.is_vip && ((r = n.only_num - n.ygfree_num) > 0 ? e.setData({
                memberfree: 1
            }) : (r = 0, e.setData({
                memberfree: 0
            })), e.setData({
                goods: n,
                residue_num: r
            }));
            t[2].data.length;
            if (t[2].data.length < s && e.setData({
                hasMore: !1,
                show: !0,
                nomore: !0
            }), 1 == o) i = t[2].data;
            else for (var d in t[2].data) i.push(t[2].data[d]);
            var u = t[1].data.details;
            a.wxParse("detail", "html", u, e, 20), e.setData({
                info: t[1].data,
                imgRoot: t[1].other.img_root,
                banner: {
                    list: t[0].data,
                    root: t[0].other.img_root
                },
                olist: i,
                show: !0
            })
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    onTelTap: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.info.store.tel
        })
    },
    onTabTap: function(t) {
        var a = this,
            e = t.currentTarget.dataset.index;
        a.setData({
            cur: e
        })
    },
    toMemberTap: function() {
        t.navTo("/pages/member/member")
    },
    buyOrSpec: function() {
        this.setData({
            showModalStatus: !0
        })
    },
    spTap: function(a) {
        var e = this,
            i = a.currentTarget.dataset.idx,
            o = a.currentTarget.dataset.index,
            s = e.data.info,
            n = s.attr_group_list,
            r = 0,
            d = ",",
            u = "";
        if (n[o].status = !0, n[o].attr_list.forEach(function(t, a) {
            t.status = !1
        }), n[o].attr_list[i].status = !0, s.attr_group_list.forEach(function(t, a) {
            1 == t.status && r++
        }), n.forEach(function(t, a) {
            t.attr_list.forEach(function(t, a) {
                1 == t.status && (d += t.id + ",")
            })
        }), n.length == r) {
            var m = {
                gid: e.data.id,
                attr_ids: d
            };
            t.api.apiGoodsGetGoodsAttrInfo(m).then(function(t) {
                u = t.data.key, u = u.replace(/^,+|,+$/g, ""), e.setData({
                    attrChoiced: t.data,
                    choiceName: u
                })
            }).
            catch (function(a) {
                t.tips(a.msg)
            })
        }
        e.setData({
            info: s
        })
    },
    addNum: function() {
        var a = this.data.num,
            e = this.data.info,
            i = this.data.attrChoiced;
        if (e.attr_group_list) {
            if (e.attr_group_list.length > 0 && !i) return t.tips("请先选择规格！"), void this.setData({
                num: a
            });
            if (a + 1 > i.stock) return t.tips("达可购买量上限！"), void this.setData({
                num: a
            })
        }
        return a + 1 > e.stock ? (t.tips("达可购买量上限！"), void this.setData({
            num: a
        })) : e.limit_num && a - (e.limit_num - e.yg_num) == 0 ? (t.tips("达可购买量上限！"), void this.setData({
            num: a
        })) : void this.setData({
            num: a + 1
        })
    },
    reduceNum: function() {
        var a = this.data.num;
        if (1 == a) return t.tips("商品数量不能小于一"), void this.setData({
            num: 1
        });
        a -= 1, this.setData({
            num: a
        })
    },
    someJudge: function() {
        var a = this.data.info;
        if (new Date(a.end_time.replace(/-/g, "/")).getTime() < (new Date).getTime()) t.alert("去首页逛逛", function() {
            t.lunchTo("/pages/home/home")
        }, 0, "商品已过期");
        else {
            if (!(a.yg_num + 1 > a.limit_num && 0 != a.limit_num)) return 1;
            t.alert("去首页逛逛", function() {
                t.lunchTo("/pages/home/home")
            }, 0, "您已购此商品达到限购总量！")
        }
    },
    formSubmit: function(a) {
        var e = this;
        if (1 === this.someJudge()) {
            var i = e.data.info,
                o = i.attr_group_list,
                s = 0,
                n = e.data.attrChoiced;
            if (0 == i.use_attr) {
                if (0 == i.stock) return void t.tips("库存不足!");
                var r = {
                    gid: e.data.id,
                    num: e.data.num,
                    attr_ids: 0,
                    user_id: e.data.user_id
                };
                t.api.apGoodscheckGoods(r).then(function(a) {
                    t.navTo("/base/goodsorder/goodsorder?gid=" + e.data.id + "&attr_ids=0&num=" + e.data.num)
                }).
                catch (function(a) {
                    t.tips(a.msg)
                })
            } else if (1 == i.use_attr) {
                if (i.attr_group_list.forEach(function(t, a) {
                    1 == t.status && s++
                }), o.length > s) return void t.tips("请选择好规格再行提交");
                if (0 == n.stock) return void t.tips("库存不足!");
                var d = {
                    gid: e.data.id,
                    num: e.data.num,
                    attr_ids: n.attr_ids,
                    user_id: e.data.user_id
                };
                t.api.apGoodscheckGoods(d).then(function(a) {
                    t.navTo("/base/goodsorder/goodsorder?gid=" + e.data.id + "&attr_ids=" + n.attr_ids + "&num=" + e.data.num)
                }).
                catch (function(a) {
                    t.tips(a.msg)
                })
            }
        }
    },
    close: function() {
        this.setData({
            showModalStatus: !1
        })
    },
    onReachBottom: function() {
        var t = this;
        t.data.hasMore ? t.onLoadData() : t.setData({
            nomore: !0
        })
    },
    onHomeTap: function() {
        t.lunchTo("/pages/home/home")
    },
    onTomemberTap: function() {
        t.navTo("/pages/member/member")
    },
    prewImg: function(t) {
        for (var a = this, e = t.currentTarget.dataset.index, i = t.currentTarget.dataset.idx, o = a.data.olist[e].imgs, s = [], n = 0; n < o.length; n++) s[n] = a.data.imgRoot + o[n];
        wx.previewImage({
            urls: s,
            current: s[i]
        })
    },
    onShareAppMessage: function(t) {
        var a = this;
        return {
            title: a.data.info.name,
            path: "/base/goodsdetail/goodsdetail?id=" + a.data.id + "&s_id=" + a.data.user_id
        }
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
            var e = {
                link: "base/goodsdetail/goodsdetail?id=" + this.data.id + "&s_id=" + this.data.user_id,
                width: 120
            };
            t.api.apiGetQRCode(e).then(function(t) {
                wx.showLoading({
                    title: "海报生成中..."
                }), a.setData({
                    posterinfo: {
                        delRoot: t.data.path,
                        bg: a.data.support.config.poster_goods ? t.other.img_root + a.data.support.config.poster_goods : "",
                        img: t.other.img_root + a.data.info.pics[0],
                        avatar: a.data.user.avatar,
                        qr: t.other.img_root + t.data.path,
                        title: a.data.info.name,
                        price: "￥" + a.data.info.vip_price || a.data.info.price,
                        name: a.data.user.nickname,
                        hot: a.data.info.ck_num - 0 + "人喜欢",
                        recommend: "特别值得推荐的商品",
                        is_pic: a.data.info.posterpic ? t.other.img_root + a.data.info.posterpic : null
                    },
                    loadImgKey: !0
                })
            }).
            catch (function(a) {
                t.tips(a.msg)
            })
        } else t.tips("没有商品封面图！")
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
    onAddressTap: function() {
        t.map(this.data.info.store.lat, this.data.info.store.lng)
    }
});