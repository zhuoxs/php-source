function _defineProperty(a, e, t) {
    return e in a ? Object.defineProperty(a, e, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[e] = t, a;
}

var app = getApp();

Page({
    data: {
        haspage: !1,
        longitude: "",
        latitude: "",
        alter: !1,
        showDeposit: !1,
        showAuit: !1,
        wechat: !0
    },
    radioChange: function(a) {
        this.setData({
            wechat: 1 == a.detail.value
        });
    },
    choAddress: function() {
        var e = this;
        wx.chooseLocation({
            success: function(a) {
                e.setData({
                    longitude: a.longitude,
                    latitude: a.latitude,
                    posAddress: a.address
                });
            },
            fail: function() {},
            complete: function() {}
        });
    },
    toEdit: function() {
        this.setData({
            alter: !0
        });
    },
    toDep: function() {
        this.setData({
            showDeposit: !0
        });
    },
    hideDeposit: function() {
        this.setData({
            showDeposit: !1
        });
    },
    all: function() {
        this.setData({
            money: this.data.list.brokerage
        });
    },
    deposit: function(a) {
        var e = a.detail.value.money;
        if ("" != e) if (parseFloat(e) < 1) app.look.alert("1元起提"); else if (2e4 < parseFloat(e)) app.look.alert("不能超过2w"); else if (parseFloat(e) > parseFloat(this.data.list.brokerage)) app.look.alert("佣金不足"); else {
            var t = this;
            app.util.request({
                url: "entry/wxapp/community",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "depositApply",
                    fee: e,
                    alipay: a.detail.value.alipay,
                    id: t.data.list.id
                },
                success: function(a) {
                    app.look.ok(a.data.message, function() {
                        var a;
                        t.setData((_defineProperty(a = {}, "list.brokerage", (parseFloat(t.data.list.brokerage) - parseFloat(e)).toFixed(2)), 
                        _defineProperty(a, "showDeposit", !1), a));
                    });
                },
                fail: function(a) {
                    app.look.no(a.data.message);
                }
            });
        } else app.look.alert("请输入金额");
    },
    myform: function(a) {
        var t = a.detail.value;
        if ("" != t.title) if ("" != t.name) if (/^[1][3,4,5,7,8][0-9]{9}$/.test(t.phone)) if (t.region.length < 3) app.look.alert("地区必填"); else if ("" != t.detail) {
            var o = this;
            app.util.request({
                url: "entry/wxapp/community",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "clubChangeInfo",
                    title: t.title,
                    name: t.name,
                    phone: t.phone,
                    region: t.region.join(" "),
                    detail: t.detail,
                    longitude: o.data.longitude,
                    latitude: o.data.latitude,
                    id: o.data.list.id
                },
                success: function(a) {
                    var e = o.data.list;
                    e.title = t.title, e.name = t.name, e.phone = t.phone, e.region = t.region.join(" "), 
                    e.detail = t.detail, "" != o.data.longitude && (e.longitude = o.data.longitude), 
                    "" != o.data.latitude && (e.latitude = o.data.latitude), app.look.ok(a.data.message, function() {
                        o.setData({
                            list: e,
                            alter: !1
                        });
                    });
                },
                fail: function(a) {
                    app.look.no(a.data.message);
                }
            });
        } else app.look.alert("地址必填"); else app.look.alert("手机格式不符"); else app.look.alert("姓名必填"); else app.look.alert("社团名称必填");
    },
    scan: function() {
        wx.scanCode({
            onlyFromCamera: !1,
            success: function(a) {
                console.log(a);
                var e = a.result;
                e = e.split("#"), app.util.request({
                    url: "entry/wxapp/community",
                    showLoading: !0,
                    method: "POST",
                    data: {
                        op: "scanHex",
                        hex: e[0],
                        order: e[1]
                    },
                    success: function(a) {
                        console.log(a), app.look.ok(a.data.message);
                    },
                    fail: function(a) {
                        wx.showModal({
                            title: "错误",
                            showCancel: !1,
                            content: a.data.message,
                            confirmText: "关闭"
                        });
                    }
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    onLoad: function(a) {
        var t = this;
        this.setData({
            "goHome.blackhomeimg": app.globalData.blackhomeimg
        }), app.util.request({
            url: "entry/wxapp/community",
            showLoading: !1,
            method: "POST",
            data: {
                op: "club"
            },
            success: function(a) {
                var e = a.data;
                e.data.list && t.setData({
                    haspage: !0,
                    list: e.data.list,
                    regions: e.data.list.region.split(" ")
                });
            },
            fail: function(a) {
                2 == a.data.errno ? wx.redirectTo({
                    url: "/xc_xinguwu/community/sqApplyMaster/sqApplyMaster"
                }) : 1 == a.data.errno ? app.look.no(a.data.message, function() {
                    app.look.back(1);
                }) : 3 == a.data.errno && t.setData({
                    showAuit: !0
                });
            }
        });
    },
    onReady: function() {
        var a = {};
        a.sq_bg = app.module_url + "resource/wxapp/community/sq-bg.png", a.sq_edit = app.module_url + "resource/wxapp/community/sq-edit.png", 
        a.sq_user = app.module_url + "resource/wxapp/community/sq-user.png", a.sq_wpos = app.module_url + "resource/wxapp/community/sq-wpos.png", 
        a.sq_wsercive = app.module_url + "resource/wxapp/community/sq-wsercive.png", a.sq_get = app.module_url + "resource/wxapp/community/sq-get.png", 
        a.sq_scan = app.module_url + "resource/wxapp/community/sq-scan.png", a.sq_onekey = app.module_url + "resource/wxapp/community/sq-onekey.png", 
        a.sq_sta = app.module_url + "resource/wxapp/community/sq-sta.png", a.sq_group = app.module_url + "resource/wxapp/community/sq-group.png", 
        a.sq_con = app.module_url + "resource/wxapp/community/sq-con.png", a.sq_alt_user = app.module_url + "resource/wxapp/community/sq-alt-user.png", 
        a.sq_alt_pos = app.module_url + "resource/wxapp/community/sq-alt-pos.png", a.sq_auit = app.module_url + "resource/wxapp/community/sq-auit.png", 
        this.setData({
            images: a,
            avatarurl: app.globalData.userInfo.avatarurl
        }), app.look.goHome(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/community",
            showLoading: !1,
            method: "POST",
            data: {
                op: "club"
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var e = a.data;
                e.data.list && t.setData({
                    haspage: !0,
                    list: e.data.list,
                    regions: e.data.list.region.split(" ")
                });
            },
            fail: function(a) {
                2 == a.data.errno ? wx.redirectTo({
                    url: "/xc_xinguwu/pages/sqApplyMaster/sqApplyMaster"
                }) : 1 == a.data.errno && app.look.no(a.data.message, function() {
                    app.look.back(1);
                });
            }
        });
    },
    onReachBottom: function() {}
});