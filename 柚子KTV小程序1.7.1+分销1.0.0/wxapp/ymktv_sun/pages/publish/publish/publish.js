var app = getApp(), image = "", util = require("../../../../we7/js/utils/util.js");

Page({
    data: {
        src: [],
        tab: 0,
        content: "",
        contetn_time: "",
        content_route: "",
        goId: 0,
        showbox: 1,
        goods_id: "",
        visa_id: "",
        goods: "",
        pics: [],
        imgAddr: "",
        gowithtime: "年/月/日",
        thistime: util.formatTime,
        disabled: !1,
        sendtitle: "发送",
        whichone: 9
    },
    onLoad: function(t) {
        var o = wx.getStorageSync("url");
        this.setData({
            url: o
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    orderTab: function(t) {},
    formSubmit: function(t) {
        var o = t.detail.value, i = this, n = app.util.url("entry/wxapp/Toupload") + "&m=ymktv_sun", a = i.data.pics;
        if (!o.push_text && a.length <= 0) return wx.showToast({
            title: "写点内容或者发张图片吧！！！",
            icon: "none"
        }), !1;
        wx.showLoading({
            title: "内容发布中，请稍后...",
            mask: !0
        });
        var e = wx.getStorageSync("userid");
        i.setData({
            disabled: !0,
            sendtitle: "稍后"
        }), app.util.request({
            url: "entry/wxapp/Addtalentcircle",
            cachetime: "0",
            data: {
                user_id: e,
                uniacid: app.siteInfo.uniacid,
                content: o.push_text
            },
            success: function(t) {
                var o = t.data;
                if (console.log(o), 0 < a.length) {
                    var e = {
                        tcid: o
                    };
                    i.uploadimg({
                        url: n,
                        path: a
                    }, e);
                } else wx.hideLoading(), wx.showToast({
                    title: "发布成功！！！",
                    icon: "success",
                    success: function() {
                        wx.navigateTo({
                            url: "../../discover/discover/discover"
                        });
                    }
                });
            },
            fail: function() {
                i.setData({
                    disabled: !1,
                    sendtitle: "发送"
                }), wx.showToast({
                    title: "可能由于网络原因，发布失败，请重新发布！！！",
                    icon: "none",
                    success: function() {
                        wx.hideLoading();
                    }
                });
            }
        });
    },
    uploadimg: function(t, o) {
        var e = this, i = t.i ? t.i : 0, n = t.success ? t.success : 0, a = t.fail ? t.fail : 0;
        console.log(t), console.log(o), wx.uploadFile({
            url: t.url,
            filePath: t.path[i],
            name: "file",
            formData: o,
            success: function(t) {
                1 == t.data && n++;
            },
            fail: function(t) {
                2 == t.data && a++, console.log("fail:" + i + "fail:" + a);
            },
            complete: function() {
                ++i == t.path.length ? (console.log("执行完毕"), wx.hideLoading(), wx.showToast({
                    title: "发布成功！！！",
                    icon: "success",
                    success: function() {
                        e.setData({
                            pics: [],
                            content: "",
                            disabled: !1,
                            sendtitle: "发送"
                        }), app.globalData.aci = "", wx.navigateTo({
                            url: "../../discover/discover/discover"
                        });
                    }
                })) : (t.i = i, t.success = n, t.fail = a, e.uploadimg(t, o));
            }
        });
    },
    chooseImage: function() {
        var o = this, e = o.data.pics;
        console.log(e), e.length < 9 ? wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                e = e.concat(t.tempFilePaths), console.log(e), o.setData({
                    pics: e
                });
            }
        }) : wx.showToast({
            title: "只允许上传9张图片！！！",
            icon: "none"
        });
    },
    deleteImage: function(t) {
        var o = this.data.pics, e = t.currentTarget.dataset.index;
        o.splice(e, 1), this.setData({
            pics: o
        });
    },
    onReady: function() {
        app.getNavList("");
    },
    onShow: function() {
        this.onLoad();
        for (var t = app.globalData.tabBarList, o = 0; o < t.length; o++) t[o].state = !1;
        t[2].state = !0, this.setData({
            tabBarList: t
        });
    },
    goIndex: function() {
        wx.reLaunch({
            url: "/ymktv_sun/pages/booking/index/index"
        });
    },
    goDrinks: function() {
        var t = wx.getStorageSync("bid");
        wx.reLaunch({
            url: "/ymktv_sun/pages/drinks/drinks/drinks?bid=" + t
        });
    },
    goDiscover: function() {
        wx.reLaunch({
            url: "/ymktv_sun/pages/discover/discover/discover"
        });
    },
    goMy: function() {
        wx.getStorageSync("bid");
        wx.reLaunch({
            url: "/ymktv_sun/pages/my/my/my"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    showData: function(t) {},
    contentTimeInput: function(t) {
        var o = t.detail.value;
        this.setData({
            gowithtime: o
        });
    },
    toPublishGowith: function(t) {
        wx.showToast({
            title: "该功能暂时关闭！",
            icon: "none"
        });
    }
});