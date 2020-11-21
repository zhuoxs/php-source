function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var app = getApp(), s = require("../../../../../zhy/template/wxParse/wxParse.js"), foot = require("../../../../../zhy/component/comFooter/dealfoot.js");

Page({
    data: {
        marker: [],
        isAjaxIng: !1
    },
    loadNav: function() {
        app.ajax({
            url: "Csystem|getNavicon",
            success: function(e) {
                var t = foot.dealFootNav(e.data, e.other.img_root);
                wx.setStorageSync("footNav", t);
            }
        });
    },
    onLoad: function() {
        this.loadData();
    },
    str: function(e) {
        return JSON.stringify(e);
    },
    play_music: function(e, t, a, n) {
        var o = wx.getBackgroundAudioManager();
        o.title = e, o.singer = t, o.coverImgUrl = a, o.src = n;
    },
    to_url: function(e, t) {
        var n = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "", o = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : "", i = 4 < arguments.length && void 0 !== arguments[4] ? arguments[4] : "";
        if (1 == e) t && 0 < t.length && a.jump(t); else if (2 == e) wx.navigateToMiniProgram({
            appId: n,
            path: o,
            extraData: {
                foo: "bar"
            },
            envVersion: "release",
            success: function(e) {
                console.log("打开成功");
            },
            fail: function(e) {
                a.alert("请绑定小程序");
            }
        }); else {
            if (3 != e) return;
            a.jump("/yb_shop/pages/web/index?url=" + escape(o) + "&name=" + i);
        }
    },
    get_form_list: function(n, o, i) {
        app.siteInfo.form;
        var s = {}, r = "提交";
        a.get("index/form", {
            id: o
        }, function(e) {
            var t = e.info.list;
            if (0 == e.code) {
                if (1 == n && (wx.setNavigationBarTitle({
                    title: e.info.title ? decodeURIComponent(e.info.title) : "万能表单"
                }), 0 == t.length)) return void a.alert("表单内容为空");
                t.forEach(function(e) {
                    "picker" == e.module && (s[e.name] = 0), "time_one" == e.module && (s[e.name] = e.default), 
                    "time_two" == e.module && (s[e.name + "_1"] = e.default1, s[e.name + "_2"] = e.default2, 
                    e.default1 && e.default2 ? s[e.name] = e.default1 + "," + e.default2 : s[e.name] = ""), 
                    "pic_arr" == e.module && (s[e.name] = []), "region" == e.module && (s[e.name] = e.default, 
                    s[e.name + "_multi"] = [ 0, 0, 0 ]), "button" == e.module && (r = e.title);
                }), 1 == n && i.setData({
                    show: !0
                }), i.setData({
                    data: s,
                    button_name: r,
                    form: t,
                    form_id: o
                });
            } else a.alert(e.msg);
        }, !0);
    },
    loadData: function() {
        var r = this;
        app.ajax({
            url: "Csystem|homepage",
            success: function(e) {
                wx.setNavigationBarTitle({
                    title: e.data.index_value.nab_name
                });
                var t = e.data.index_value.all_data, i = wx.getSystemInfoSync().windowWidth;
                t.forEach(function(e, t) {
                    var a;
                    r.setData(_defineProperty({}, "markers" + t, [ {
                        title: "地理位置",
                        latitude: 34.62845,
                        longitude: 112.42821,
                        width: 50,
                        height: 50
                    } ])), "advert" == e.type && (e.high = i * e.ly_height / e.ly_width), "banner" == e.type && (e.high = i * e.ly_height / 10), 
                    "position" == e.type && 2 == e.is_display && r.setData((_defineProperty(a = {}, "markers[" + t + "][0].latitude", e.latitude), 
                    _defineProperty(a, "markers[" + t + "][0].longitude", e.longitude), _defineProperty(a, "markers[" + t + "][0].title", e.position_name), 
                    a)), "rich_text" == e.type && (s.wxParse("wxParseData_" + e.time_key, "html", e.content, r, 0), 
                    e.wxParseData = r.data["wxParseData_" + e.time_key].nodes), "edit_piclist" == e.type && (e.arr = r.str(e.list)), 
                    e.type, "comment" == e.type && n.comment(r, e.is_display), "edit_music" == e.type && r.play_music(e.title, e.author, e.imgurl, e.music_url), 
                    "edit_form" == e.type && (r.get_form_list(2, e.param, r), o.id = e.param);
                }), r.setData({
                    info: t
                });
            }
        });
    },
    formSubmit: function(e) {
        console.log(e.detail);
        var t = e.detail.value, a = t.url ? t.url : "";
        t.appid && t.appid, t.path && t.path, t.title && t.title;
        t.path && t.path, t.title && t.title, app.navTo(a);
    },
    GPSMap: function(e) {
        var t = e.currentTarget.dataset.lat - 0, a = e.currentTarget.dataset.lng - 0;
        wx.openLocation({
            latitude: t,
            longitude: a,
            scale: 28
        });
    },
    phone: function(e) {
        var t = e.currentTarget.dataset.phone + "";
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    onCouponsInfoTab: function(e) {
        var t = this, a = wx.getStorageSync("userInfo"), n = e.currentTarget.dataset.id, o = e.currentTarget.dataset.index, i = t.data.coupon;
        a ? app.ajax({
            url: "Ccoupon|receiveCoupon",
            data: {
                user_id: a.id,
                coupon_id: n
            },
            success: function(e) {
                0 == e.code ? wx.showToast({
                    title: "领取成功",
                    icon: "none"
                }) : wx.showToast({
                    title: e.msg,
                    icon: "none"
                }), i[o].status = 2, t.setData({
                    coupon: i
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(e) {
                if (e.confirm) {
                    var t = encodeURIComponent("/sqtg_sun/pages/home/index/index");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + t);
                } else e.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    formBook: function(e) {
        if (this.data.isAjaxIng) app.tips("请勿重复频繁提交，谢谢！"); else {
            this.data.isAjaxIng = !0;
            var t = this, a = e.detail.value;
            if ("" != a.content.trim()) if ("" != a.name.trim()) if (a.tel.length < 11) app.tips("请输入正确的手机号码！"); else {
                var n = wx.getStorageSync("userInfo");
                n ? (a.user_id = n.id, app.ajax({
                    url: "Csuggest|addSuggest",
                    data: a,
                    success: function(e) {
                        app.tips("成功提交建议，感谢您的反馈！"), setTimeout(function() {
                            console.log(123), t.data.isAjaxIng = !1;
                        }, 3e4);
                    },
                    fail: function(e) {
                        console.log(456), t.data.isAjaxIng = !1, app.tips(e.errMsg);
                    }
                })) : wx.showModal({
                    title: "提示",
                    content: "您未登陆，请先登陆！",
                    success: function(e) {
                        if (e.confirm) {
                            var t = encodeURIComponent("/sqtg_sun/pages/home/index/index");
                            app.reTo("/sqtg_sun/pages/home/login/login?id=" + t);
                        } else e.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
                    }
                });
            } else app.tips("请输入姓名！"); else app.tips("请输入意见或建议！");
        }
    },
    onShareAppMessage: function(e) {}
});