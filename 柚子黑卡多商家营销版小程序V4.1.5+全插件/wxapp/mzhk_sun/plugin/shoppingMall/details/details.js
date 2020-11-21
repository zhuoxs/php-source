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
        content: "",
        finish: 0
    },
    onLoad: function(t) {
        app.wxauthSetting();
        var o = t.id;
        this.setData({
            id: o
        });
        var l = this,
            n = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/getGoodsDetail",
            data: {
                m: app.globalData.Plugin_scoretask,
                id: o,
                openid: n
            },
            showLoading: !1,
            success: function(t) {
                var o = t.data.data.end_time,
                    c = (Date.parse(new Date), parseInt(o) - parseInt(Date.parse(new Date) / 1e3)),
                    d = setInterval(function() {
                        var t = c,
                            o = Math.floor(t / 3600 / 24),
                            n = o.toString();
                        1 == n.length && (n = "0" + n);
                        var a = Math.floor((t - 3600 * o * 24) / 3600),
                            e = a.toString();
                        1 == e.length && (e = "0" + e);
                        var i = Math.floor((t - 3600 * o * 24 - 3600 * a) / 60),
                            s = i.toString();
                        1 == s.length && (s = "0" + s);
                        var r = (t - 3600 * o * 24 - 3600 * a - 60 * i).toString();
                        1 == r.length && (r = "0" + r), c--, l.setData({
                            countDownDay: n,
                            countDownHour: e,
                            countDownMinute: s,
                            countDownSecond: r
                        }), c <= 0 && (clearInterval(d), wx.showToast({
                            title: "活动已结束"
                        }), l.setData({
                            countDownDay: "00",
                            countDownHour: "00",
                            countDownMinute: "00",
                            countDownSecond: "00",
                            finish: 1
                        }))
                    }.bind(this), 1e3),
                    n = t.data.data.content;
                l.setData({
                    details: t.data.data,
                    imgroot: t.data.other.img_root,
                    endTime: o,
                    content: n
                })
            }
        }), app.util.request({
            url: "entry/wxapp/checkOrder",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: n,
                gid: o
            },
            showLoading: !1,
            success: function(t) {
                console.log("检测用户是否有足够积分兑换商品");
                var o = t.data.code;
                console.log(t.data), l.setData({
                    code: o
                })
            }
        }), this.setData({
            windowHeight: wx.getStorageSync("windowHeight")
        })
    },
    onShow: function() {
        app.func.islogin(app, this)
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
        0 == this.data.finish ? this.setData({
            points: !0
        }) : 1 == this.data.finish && wx.showToast({
            title: "活动已结束",
            icon: "none",
            duration: 2e3
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
    orderUser: function(t) {
        var o = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../orderUser/orderUser?id=" + o
        })
    },
    submit1: function(t) {
        var o = this,
            n = t.currentTarget.dataset.id;
        console.log("你的id是多少"), console.log(n);
        var a = wx.getStorageSync("users").openid,
            e = t.currentTarget.dataset.title,
            i = t.currentTarget.dataset.icon;
        console.log("你的icon"), console.log(i), this.setData({
            showModel: !0,
            type: 1,
            gid: n,
            openid: a,
            title: e,
            icon: i
        }), app.util.request({
            url: "entry/wxapp/setMyOrder",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a,
                gid: n
            },
            showLoading: !1,
            success: function(t) {
                console.log("用户自己生成砍价积分信息"), console.log(t), o.setData({})
            }
        })
    },
    onShareAppMessage: function(t) {
        if ("button" === t.from) {
            t.target.dataset.type;
            var o = t.target.dataset.gid;
            console.log("你有gid"), console.log(o);
            var n = t.target.dataset.openid;
            return {
                title: t.target.dataset.title,
                imageUrl: t.target.dataset.icon,
                path: "/mzhk_sun/plugin/shoppingMall/cutPoints/cutPoints?gid=" + o + "&d_user=" + n,
                success: function(t) {
                    console.log("转发成功")
                },
                fail: function(t) {
                    console.log("转发失败")
                }
            }
        }
    },
    updateUserInfo: function(t) {
        app.wxauthSetting()
    }
});