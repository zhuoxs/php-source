var a = getApp(), t = require("../../zhy/template/wxParse/wxParse.js");

a.Base({
    data: {
        active: 0,
        page: 1,
        length: 10,
        olist: [],
        nav: [ {
            title: "开通会员",
            status: 0
        }, {
            title: "会员码激活",
            status: 1
        }, {
            title: "会员福利",
            status: 2
        } ],
        curHdIndex: 0
    },
    onLoad: function(a) {},
    onShow: function() {
        var a = this;
        this.checkLogin(function(t) {
            a.setData({
                user_id: t.id,
                tel: t.tel
            }), a.onLoadData(t);
        }, "/pages/member/member");
    },
    onLoadData: function(e) {
        var i = this, s = this.data.page, o = this.data.length, n = this.data.olist, d = {
            user_id: this.data.user_id
        };
        Promise.all([ a.api.apiVipVipcard(d), a.api.apiVipWelfareList({
            page: s,
            length: o
        }), a.api.apiUserGetUserPrivilege() ]).then(function(a) {
            var e = a[0].data.member_rule;
            t.wxParse("detail", "html", e, i, 20);
            var d = !(a[1].data.length < o);
            if (a[1].data.length < o && i.setData({
                show: !0,
                nomore: !0
            }), 1 == s) n = a[1].data; else for (var r in a[1].data) n.push(a[1].data[r]);
            s += 1, i.setData({
                hasMore: d,
                page: s,
                member: a[0].data,
                olist: n,
                privilege: a[2].data,
                show: !0,
                img_root: a[0].other.img_root
            });
        }).catch(function(t) {
            t.code, a.tips(t.msg);
        });
    },
    formbuymember: function(t) {
        var e = this, i = e.data.tel || t.detail.value.tel.replace(/\s+/g, "");
        if (/^1(3|4|5|7|8|9)\d{9}$/.test(i)) {
            var s = {
                user_id: e.data.user_id,
                tel: i,
                setid: t.detail.target.dataset.id
            }, o = wx.getStorageSync("s_id");
            o && o > 0 && (s.share_user_id = o), e.data.ajax || (e.setData({
                ajax: !0
            }), a.api.apiVipOpenVip(s).then(function(t) {
                t.data ? wx.requestPayment({
                    appId: t.data.appId,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    paySign: t.data.paySign,
                    prepay_id: t.data.prepay_id,
                    signType: t.data.signType,
                    timeStamp: t.data.timeStamp,
                    success: function(t) {
                        a.alert("去首页逛逛", function() {
                            a.lunchTo("/pages/home/home");
                        }, 0, "购买成功"), e.onLoadData();
                    },
                    fail: function(a) {
                        console.log(a);
                    }
                }) : a.alert("去首页逛逛", function() {
                    a.lunchTo("/pages/home/home");
                }, 0, "免费开卡成功"), e.setData({
                    ajax: !1
                });
            }).catch(function(t) {
                e.setData({
                    ajax: !1
                }), t.code, a.tips(t.msg);
            }));
        } else a.tips("请输入正确的手机号码");
    },
    formactivation: function(t) {
        var e = this, i = e.data.tel || t.detail.value.tel.replace(/\s+/g, ""), s = t.detail.value.code.replace(/\s+/g, "");
        if (/^1(3|4|5|7|8|9)\d{9}$/.test(i)) if ("" != s && void 0 != s) {
            var o = {
                user_id: e.data.user_id,
                tel: i,
                code: s
            };
            e.data.ajax || (e.setData({
                ajax: !0
            }), a.api.apiVipCodeActivation(o).then(function(t) {
                e.onLoadData(), e.setData({
                    ajax: !1
                }), a.alert("去首页逛逛", function() {
                    a.lunchTo("/pages/home/home");
                }, 0, "激活成功");
            }).catch(function(t) {
                t.code, a.tips(t.msg), e.setData({
                    ajax: !1
                });
            }));
        } else a.tips("请输入正确的激活码"); else a.tips("请输入正确的手机号码");
    },
    swichNav: function(a) {
        var t = this, e = a.currentTarget.dataset.status;
        t.setData({
            curHdIndex: e,
            page: 1
        }), this.onLoadData();
    },
    onReachBottom: function() {
        var a = this;
        a.data.hasMore ? 2 == a.data.curHdIndex && a.onLoadData() : this.setData({
            nomore: !0
        });
    },
    onShareAppMessage: function(a) {
        var t = wx.getStorageSync("yztcInfo");
        if (t && t.id) return {
            title: "会员卡",
            path: "/pages/member/member?s_id=" + t.id
        };
    },
    toHomeTap: function() {
        a.lunchTo("/pages/home/home");
    }
});