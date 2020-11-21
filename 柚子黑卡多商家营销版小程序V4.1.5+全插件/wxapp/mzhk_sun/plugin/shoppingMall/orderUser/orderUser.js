/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {
        windowHeight: 654,
        maxtime: "",
        isHiddenLoading: !0,
        isHiddenToast: !0,
        dataList: {},
        countDownDay: 0,
        countDownHour: 0,
        countDownMinute: 0,
        countDownSecond: 0,
        is_modal_Hidden: !0,
        detail: [],
        points: !1,
        id: "",
        code: "",
        address_id: "",
        gid: ""
    },
    onLoad: function(t) {
        app.wxauthSetting();
        var a = t.gid;
        if (null == (e = t.id)) var e = a;
        else e = t.id;
        this.setData({
            id: e
        });
        var c = this,
            o = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/getGoodsDetail",
            data: {
                m: app.globalData.Plugin_scoretask,
                id: e,
                openid: o
            },
            showLoading: !1,
            success: function(t) {
                console.log("获取积分商品详情信息"), console.log(t);
                var a = t.data.data.end_time,
                    r = (Date.parse(new Date), parseInt(a) - parseInt(Date.parse(new Date) / 1e3)),
                    l = setInterval(function() {
                        var t = r,
                            a = Math.floor(t / 3600 / 24),
                            e = a.toString();
                        1 == e.length && (e = "0" + e);
                        var o = Math.floor((t - 3600 * a * 24) / 3600),
                            n = o.toString();
                        1 == n.length && (n = "0" + n);
                        var s = Math.floor((t - 3600 * a * 24 - 3600 * o) / 60),
                            i = s.toString();
                        1 == i.length && (i = "0" + i);
                        var d = (t - 3600 * a * 24 - 3600 * o - 60 * s).toString();
                        1 == d.length && (d = "0" + d), c.setData({
                            countDownDay: e,
                            countDownHour: n,
                            countDownMinute: i,
                            countDownSecond: d
                        }), --r < 0 && (clearInterval(l), wx.showToast({
                            title: "活动已结束"
                        }), c.setData({
                            countDownDay: "00",
                            countDownHour: "00",
                            countDownMinute: "00",
                            countDownSecond: "00"
                        }))
                    }.bind(this), 1e3);
                c.setData({
                    details: t.data.data,
                    imgroot: t.data.other.img_root,
                    endTime: a
                })
            }
        }), app.util.request({
            url: "entry/wxapp/checkSelfSetOrder",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: o,
                gid: e
            },
            showLoading: !1,
            success: function(t) {
                console.log("检测用户是否有足够积分兑换商品");
                var a = t.data.code;
                console.log(t.data), c.setData({
                    code: a
                })
            }
        }), this.setData({
            windowHeight: wx.getStorageSync("windowHeight")
        })
    },
    getAddressList: function() {
        var l = this,
            t = wx.getStorageSync("users").openid,
            a = wx.getStorageSync("scoretask_address_id");
        console.log("默认地址"), console.log(a), 0 < a ? (wx.setStorageSync("scoretask_address_id", 0), app.util.request({
            url: "entry/wxapp/getAddressDetail",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: t,
                id: a
            },
            showLoading: !1,
            success: function(t) {
                t = t.data;
                l.setData({
                    address_id: a,
                    name: t.name,
                    phone: t.phone,
                    province: t.province,
                    zip: t.zip,
                    city: t.city,
                    address: t.address
                })
            }
        })) : app.util.request({
            url: "entry/wxapp/getDefaultAddress",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: t
            },
            showLoading: !1,
            success: function(t) {
                console.log("获取地址列表函数");
                var a = t.data.data.id,
                    e = t.data.data.gid,
                    o = t.data.data.name,
                    n = t.data.data.phone,
                    s = t.data.data.province,
                    i = t.data.data.zip,
                    d = t.data.data.city,
                    r = t.data.data.address;
                l.setData({
                    address_id: a,
                    name: o,
                    phone: n,
                    province: s,
                    zip: i,
                    city: d,
                    address: r,
                    gid: e
                })
            }
        })
    },
    task: function(t) {
        wx.redirectTo({
            url: "../assignment/assignment"
        }), console.log()
    },
    pointsMall: function() {
        wx.redirectTo({
            url: "../integrationMall/integrationMall"
        })
    },
    preventTouchMove: function() {},
    go: function() {
        this.setData({
            showModel: !1
        })
    },
    mark: function() {
        this.setData({
            showModel6: !1
        })
    },
    bulletWindow: function() {
        this.setData({
            points: !0
        })
    },
    close: function() {
        this.setData({
            points: !1
        })
    },
    earnPoints: function() {
        wx.navigateTo({
            url: "../assignment/assignment"
        })
    },
    submit1: function(t) {
        var a = this,
            e = t.currentTarget.dataset.id;
        console.log("你的id是多少"), console.log(e);
        var o = wx.getStorageSync("users").openid,
            n = t.currentTarget.dataset.title,
            s = t.currentTarget.dataset.icon;
        console.log("你的icon"), console.log(s), this.setData({
            showModel: !0,
            type: 1,
            gid: e,
            openid: o,
            title: n,
            icon: s
        }), app.util.request({
            url: "entry/wxapp/setMyOrder",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: o,
                gid: e
            },
            showLoading: !1,
            success: function(t) {
                console.log("用户自己生成砍价积分信息"), console.log(t), a.setData({})
            }
        })
    },
    onShareAppMessage: function(t) {
        if ("button" === t.from) {
            t.target.dataset.type;
            var a = t.target.dataset.gid;
            console.log("你有gid"), console.log(a);
            var e = t.target.dataset.openid;
            return {
                title: t.target.dataset.title,
                imageUrl: t.target.dataset.icon,
                path: "/mzhk_sun/plugin/shoppingMall/cutPoints/cutPoints?gid=" + a + "&d_user=" + e,
                success: function(t) {
                    console.log("转发成功")
                },
                fail: function(t) {
                    console.log("转发失败")
                }
            }
        }
    },
    consignee: function(t) {
        var a = this.data.id,
            e = t.currentTarget.dataset.id;
        wx.setStorageSync("jump_type", 2), e ? wx.navigateTo({
            url: "../addressManagement/addressManagement?gid=" + a
        }) : wx.navigateTo({
            url: "../addressManagement/addressManagement"
        })
    },
    getOrderDetailByGid: function() {
        var a = this,
            t = wx.getStorageSync("users").openid,
            e = this.data.id;
        app.util.request({
            url: "entry/wxapp/getOrderDetailByGid",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: t,
                gid: e
            },
            showLoading: !1,
            success: function(t) {
                console.log(t.data.data), a.setData({
                    order_score: t.data.data.order_score
                })
            }
        })
    },
    orderUser: function(t) {
        var o = this,
            a = o.data.id;
        console.log("你的gid是多少"), console.log(a);
        var e = t.detail.value.username;
        console.log("你的remark是多少"), console.log(e);
        var n = o.data.address_id;
        if (n <= 0 || null == n) wx.showToast({
            title: "请选择地址",
            icon: "none",
            duration: 2e3
        });
        else {
            var s = wx.getStorageSync("users").openid;
            app.util.request({
                url: "entry/wxapp/setOrderScore",
                data: {
                    m: app.globalData.Plugin_scoretask,
                    address_id: n,
                    openid: s,
                    remark: e,
                    gid: a
                },
                showLoading: !1,
                success: function(t) {
                    console.log("用户兑换积分商品下单");
                    var a = t.data.code,
                        e = t.data.msg;
                    1 == a ? wx.showToast({
                        title: e,
                        icon: "none",
                        duration: 2e3
                    }) : o.setData({
                        points: !0
                    }), o.setData({})
                }
            })
        }
    },
    onShow: function() {
        app.func.islogin(app, this), this.getAddressList(), this.getOrderDetailByGid()
    },
    editor: function(t) {
        t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../addressManagement/addressManagement"
        })
    },
    returnOrder: function() {
        wx.redirectTo({
            url: "../myOrder/myOrder"
        })
    },
    returnHome: function() {
        wx.redirectTo({
            url: "../home/home"
        })
    },
    updateUserInfo: function(t) {
        app.wxauthSetting()
    }
});