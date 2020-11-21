var app = getApp();

Page({
    data: {
        codeimg: "",
        currentindex: 0,
        bottomnav: [ "数据", "订单", "设置" ],
        wxcode_open: 0,
        allow_open: 0,
        release_open: 0,
        rebate_open: 0,
        list: [ {
            title: "今日订单",
            detail: "0"
        }, {
            title: "昨日订单",
            detail: "0"
        }, {
            title: "本月订单",
            detail: "0"
        }, {
            title: "总订单量",
            detail: "0"
        }, {
            title: "今日核销",
            detail: "0"
        }, {
            title: "昨日核销",
            detail: "0"
        }, {
            title: "本月核销",
            detail: "0"
        }, {
            title: "总核销量",
            detail: "0"
        }, {
            title: "今日销售额",
            detail: "0"
        }, {
            title: "昨日销售额",
            detail: "0"
        }, {
            title: "本月销售额",
            detail: "0"
        }, {
            title: "总销售额",
            detail: "0"
        } ],
        brandinfo: [],
        is_modal_Hidden: !0,
        ordernum: "",
        show: !1,
        codeShow: !0,
        isboss: !0,
        goodsnum: 1,
        marketing: [ {
            name: "抢购订单",
            img: "../../../../style/images/m1.png",
            showtype: 0,
            show: 1
        }, {
            name: "拼团订单",
            img: "../../../../style/images/m2.png",
            showtype: 1,
            show: 1
        }, {
            name: "砍价订单",
            img: "../../../../style/images/m3.png",
            showtype: 2,
            show: 1
        }, {
            name: "集卡订单",
            img: "../../../../style/images/m4.png",
            showtype: 3,
            show: 1
        }, {
            name: "免单订单",
            img: "../../../../style/images/m3.png",
            showtype: 6,
            show: 1
        }, {
            name: "普通订单",
            img: "../../../../style/images/m5.png",
            showtype: 4,
            show: 1
        }, {
            name: "次卡订单",
            img: "../../../../style/images/c1.png",
            showtype: 7,
            show: 0
        }, {
            name: "次卡管理",
            img: "../../../../style/images/c2.png",
            showtype: 9,
            show: 0
        }, {
            name: "权益订单",
            img: "../../../../style/images/q1.png",
            showtype: 8,
            show: 0
        }, {
            name: "权益管理",
            img: "../../../../style/images/q2.png",
            showtype: 10,
            show: 0
        }, {
            name: "配送订单",
            img: "../../../../style/images/c1.png",
            showtype: 11,
            show: 1
        } ]
    },
    onLoad: function(e) {
        var n = this, t = app.getSiteUrl();
        n.setData({
            url: t
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "0",
            success: function(e) {
                console.log(e.data), n.setData({
                    allow_open: e.data.allow_open,
                    rebate_open: e.data.rebate_open,
                    release_open: e.data.openrelease
                });
            }
        });
        var o = wx.getStorageSync("brand_info");
        if (o || wx.redirectTo({
            url: "/mzhk_sun/pages/backstage/backstage"
        }), wx.getStorageSync("openid") == o.bind_openid) var a = !1; else a = !0;
        console.log("获取店铺信息"), console.log(o), n.setData({
            brandinfo: o,
            isboss: a
        });
        var r = n.data.list;
        app.util.request({
            url: "entry/wxapp/GetOrderNum",
            cachetime: "0",
            data: {
                bid: o.bid
            },
            success: function(e) {
                console.log("获取订单数据"), console.log(e.data);
                for (var t = e.data.count, a = 0; a < r.length; a++) r[a].detail = t[a];
                o.totalamount = e.data.totalamount, n.setData({
                    list: r,
                    brandinfo: o
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetPayment",
            cachetime: "0",
            data: {
                bid: o.bid,
                type: 1
            },
            success: function(e) {
                if (console.log("获取线下付数据"), console.log(e.data), 2 != e.data) {
                    var t = e.data.num, a = e.data.money;
                    n.setData({
                        paynum: t,
                        paymoney: a
                    });
                }
            }
        }), app.util.request({
            url: "entry/wxapp/GetRebate",
            cachetime: "0",
            data: {
                bid: o.bid
            },
            success: function(e) {
                console.log(e.data), n.setData({
                    rebate: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/CheckGroup",
            success: function(e) {
                console.log("成功");
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 7
            },
            showLoading: !1,
            success: function(e) {
                var t = 2 != e.data && e.data, a = n.data.marketing;
                for (var o in a) a[7].show = 1, a[6].show = 1;
                t && n.setData({
                    open_subcard: t,
                    marketing: a
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 6
            },
            showLoading: !1,
            success: function(e) {
                var t = 2 != e.data && e.data, a = n.data.marketing;
                for (var o in a) a[9].show = 1, a[8].show = 1;
                t && n.setData({
                    open_member: t,
                    marketing: a
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        app.func.islogin(app, this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    scanCode: function(e) {
        var o = this;
        wx.scanCode({
            scanType: "",
            success: function(e) {
                console.log("扫描获取数据-成功"), console.log(e);
                var a = JSON.parse(e.result), t = wx.getStorageSync("brand_info").bid;
                40 == a.ordertype ? app.util.request({
                    url: "entry/wxapp/GetOrderInfo",
                    cachetime: "0",
                    data: {
                        id: a.id,
                        ordertype: a.ordertype,
                        bid: t,
                        uid: a.uid,
                        time: a.time
                    },
                    success: function(e) {
                        console.log("获取订单数据");
                        var t = e.data;
                        t.ordertype = a.ordertype, console.log(t), o.setData({
                            writeoff: t,
                            goodsnum: 1,
                            show: !0,
                            user_uid: a.uid,
                            user_id: a.id
                        });
                    }
                }) : app.util.request({
                    url: "entry/wxapp/GetOrderInfo",
                    cachetime: "0",
                    data: {
                        id: a.id,
                        ordertype: a.ordertype,
                        bid: t
                    },
                    success: function(e) {
                        console.log("获取订单数据");
                        var t = e.data;
                        t.ordertype = a.ordertype, console.log(t), o.setData({
                            writeoff: t,
                            goodsnum: 1,
                            show: !0
                        });
                    }
                });
            },
            fail: function(e) {
                console.log("扫描获取数据-失败"), console.log(e);
            }
        });
    },
    toaddlessbtn: function(e) {
        var t = this.data.goodsnum, a = e.currentTarget.dataset.ty, o = this.data.writeoff, n = o.num - o.haswrittenoffnum;
        if (1 == a) {
            if (!(t < n)) return wx.showModal({
                title: "提示信息",
                content: "该订单当前最多只能核销" + n + "个",
                showCancel: !1
            }), !1;
            t += 1;
        } else 1 < t && (t -= 1);
        this.setData({
            goodsnum: t
        });
    },
    showModel: function(e) {
        this.setData({
            show: !this.data.show
        });
    },
    showCodeModel: function(e) {
        var t = this, a = wx.getStorageSync("brand_info").bid, o = wx.getStorageSync("System");
        console.log(o);
        t.data.codeimg;
        var n = o.wxcode_open;
        t.data.wxcode_open;
        if (1 == n) {
            var r = "mzhk_sun/pages/user/pay/pay?bid=" + a + "&showtpe=1";
            app.util.request({
                url: "entry/wxapp/isWxCode",
                cachetime: "0",
                data: {
                    bid: a
                },
                success: function(e) {
                    2 == e.data ? app.util.request({
                        url: "entry/wxapp/GetBrandCode",
                        cachetime: "0",
                        data: {
                            page: r,
                            width: 420,
                            bid: a
                        },
                        success: function(e) {
                            console.log(e.data), t.setData({
                                codeimg: e.data.codeimgsrc
                            });
                        },
                        fial: function(e) {
                            console.log("获取小程序码失败");
                        }
                    }) : t.setData({
                        codeimg: e.data
                    });
                },
                fial: function(e) {
                    console.log("获取小程序码失败");
                }
            });
        } else {
            var s = require("../../../../style/utils/index.js"), i = '{ "bid": ' + a + ', "showtype": 1 }';
            s.qrcode("qrcode", i, 420, 420);
        }
        t.setData({
            codeShow: !t.data.codeShow,
            wxcode_open: n
        });
    },
    formSubmit: function(e) {
        var o = this, t = e.detail.value.orderNum, a = wx.getStorageSync("brand_info");
        app.util.request({
            url: "entry/wxapp/GetOrderInfo2",
            cachetime: "0",
            data: {
                bid: a.bid,
                hxcode: t
            },
            success: function(a) {
                console.log("获取订单数据"), 2 == a.data ? wx.showModal({
                    title: "提示信息",
                    content: "核销码错误",
                    showCancel: !1
                }) : 333 == a.data ? wx.showModal({
                    title: "提示信息",
                    content: "订单不属于该商家",
                    showCancel: !1
                }) : app.util.request({
                    url: "entry/wxapp/GetOrderInfo",
                    cachetime: "0",
                    data: {
                        id: a.data.id,
                        ordertype: a.data.ordertype,
                        bid: a.data.bid
                    },
                    success: function(e) {
                        console.log("获取订单数据");
                        var t = e.data;
                        t.ordertype = a.data.ordertype, console.log(t), o.setData({
                            writeoff: t,
                            goodsnum: 1,
                            show: !0
                        });
                    }
                });
            }
        });
    },
    writeoff: function(e) {
        var t = this, a = t.data.writeoff, o = wx.getStorageSync("brand_info"), n = o.bid, r = t.data.goodsnum;
        console.log(a.ordertype), 40 != a.ordertype && app.util.request({
            url: "entry/wxapp/SaoBrandOrder",
            data: {
                id: a.oid,
                bid: n,
                ordertype: a.ordertype,
                goodsnum: r
            },
            success: function(e) {
                console.log("核销订单"), console.log(e.data), t.setData({
                    show: !1,
                    brandinfo: o
                }), wx.showToast({
                    title: "核销成功",
                    icon: "success",
                    duration: 2e3
                });
            },
            fial: function(e) {
                console.log("核销订单11"), console.log(e.data), wx.showModal({
                    title: "提示信息",
                    content: e.data.message,
                    showCancel: !1
                });
            }
        }), 40 == a.ordertype && (console.log(1111), app.util.request({
            url: "entry/wxapp/suremember",
            data: {
                id: t.data.user_id,
                bid: n,
                uid: t.data.user_uid
            },
            success: function(e) {
                console.log("核销订单"), console.log(e.data), t.setData({
                    show: !1,
                    brandinfo: o
                }), wx.showToast({
                    title: "核销成功",
                    icon: "success",
                    duration: 2e3
                });
            },
            fial: function(e) {
                console.log("核销订单11"), console.log(e.data), wx.showModal({
                    title: "提示信息",
                    content: e.data.message,
                    showCancel: !1
                });
            }
        }));
    },
    logout: function(e) {
        console.log("退出");
        wx.setStorageSync("brand_info", !1), wx.setStorageSync("loginname", !1), app.globalData.islogin = 0, 
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    toCash: function(e) {
        wx.navigateTo({
            url: "../cash/cash"
        });
    },
    toMyorder: function(e) {
        var t = e.currentTarget.dataset.showtype;
        wx.navigateTo({
            url: "../myorder/myorder?ordertype=" + t
        });
    },
    toSubcard: function(e) {
        console.log(e);
        var t = e.currentTarget.dataset.showtype;
        0 == t && wx.navigateTo({
            url: "../myorder/myorder?ordertype=" + t
        }), 1 == t && wx.navigateTo({
            url: "../myorder/myorder?ordertype=" + t
        }), 2 == t && wx.navigateTo({
            url: "../myorder/myorder?ordertype=" + t
        }), 3 == t && wx.navigateTo({
            url: "../myorder/myorder?ordertype=" + t
        }), 4 == t && wx.navigateTo({
            url: "../myorder/myorder?ordertype=" + t
        }), 6 == t && wx.navigateTo({
            url: "../myorder/myorder?ordertype=" + t
        }), 7 == t && wx.navigateTo({
            url: "../../../plugin2/secondary/suborder/suborder?kid="
        }), 9 == t && wx.navigateTo({
            url: "../../../plugin2/secondary/management/management"
        }), 8 == t && wx.navigateTo({
            url: "../../../plugin2/member/memberorder/memberorder"
        }), 10 == t && wx.navigateTo({
            url: "../../../plugin2/member/membermanagement/membermanagement"
        }), 11 == t && wx.navigateTo({
            url: "../psorder/psorder"
        });
    },
    toModifyStock: function(e) {
        wx.navigateTo({
            url: "../modifystock/modifystock"
        });
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    setBrandopen: function(e) {
        var a = this, o = wx.getStorageSync("brand_info"), n = e.currentTarget.dataset.status;
        app.util.request({
            url: "entry/wxapp/SetBrandOpen",
            cachetime: "0",
            data: {
                bid: o.bid
            },
            success: function(e) {
                if (console.log(e.data), 2 == e.data) wx.showModal({
                    title: "提示信息",
                    content: "修改失败",
                    showCancel: !1
                }); else {
                    if (1 == n) var t = 0; else t = 1;
                    o.brand_open = t, wx.setStorageSync("brand_info", o), a.setData({
                        brandinfo: o
                    });
                }
            }
        });
    },
    setTimeopen: function(e) {
        var a = this, o = wx.getStorageSync("brand_info"), n = e.currentTarget.dataset.status;
        app.util.request({
            url: "entry/wxapp/SetTimeOpen",
            cachetime: "0",
            data: {
                bid: o.bid
            },
            success: function(e) {
                if (console.log(e.data), 2 == e.data) wx.showModal({
                    title: "提示信息",
                    content: "修改失败",
                    showCancel: !1
                }); else {
                    if (1 == n) var t = 0; else t = 1;
                    o.time_open = t, wx.setStorageSync("brand_info", o), a.setData({
                        brandinfo: o
                    });
                }
            }
        });
    },
    toRebateorder: function(e) {
        var t = wx.getStorageSync("brand_info");
        wx.navigateTo({
            url: "../rebateorder/rebateorder?bid=" + t.bid
        });
    },
    toPayment: function(e) {
        var t = wx.getStorageSync("brand_info");
        wx.navigateTo({
            url: "../payment/payment?bid=" + t.bid
        });
    },
    changenav: function(e) {
        var t = e.currentTarget.dataset.index;
        this.data.currentindex;
        console.log(t), this.setData({
            currentindex: t
        });
    },
    toRelease: function(e) {
        wx.navigateTo({
            url: "../release/release"
        });
    },
    toMygoods: function(e) {
        wx.navigateTo({
            url: "../mygoods/mygoods"
        });
    }
});