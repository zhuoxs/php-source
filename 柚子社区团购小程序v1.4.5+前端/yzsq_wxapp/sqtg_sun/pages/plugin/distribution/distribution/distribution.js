var app = getApp(), foot = require("../../../../../zhy/component/comFooter/dealfoot.js"), WxParse = require("../../../../../zhy/template/wxParse/wxParse.js");

Page({
    data: {
        is_modal_Hidden: !0,
        user_info: !1,
        distribution_set: [],
        img: "../../resource/images/sharecheck.png",
        agree: 0
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("userInfo");
        this.setData({
            show: !0,
            user_id: e.id
        });
    },
    onShow: function() {
        this.getApplySetting();
    },
    getApplySetting: function() {
        var i = this, t = i.data.user_id;
        app.ajax({
            url: "Cdistribution|getApplySetting",
            data: {
                user_id: t
            },
            success: function(t) {
                if (t.data && t.data.distribution && 2 == t.data.distribution.check_state && wx.redirectTo({
                    url: "../distributioncenter/distributioncenter"
                }), 1 == i.data.agree) return !1;
                var e = t.data.distribution_apply_agreement;
                WxParse.wxParse("detail", "html", e, i, 0), console.log(t.data.swipers.length);
                var a = foot.dealFootNav(t.data.swipers, t.other.img_root);
                i.setData({
                    show: !0,
                    banner: a,
                    getset: t.data,
                    eVal: t.data.distribution,
                    check_state: t.data.distribution && t.data.distribution.check_state ? t.data.distribution.check_state : 0
                });
            }
        });
    },
    formSubmit: function(t) {
        var e = this, a = wx.getStorageSync("userInfo"), i = (wx.getStorageSync("share_user_id"), 
        t.detail.value), s = e.data.getset;
        null != i.name && "" != i.name ? null != i.mobile && "" != i.mobile ? 1 != s.distribution_apply_show || 0 != e.data.agree ? (wx.showLoading({
            title: "正在提交",
            mask: !0
        }), app.ajax({
            url: "Cdistribution|applyDistribution",
            data: {
                name: i.name,
                tel: i.mobile,
                parent_id: s.parent_id,
                user_id: a.id,
                id: s.distribution && s.distribution.id ? s.distribution.id : 0
            },
            success: function(t) {
                e.setData({
                    check_state: t.data.check_state,
                    eVal: i
                }), setTimeout(function() {
                    app.tips("申请成功");
                }, 300), wx.navigateBack({});
            }
        })) : app.tips("请先阅读并确认分销申请协议！！") : app.tips("请填写联系方式！") : app.tips("请填写姓名！");
    },
    agree: function() {
        var t = this, e = t.data.agree;
        0 == e ? (e = 1, t.setData({
            img: "../../resource/images/shareagree.png",
            agree: e,
            popWin: !1
        })) : 1 == e && (e = 0, t.setData({
            img: "../../resource/images/sharecheck.png",
            agree: e
        }));
    },
    _onNavTab1: function(t) {
        var e = getCurrentPages(), a = "/" + e[e.length - 1].route, i = t.currentTarget.dataset.index, s = this.data.banner[i].link, n = this.data.banner[i].typeid;
        s != a && "" != s && app.navTo(s + "?id=" + n);
    },
    toIndex: function() {
        app.lunchTo("/sqtg_sun/pages/home/index/index");
    },
    agreement: function() {
        this.setData({
            popWin: !0
        });
    }
});