var app = getApp(), template = require("../template/template.js");

Page({
    data: {
        currentTab: 0,
        currentIndex: 0,
        statusType: [ "商家推荐", "最新入驻", "距离最近" ],
        listHeight: 0,
        num: 5,
        light: "",
        kong: "",
        hideRuzhu: !0
    },
    onLoad: function(t) {
        console.log("查看是否有商家分类传过来"), console.log(t), wx.setStorageSync("sjfl_id", t.id), 
        this.diyWinColor(), this.getWindowHeight();
        var o = this;
        app.util.request({
            url: "entry/wxapp/Url",
            success: function(t) {
                console.log("页面加载请求"), console.log(t), wx.setStorageSync("url", t.data), o.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            success: function(t) {
                console.log("****************************"), console.log(t), wx.setStorageSync("system", t.data), 
                wx.setNavigationBarColor({
                    frontColor: t.data.color,
                    backgroundColor: t.data.fontcolor,
                    animation: {
                        timingFunc: "easeIn"
                    }
                });
            }
        });
        var e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Test",
            data: {
                openid: e
            },
            success: function(t) {
                console.log("请求方法"), o.setData({
                    list: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Custom_photo",
            success: function(t) {
                console.log("自定义数据显示"), console.log(t.data);
                var e = wx.getStorageSync("url");
                template.tabbar("tabBar", 1, o, t, e);
            }
        }), app.util.request({
            url: "entry/wxapp/Ground_sj",
            success: function(t) {
                console.log("自定顶部图片"), console.log(t), o.setData({
                    background: t.data.background
                });
            }
        });
    },
    statusTap: function(t) {
        t.currentTarget.dataset.index;
        this.setData({
            currentIndex: t.currentTarget.dataset.index
        }), this.onShow();
    },
    toSellerDeatils: function(t) {
        console.log(t), wx.navigateTo({
            url: "../seller/details/details?id=" + t.currentTarget.dataset.id + "&&store_name=" + t.currentTarget.dataset.store_name
        });
    },
    makePhone: function(t) {
        console.log("电话的参数"), console.log(t);
        var e = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Store_tel",
            data: {
                sj_id: e
            },
            success: function(t) {
                console.log("商电话请求"), console.log(t), wx.makePhoneCall({
                    phoneNumber: t.data[0].phone,
                    success: function(t) {
                        console.log("-----拨打电话成功-----");
                    },
                    fail: function(t) {
                        console.log("-----拨打电话失败-----");
                    }
                });
            }
        });
    },
    diyWinColor: function(t) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "商家"
        });
    },
    getWindowHeight: function() {
        var e = this;
        wx.getSystemInfo({
            success: function(t) {
                console.log(t), console.log("height=" + t.windowHeight), console.log("width=" + t.windowWidth), 
                e.setData({
                    listHeight: t.windowHeight - t.windowWidth / 750 * 300 + 45
                });
            }
        });
    },
    iWantRz: function(t) {
        var e = this, o = wx.getStorageSync("user_id");
        app.util.request({
            url: "entry/wxapp/Shen_qing",
            data: {
                user_id: o
            },
            success: function(t) {
                return console.log("判断入驻状态"), console.log(t), 1 == t.data.status ? (wx.showToast({
                    title: "正在审核中无需重复添加....",
                    icon: "none"
                }), !1) : 2 == t.data.status ? (wx.showToast({
                    title: "已通过审核无需重复申请....",
                    icon: "none"
                }), !1) : (app.util.request({
                    url: "entry/wxapp/Notice_rz",
                    success: function(t) {
                        console.log("入驻需知"), console.log(t.data), e.setData({
                            Notice: t.data.notice
                        });
                    }
                }), void e.setData({
                    hideRuzhu: !1
                }));
            }
        });
    },
    applyFor: function(t) {
        wx.navigateTo({
            url: "../sjrz-Page/sjrz-Page"
        });
    },
    closePopupTap: function(t) {
        this.setData({
            hideRuzhu: !0
        });
    },
    bindChange: function(t) {
        this.setData({
            currentTab: t.detail.current
        });
    },
    swichNav: function(t) {
        if (this.data.currentTab === t.target.dataset.current) return !1;
        this.setData({
            currentTab: t.target.dataset.current
        });
    },
    onReady: function() {
        var t = wx.createCanvasContext("myCanvas");
        t.setFillStyle("#ffb62b"), t.setFontSize(12), t.beginPath(), t.moveTo(0, 0), t.stroke(), 
        t.beginPath(), t.moveTo(0, 0), t.bezierCurveTo(30, 30, 345, 30, 375, 0), t.setStrokeStyle("#ffb62b"), 
        t.stroke(), t.fill(), t.draw();
    },
    onShow: function() {
        var n = this, a = n.data.currentIndex, s = wx.getStorageSync("sjfl_id");
        console.log(a), console.log(s), wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var e = t.latitude, o = t.longitude;
                console.log(e), console.log(o), app.util.request({
                    url: "entry/wxapp/Store_xxk",
                    data: {
                        sjfl_id: s,
                        latitude: e,
                        longitude: o,
                        currentIndex: a
                    },
                    success: function(t) {
                        console.log("商家数据请求"), console.log(t), n.setData({
                            list1: t.data
                        });
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});