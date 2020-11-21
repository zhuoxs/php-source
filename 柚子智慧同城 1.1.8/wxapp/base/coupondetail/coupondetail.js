/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var t = getApp();
t.Base({
    data: {
        share: !1,
        flag: 0
    },
    onLoad: function(t) {
        var a = this,
            e = wx.getStorageSync("setting");
        if (e) {
            var o = e.config.coupon_list_bottom_color ? e.config.coupon_details_bottom_color : 0;
            this.setData({
                coupon_bg: o
            })
        }
        this.checkLogin(function(e) {
            a.setData({
                user_id: e.id,
                user: e,
                id: t.id,
                h_uid: t.h_uid ? t.h_uid : 0
            }), a.onLoadData(e)
        }, "/base/coupondetail/coupondetail?id=" + t.id + "&h_uid=" + t.h_uid)
    },
    onLoadData: function(a) {
        var e = this,
            o = {
                id: e.data.id,
                user_id: e.data.user_id
            };
        t.api.apIcouponCouponDetails(o).then(function(a) {
            if (2 == a.data.gettype && e.data.h_uid > 0) {
                if (1e3 * a.data.end_time < (new Date).getTime()) return void t.alert("去首页逛逛", function() {
                    t.lunchTo("/pages/home/home")
                }, 0, "此优惠券已过期");
                if (a.data.num <= 0) return void t.alert("此优惠券库存为零", function() {
                    t.reTo("/base/coupons/coupons")
                }, 0, "查看更多优惠券");
                var o = e.data.user,
                    i = (new Date).getTime() / 1e3;
                if (1 != (o.vip_endtime && i <= o.vip_endtime ? 1 : o.vip_endtime && i > o.vip_endtime ? 2 : 0) && 1 == a.data.only_vip) return void wx.showModal({
                    title: "此优惠券仅会员可购买",
                    content: "是否成为会员",
                    cancelText: "去首页",
                    confirmText: "成为会员",
                    success: function(a) {
                        a.confirm ? t.lunchTo("/pages/member/member") : a.cancel && t.lunchTo("/pages/home/home")
                    }
                });
                var n = {
                    user_id: e.data.h_uid,
                    cid: a.data.id,
                    help_uid: e.data.user_id
                };
                t.api.apIcouponGetCoupon(n).then(function(a) {
                    t.tips("已帮好友领取优惠券")
                }).
                catch (function(a) {
                    e.setData({
                        ajax: !1
                    }), a.code, t.tips(a.msg)
                })
            }
            e.setData({
                detail: a.data,
                show: !0,
                img_root: a.other.img_root
            })
        }).
        catch (function(a) {
            t.alert("此优惠券当前不可用", function() {
                t.lunchTo("/pages/home/home")
            }, 0, "去首页逛逛")
        })
    },
    someJudge: function() {
        var a = this,
            e = this.data.detail;
        if (1e3 * e.end_time < (new Date).getTime()) t.alert("去首页逛逛", function() {
            t.lunchTo("/pages/home/home")
        }, 0, "此优惠券已过期");
        else if (e.num <= 0) t.alert("此优惠券库存为零", function() {
            t.reTo("/base/coupons/coupons")
        }, 0, "查看更多优惠券");
        else if (0 != e.limit_num && e.count + 1 > e.limit_num) t.alert("去首页逛逛", function() {
            t.lunchTo("/pages/home/home")
        }, 0, "您已购此优惠券达限购总量！");
        else {
            var o = a.data.user,
                i = (new Date).getTime() / 1e3;
            if (1 == (o.vip_endtime && i <= o.vip_endtime ? 1 : o.vip_endtime && i > o.vip_endtime ? 2 : 0) || 1 != e.only_vip) return 1;
            wx.showModal({
                title: "此优惠券仅会员可购买",
                content: "是否成为会员",
                cancelText: "去首页",
                confirmText: "成为会员",
                success: function(a) {
                    a.confirm ? t.lunchTo("/pages/member/member") : a.cancel && t.lunchTo("/pages/home/home")
                }
            })
        }
    },
    onGetcouponTap: function() {
        var a = this;
        if (1 === this.someJudge()) {
            var e = a.data.detail.gettype,
                o = {
                    user_id: a.data.user_id,
                    cid: a.data.detail.id,
                    help_uid: a.data.h_uid
                };
            a.data.ajax || (a.setData({
                ajax: !0
            }), t.api.apIcouponGetCoupon(o).then(function(o) {
                a.setData({
                    ajax: !1
                }), 1 == e ? o.data && wx.requestPayment({
                    appId: o.data.appId,
                    nonceStr: o.data.nonceStr,
                    package: o.data.package,
                    paySign: o.data.paySign,
                    prepay_id: o.data.prepay_id,
                    signType: o.data.signType,
                    timeStamp: o.data.timeStamp,
                    success: function(e) {
                        t.alert("查看我的优惠券", function() {
                            t.reTo("/base/mycoupons/mycoupons")
                        }, 0, "购买优惠券成功"), a.onLoadData()
                    },
                    fail: function(t) {
                        console.log(t)
                    }
                }) : 3 == e && t.alert("查看我的优惠券", function() {
                    t.reTo("/base/mycoupons/mycoupons")
                }, 0, "优惠券领取成功")
            }).
            catch (function(e) {
                a.setData({
                    ajax: !1
                }), e.code, t.tips(e.msg)
            }))
        }
    },
    onTelTap: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.detail.storeinfo.tel
        })
    },
    onShareAppMessage: function() {
        var t = this;
        return this.setData({
            share: !1
        }), {
            title: t.data.detail.name,
            path: "/base/coupondetail/coupondetail?id=" + t.data.id + "&h_uid=" + t.data.user_id
        }
    },
    onTohomeTap: function() {
        t.lunchTo("/pages/home/home")
    },
    onTocouponlistTap: function() {
        t.reTo("/base/coupons/coupons")
    },
    onPosterTab: function() {
        var a = this;
        if (this.data.detail.pic && "" != this.data.detail.pic) if (this.setData({
            share: !1
        }), wx.showLoading({
            title: "海报生成中..."
        }), this.data.posterUrl) wx.hideLoading(), wx.previewImage({
            current: this.data.posterUrl,
            urls: [this.data.posterUrl]
        });
        else {
            var e = {
                link: "base/coupondetail/coupondetail?id=" + this.data.id + "&h_uid=" + this.data.user_id,
                width: 120
            };
            t.api.apiGetQRCode(e).then(function(t) {
                wx.showLoading({
                    title: "海报生成中..."
                }), a.setData({
                    posterinfo: {
                        delRoot: t.data.path,
                        bg: a.data.support.config.poster_goods ? t.other.img_root + a.data.support.config.poster_goods : "",
                        img: t.other.img_root + a.data.detail.pic,
                        avatar: a.data.user.avatar,
                        qr: t.other.img_root + t.data.path,
                        title: a.data.detail.name,
                        price: "立即拥有",
                        name: a.data.user.nickname,
                        hot: a.data.detail.popularity > 0 ? "人气：" + a.data.detail.read_num_virtual : "",
                        is_pic: a.data.detail.posterpic ? t.other.img_root + a.data.detail.posterpic : null,
                        recommend: "特别推荐的优惠券"
                    },
                    loadImgKey: !0
                }), console.log(a.data.posterinfo)
            }).
            catch (function(a) {
                t.tips(a.msg)
            })
        } else t.tips("没有商品封面图,无法生成海报！")
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
    onHomeTap: function() {
        t.lunchTo("/pages/home/home")
    },
    getSetting: function(t) {
        this.setData({
            support: t.detail
        })
    }
});