var app = getApp();

Page({
    data: {
        assess: 1,
        assessList: [ {
            id: 1,
            icon: "icon-c-haoping",
            name: "好评"
        }, {
            id: 2,
            icon: "icon-c-zhongchaping",
            name: "中评"
        }, {
            id: 3,
            icon: "icon-c-zhongchaping",
            name: "差评"
        } ],
        anonymous: 0,
        order_id: "",
        count_sy: 5,
        imgs: [],
        nowcount: 0,
        evaluatecon: "",
        type: "",
        add: 0
    },
    onPullDownRefresh: function() {
        this.getbaseinfo(), this.proinfo(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        a.fxsid && t.setData({
            fxsid: a.fxsid
        }), a.type && t.setData({
            type: a.type
        });
        var e = 0;
        a.add && (e = a.add, t.setData({
            add: a.add
        })), a.order_id && t.setData({
            order_id: a.order_id
        }), 0 == e ? wx.setNavigationBarTitle({
            title: "产品评价"
        }) : wx.setNavigationBarTitle({
            title: "产品追评"
        }), t.getbaseinfo(), t.proinfo(), app.util.getUserInfo(t.getinfos, 0);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    proinfo: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/assesspro",
            data: {
                order_id: t.data.order_id,
                type: t.data.type
            },
            success: function(a) {
                t.setData({
                    thumb: a.data.data.thumb,
                    pid: a.data.data.pid
                });
            }
        });
    },
    getbaseinfo: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/base",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                if (a.data.data.c_b_bg) var t = "bg";
                e.setData({
                    baseinfo: a.data.data,
                    c_b_bg1: t
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                t.setData({
                    openid: a.data
                });
            }
        });
    },
    chooseAssess: function(a) {
        var t = a.currentTarget.dataset.id;
        this.setData({
            assess: t
        });
    },
    chooseAnonymous: function() {
        var a = this.data.anonymous;
        a = 0 == a ? 1 : 0, this.setData({
            anonymous: a
        });
    },
    chooseimg: function() {
        var i = this, a = i.data.count_sy, s = i.data.imgs;
        a -= s.length;
        var d = i.data.zhixin, c = app.util.url("entry/wxapp/wxupimg", {
            m: "sudu8_page"
        });
        wx.chooseImage({
            count: a,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                d = !0, i.setData({
                    zhixin: d
                }), wx.showLoading({
                    title: "图片上传中"
                });
                var t = a.tempFilePaths, n = 0, o = t.length;
                !function e() {
                    wx.uploadFile({
                        url: c,
                        filePath: t[n],
                        name: "file",
                        success: function(a) {
                            var t = JSON.parse(a.data);
                            s.push(t), i.setData({
                                imgs: s
                            }), ++n < o ? e() : (d = !1, i.setData({
                                zhixin: d
                            }), wx.hideLoading());
                        }
                    });
                }();
            }
        });
    },
    delimg: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.imgs;
        e.splice(t, 1), this.setData({
            imgs: e
        });
    },
    evaluate: function(a) {
        var t = a.detail.value, e = a.detail.cursor;
        this.setData({
            evaluatecon: t,
            nowcount: e
        });
    },
    submit: function() {
        var a = this, t = a.data.assess, e = a.data.evaluatecon;
        if ("" == e) return wx.showModal({
            title: "提示",
            content: "评价不能为空",
            showCancel: !1
        }), !1;
        var n = a.data.imgs, o = a.data.anonymous;
        app.util.request({
            url: "entry/wxapp/evaluateSub",
            cachetime: "30",
            data: {
                assess: t,
                evaluatecon: e,
                imgs: JSON.stringify(n),
                anonymous: o,
                openid: wx.getStorageSync("openid"),
                order_id: a.data.order_id,
                pid: a.data.pid,
                type: a.data.type,
                add: a.data.add
            },
            success: function(a) {
                1 == a.data.data ? wx.showModal({
                    title: "提示",
                    content: "评价提交成功",
                    showCancel: !1,
                    success: function(a) {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                }) : wx.showModal({
                    title: "提示",
                    content: "评价提交失败"
                });
            },
            fail: function(a) {}
        });
    }
});