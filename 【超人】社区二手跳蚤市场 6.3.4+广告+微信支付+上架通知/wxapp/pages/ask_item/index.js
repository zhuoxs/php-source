var qqmapsdk, app = getApp(), Toast = require("../../libs/zanui/toast/toast"), Toptips = require("../../libs/zanui/toptips/index"), QQMapWX = require("../../libs/qqmap-wx-jssdk.js");

Page({
    data: {
        cancelWithMask: !0,
        showConfirm: !1,
        placeholder: "点击获取定位"
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("loading_img");
        e ? a.setData({
            loadingImg: e
        }) : a.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), app.viewCount(), t.message && a.setData({
            can_edit: !0
        }), a.checkBlacklist(), a.getBasicInfo();
    },
    getBasicInfo: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/ask_item",
            cachetime: "0",
            data: {
                m: "superman_hand2"
            },
            success: function(t) {
                if (t.data.errno) i.showIconToast(t.data.errmsg); else {
                    var a = t.data.data;
                    if (a.item) {
                        for (var e = a.distance, s = 0; s < e.length; s++) if (e[s] == a.item.distance) {
                            i.setData({
                                idx: s
                            });
                            break;
                        }
                        i.setData({
                            detail: a.item,
                            address: a.item.address,
                            lat: a.item.lat,
                            lng: a.item.lng
                        });
                    }
                    i.setData({
                        distance: a.distance,
                        rule: a.rule,
                        completed: !0
                    });
                }
            }
        });
    },
    closeAuth: function() {
        this.setData({
            showAuth: !1
        });
    },
    checkBlacklist: function() {
        app.util.request({
            url: "entry/wxapp/my",
            cachetime: "0",
            data: {
                act: "blacklist",
                m: "superman_hand2"
            },
            success: function() {},
            fail: function(t) {
                wx.showModal({
                    title: "系统提示",
                    content: t.data.errmsg,
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "../home/index"
                        });
                    }
                });
            }
        });
    },
    getAddress: function() {
        var s = this;
        s.data.item_id || (s.setData({
            placeholder: "正在定位中..."
        }), qqmapsdk = new QQMapWX({
            key: "7M4BZ-FDEK3-JC737-YXQ5O-V3IO3-E5FH5"
        }), wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var a = t.latitude, e = t.longitude;
                s.setData({
                    lat: a,
                    lng: e
                }), qqmapsdk.reverseGeocoder({
                    location: {
                        latitude: a,
                        longitude: e
                    },
                    get_poi: 1,
                    poi_options: "address_format=short;radius=2000;policy=1;category=房产小区,住宅区,住宅小区",
                    success: function(t) {
                        if (t.result.formatted_addresses) s.setData({
                            address: t.result.formatted_addresses.recommend
                        }); else if (t.result.address_component) {
                            var a = t.result.address_component;
                            s.setData({
                                address: a.locality + a.street
                            });
                        }
                    },
                    fail: function(t) {
                        Toptips(t.message);
                    }
                });
            },
            fail: function() {
                s.setData({
                    showAuth: !0,
                    placeholder: "点击定位"
                });
            }
        }));
    },
    showDistance: function(t) {
        this.setData({
            idx: t.detail.value
        });
    },
    deleteItem: function() {
        var e = this;
        wx.showModal({
            title: "系统提示",
            content: "确定要删除此条上架通知吗？",
            success: function(t) {
                if (t.confirm) {
                    var a = e.data.detail.id;
                    app.util.request({
                        url: "entry/wxapp/ask_item",
                        cachetime: "0",
                        data: {
                            id: a,
                            act: "delete",
                            m: "superman_hand2"
                        },
                        success: function(t) {
                            t.data.errno ? e.showIconToast(t.data.errmsg) : (e.showIconToast("删除成功", "success"), 
                            setTimeout(function() {
                                wx.redirectTo({
                                    url: "../home/index"
                                });
                            }, 1500));
                        },
                        fail: function(t) {
                            e.showIconToast(t.data.errmsg);
                        }
                    });
                }
            }
        });
    },
    formSubmit: function(t) {
        var a = this;
        if (a.data.btnDisabled) return !1;
        a.setData({
            btnDisabled: !0
        });
        var e = t.detail.value, s = e.address, i = t.detail.formId, o = a.data.distance, n = a.data.idx, d = "";
        return a.data.detail && (d = a.data.detail.id), e.title ? s ? n ? (app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                act: "formid",
                formid: i,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
            },
            fail: function(t) {
                console.log(t.data.errmsg);
            }
        }), void app.util.request({
            url: "entry/wxapp/ask_item",
            cachetime: "0",
            method: "POST",
            data: {
                act: "post",
                id: d,
                title: e.title,
                address: s,
                formid: i,
                lat: a.data.lat,
                lng: a.data.lng,
                distance: n ? o[n] : 0,
                m: "superman_hand2"
            },
            fail: function(t) {
                a.setData({
                    btnDisabled: !1
                }), Toptips(t.data.errmsg);
            },
            success: function(t) {
                a.setData({
                    btnDisabled: !1
                }), t.data.errno ? Toptips(t.data.errmsg) : (a.showIconToast("提交成功", "success"), 
                setTimeout(function() {
                    wx.redirectTo({
                        url: "../home/index"
                    });
                }, 1500));
            }
        })) : (Toptips("请选择检索范围"), void a.setData({
            btnDisabled: !1
        })) : (Toptips("请自动定位或手动填写所在地址"), void a.setData({
            btnDisabled: !1
        })) : (Toptips("请填写关键词"), void a.setData({
            btnDisabled: !1
        }));
    },
    showIconToast: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fail";
        Toast({
            type: a,
            message: t,
            selector: "#zan-toast"
        });
    }
});