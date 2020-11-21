var app = getApp(), image = "", util = require("../../../resource/utils/util.js");

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
        tabBarList: []
    },
    onLoad: function(t) {
        this.setData({
            tabBarList: app.globalData.tabbar3
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    goIndex: function(t) {
        wx.reLaunch({
            url: "../../product/index/index"
        });
    },
    goChargeIndex: function(t) {
        wx.reLaunch({
            url: "../../charge/chargeIndex/chargeIndex"
        });
    },
    goFindIndex: function(t) {
        wx.reLaunch({
            url: "../../find/findIndex/findIndex"
        });
    },
    goMy: function(t) {
        wx.reLaunch({
            url: "../../myUser/my/my"
        });
    },
    orderTab: function(t) {},
    formSubmit: function(t) {
        var e = t.detail.value, a = this, o = app.util.url("entry/wxapp/TouploadTwo") + "&m=byjs_sun", i = a.data.pics;
        if (!e.push_text) return wx.showToast({
            title: "内容不能为空！！！",
            icon: "none"
        }), !1;
        wx.showLoading({
            title: "内容发布中，请稍后...",
            mask: !0
        });
        var n = wx.getStorageSync("users").id;
        a.setData({
            disabled: !0,
            sendtitle: "稍后"
        }), app.util.request({
            url: "entry/wxapp/Addtalentcircle",
            cachetime: "0",
            data: {
                user_id: n,
                uniacid: app.siteInfo.uniacid,
                content: e.push_text
            },
            success: function(t) {
                var e = t.data;
                if (0 < i.length) {
                    console.log(i), console.log(22222);
                    var n = {
                        tcid: e
                    };
                    a.uploadimg({
                        url: o,
                        path: i
                    }, n);
                } else wx.hideLoading(), wx.showToast({
                    title: "发布成功！！！",
                    icon: "success",
                    success: function() {
                        a.setData({
                            pics: [],
                            content: "",
                            disabled: !1,
                            sendtitle: "发送"
                        });
                    }
                });
            },
            fail: function() {
                a.setData({
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
    uploadimg: function(t, e) {
        var n = this, a = t.i ? t.i : 0, o = t.success ? t.success : 0, i = t.fail ? t.fail : 0;
        console.log(JSON.stringify(e) + "这是上传图片事件参数"), console.log(t.path + "进入上传图片"), wx.uploadFile({
            url: t.url,
            filePath: t.path[a],
            name: "file",
            formData: e,
            success: function(t) {
                1 == t.data && o++, console.log("tu11111111"), console.log(t), console.log(a);
            },
            fail: function(t) {
                2 == t.data && i++, console.log("fail:" + a + "fail:" + i);
            },
            complete: function() {
                ++a == t.path.length ? (console.log("执行完毕"), wx.hideLoading(), wx.showToast({
                    title: "发布成功！！！",
                    icon: "success",
                    success: function() {
                        n.setData({
                            pics: [],
                            content: "",
                            disabled: !1,
                            sendtitle: "发送"
                        }), app.globalData.aci = "", wx.switchTab({
                            url: "../../interactive/interactiveMoving/interactiveMoving"
                        });
                    }
                })) : (t.i = a, t.success = o, t.fail = i, n.uploadimg(t, e));
            }
        });
    },
    chooseImage: function() {
        var e = this, n = e.data.pics;
        n.length < 9 ? wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                n = n.concat(t.tempFilePaths), e.setData({
                    pics: n
                });
            }
        }) : wx.showToast({
            title: "只允许上传9张图片！！！",
            icon: "none"
        });
    },
    deleteImage: function(t) {
        var e = this.data.pics, n = t.currentTarget.dataset.index;
        e.splice(n, 1), this.setData({
            pics: e
        });
    },
    onReady: function() {},
    onShow: function() {
        this.onLoad();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    showData: function(t) {},
    contentTimeInput: function(t) {
        var e = t.detail.value;
        this.setData({
            gowithtime: e
        });
    }
});