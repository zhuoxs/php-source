var app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {
        curIndex: 0,
        staus: 2,
        my_bargain: null,
        modal_show: !1,
        btnyaoqitext: "邀请好友"
    },
    holdback: function() {},
    change: function(a) {
        var t = a.currentTarget.dataset.id;
        this.setData({
            id: t
        });
    },
    bargainImmediately: function() {
        var o = this, i = this.data.list;
        null == o.data.my_bargain && (parseInt(i.stock) <= 0 ? app.look.alert("该商品已被抢光") : app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            data: {
                op: "bargain_immediately",
                id: i.id
            },
            success: function(a) {
                var t = a.data;
                console.log(t.data), o.countTime(i, t.data.bargain_self);
                var n = {
                    modal_show: !0,
                    bargain_self: t.data.bargain_self,
                    bargain_self_log: t.data.bargain_self_log,
                    cut_price: t.data.bargain_self_log[0].cut_price,
                    staus: 2
                };
                console.log(t.data.bargain_self_log), 1 == t.data.vendprice && (n.btnyaoqitext = "已坎到最低价立即购买"), 
                o.setData(n);
            },
            fail: function(a) {
                wx.showModal({
                    title: "提示",
                    content: a.data.message,
                    success: function(a) {
                        a.confirm && wx.navigateTo({
                            url: "../bargain/bargain?pagestyle=2"
                        });
                    }
                });
            }
        }));
    },
    tobuy: function() {
        wx.navigateTo({
            url: "../detail/detail?id=" + this.data.list.good_id
        });
    },
    tosubmit: function() {
        var a = [];
        a.push({
            id: this.data.list.good_id,
            img: this.data.list.bimg,
            floor_price: this.data.list.floor_price,
            name: this.data.list.good_name,
            num: 1,
            price: this.data.bargain_self.new_price,
            attr_name: this.data.list.attr_name,
            weight: this.data.list.weight
        });
        var t = [];
        t = {
            content: a,
            totalPrice: this.data.bargain_self.new_price,
            totalNum: 1,
            cid: 4,
            bargain_self_id: this.data.bargain_self.id
        }, console.log(t), t = JSON.stringify(t), t = encodeURIComponent(t), wx.navigateTo({
            url: "../submit/submit?order=" + t
        });
    },
    bargain_help: function() {
        var n = this;
        console.log(n.data.bargain_self), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "bargain_help",
                id: n.data.bargain_self.id
            },
            success: function(a) {
                console.log(a), console.log(123);
                var t = a.data;
                console.log(t.data), n.setData({
                    show3: !0,
                    bargain_self: t.data.bargain_self,
                    bargain_self_log: n.data.bargain_self_log.concat(t.data.bargain_self_log),
                    cut_price: t.data.bargain_self_log.cut_price
                });
            }
        });
    },
    modalHide: function() {
        this.setData({
            modal_show: !1
        });
    },
    bindTap: function(a) {
        var t = parseInt(a.currentTarget.dataset.index);
        this.setData({
            curIndex: t
        });
    },
    share: function(a) {
        var t = this, n = wx.createAnimation({
            duration: 500,
            timingFunction: "linear"
        });
        (t.animation = n).translateY(100).step(), t.setData({
            animationData: n.export(),
            share: !0,
            show1: !0,
            show2: !1,
            show3: !1
        }), setTimeout(function() {
            n.translateY(0).step(), t.setData({
                animationData: n.export()
            });
        }, 200);
    },
    hideshare: function() {
        var a = this, t = wx.createAnimation({
            duration: 1e3,
            timingFunction: "linear"
        });
        (a.animation = t).translateY(100).step(), a.setData({
            animationData: t.export()
        }), setTimeout(function() {
            t.translateY(0).step(), a.setData({
                animationData: t.export(),
                share: !1,
                show1: !1
            });
        }, 200);
    },
    chooseSezi: function(a) {
        var t = this, n = wx.createAnimation({
            duration: 500,
            timingFunction: "linear"
        });
        (t.animation = n).translateY(100).step(), t.setData({
            animationData1: n.export(),
            chooseSize: !0,
            show2: !0,
            show1: !1,
            show3: !1
        }), setTimeout(function() {
            n.translateY(0).step(), t.setData({
                animationData1: n.export()
            });
        }, 200);
    },
    hideModal: function(a) {
        var t = this, n = wx.createAnimation({
            duration: 1e3,
            timingFunction: "linear"
        });
        (t.animation = n).translateY(100).step(), t.setData({
            animationData1: n.export()
        }), setTimeout(function() {
            n.translateY(0).step(), t.setData({
                animationData1: n.export(),
                chooseSize: !1,
                show2: !1
            });
        }, 200);
    },
    onLoad: function(a) {
        console.log(a);
        var n = this;
        app.look.istrue(a.staus) && n.setData({
            staus: a.staus
        }), n.setData({
            userinfo: app.globalData.userInfo,
            options: a
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "bargain_detail",
                id: a.id,
                bargain_self_id: a.bargain_self_id
            },
            success: function(a) {
                var t = a.data;
                console.log(t.data), t.data.list && (WxParse.wxParse("article", "html", t.data.list.contents, n, 10), 
                n.setData({
                    list: t.data.list
                })), t.data.bargain_self && (n.countTime(t.data.list, t.data.bargain_self), n.setData({
                    bargain_self: t.data.bargain_self
                }), 1 == n.data.staus && n.setData({
                    staus: 2
                }), t.data.bargain_self_log && n.setData({
                    bargain_self_log: t.data.bargain_self_log
                }));
            }
        });
    },
    onReady: function() {
        app.look.navbar(this), app.look.accredit(this), app.look.goHome(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {
        console.log("onUnloadonUnloadonUnloadonUnloadonUnloadonUnloadonUnloadonUnloadonUnloadonUnloadonUnloadonUnloadonUnloadonUnload"), 
        clearInterval(this.data.interval);
    },
    onPullDownRefresh: function() {
        var n = this;
        app.look.istrue(n.data.options.staus) && n.setData({
            staus: n.data.options.staus
        }), n.setData({
            userinfo: app.globalData.userInfo
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "bargain_detail",
                id: n.data.options.id,
                bargain_self_id: n.data.ptions.bargain_self_id
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.list && n.setData({
                    list: t.data.list
                }), t.data.bargain_self && (n.countTime(t.data.list, t.data.bargain_self), n.setData({
                    bargain_self: t.data.bargain_self
                }), 1 == n.data.staus && n.setData({
                    staus: 2
                }), t.data.bargain_self_log && n.setData({
                    bargain_self_log: t.data.bargain_self_log
                }));
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function(a) {
        wx.showShareMenu({
            withShareTicket: !0
        });
        var t = this.data.list, n = "", o = "", i = "";
        return n = app.look.istrue(t.share.title) ? t.share.title : t.good_name, app.look.istrue(t.share.img) && (i = t.share.img), 
        a.from, o = this.data.bargain_self ? "../bargainDetail/bargainDetail?bargain_self_id=" + this.data.bargain_self.id + "&staus=3" : "../bargainDetail/bargainDetail?id=" + this.id + "&staus=1", 
        {
            title: n,
            path: "/xc_xinguwu/pages/base/base?share=" + (o = encodeURIComponent(o)) + "&userid=" + app.globalData.userInfo.id,
            imageUrl: i,
            success: function(a) {
                console.log(a), wx.showToast({
                    title: "转发成功"
                });
            },
            fail: function(a) {
                "";
            }
        };
    },
    countTime: function(a, t) {
        var n = new app.util.date(), o = 60 * a.time_range, i = n.dateToLong(new Date(app.look.change_date(t.createtime))), e = n.dateToLong(new Date());
        i = parseInt((i - e) / 1e3), i += o, this.countDown(i);
    },
    countDown: function(d) {
        var u = this;
        clearInterval(this.data.interval);
        var g = setInterval(function() {
            var a = d, t = Math.floor(a / 3600 / 24), n = t.toString();
            1 == n.length && (n = "0" + n);
            var o = Math.floor((a - 3600 * t * 24) / 3600), i = o.toString();
            1 == i.length && (i = "0" + i);
            var e = Math.floor(a / 3600).toString();
            1 == e.length && (e = "0" + e);
            var s = Math.floor((a - 3600 * t * 24 - 3600 * o) / 60), r = s.toString();
            1 == r.length && (r = "0" + r);
            var l = (a - 3600 * t * 24 - 3600 * o - 60 * s).toString();
            1 == l.length && (l = "0" + l), console.log(e), u.setData({
                countHour: e,
                countDownDay: n,
                countDownHour: i,
                countDownMinute: r,
                countDownSecond: l
            }), --d < 0 && (clearInterval(g), wx.showToast({
                title: "活动已结束"
            }), u.setData({
                countHour: "00",
                countDownDay: "00",
                countDownHour: "00",
                countDownMinute: "00",
                countDownSecond: "00"
            }));
        }.bind(u), 1e3);
        u.setData({
            interval: g
        });
    },
    onGotUserInfo: function(a) {
        app.look.getuserinfo(a, this);
    }
});