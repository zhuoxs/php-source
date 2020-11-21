var app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {
        num: 1,
        animationData: {},
        show_img: "",
        show_price: "",
        show_stock: 1e3,
        curIndex: 0
    },
    holdback: function() {},
    bindTap: function(t) {
        this.setData({
            curIndex: t.currentTarget.dataset.index
        });
    },
    toBuy: function() {
        1 == this.data.list.is_flash ? parseInt(this.data.list.sale) >= parseInt(this.data.list.limitnum) ? app.look.alert("已馨盘") : (this.setData({
            buytype: 1
        }), this.chooseSezi()) : app.look.alert("活动已结束");
    },
    toCar: function() {
        app.look.alert("暂不支持");
    },
    change: function(t) {
        var a = t.currentTarget.dataset.attr, i = this.data.list;
        if ("" == i.attrs[a].img) var e = i.bimg; else e = i.attrs[a].img;
        var o = i.attrs[a].sale, n = i.attrs[a].stock;
        this.setData({
            attr: a,
            num: 1,
            show_img: e,
            show_price: o,
            show_stock: n,
            sale: o
        });
    },
    addCount: function() {
        var t = this, a = t.data.num, i = t.data.show_stock;
        0 != t.data.list.limitsale && a + 1 > parseInt(t.data.list.limitsale) || parseInt(a + 1 + t.data.sale) > parseInt(t.data.limitnum) || parseInt(a + 1) > parseInt(i) || t.setData({
            num: a + 1,
            show_price: t.data.sale * (a + 1)
        });
    },
    minusCount: function() {
        1 != num && this.setData({
            num: num - 1,
            show_price: this.data.sale * (num - 1)
        });
    },
    share: function(t) {
        var a = this, i = wx.createAnimation({
            duration: 500,
            timingFunction: "linear"
        });
        (a.animation = i).translateY(100).step(), a.setData({
            animationData: i.export(),
            share: !0,
            show1: !0
        }), setTimeout(function() {
            i.translateY(0).step(), a.setData({
                animationData: i.export()
            });
        }, 200);
    },
    hideshare: function() {
        var t = this, a = wx.createAnimation({
            duration: 1e3,
            timingFunction: "linear"
        });
        (t.animation = a).translateY(100).step(), t.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.translateY(0).step(), t.setData({
                animationData: a.export(),
                share: !1,
                show1: !1
            });
        }, 200);
    },
    chooseSezi: function(t) {
        var a = this, i = wx.createAnimation({
            duration: 500,
            timingFunction: "linear"
        });
        (a.animation = i).translateY(100).step(), a.setData({
            animationData1: i.export(),
            chooseSize: !0,
            show2: !0
        }), setTimeout(function() {
            i.translateY(0).step(), a.setData({
                animationData1: i.export()
            });
        }, 200);
    },
    hideModal: function(t) {
        var a = this, i = wx.createAnimation({
            duration: 1e3,
            timingFunction: "linear"
        });
        (a.animation = i).translateY(100).step(), a.setData({
            animationData1: i.export()
        }), setTimeout(function() {
            i.translateY(0).step(), a.setData({
                animationData1: i.export(),
                chooseSize: !1,
                show2: !1
            });
        }, 200);
    },
    confirm: function() {
        if (this.data.attr) {
            this.hideModal();
            var t = this, a = this.data.list, i = [];
            i.push({
                id: a.id,
                img: a.bimg,
                num: t.data.num,
                price: a.attrs[t.data.attr].sale,
                name: a.name,
                attr: t.data.attr,
                attr_name: a.attr_name,
                weight: a.weight
            });
            var e = [];
            e = {
                content: i,
                totalPrice: t.data.show_price,
                totalNum: t.data.num,
                cid: 6,
                flashid: a.flash_id
            }, e = JSON.stringify(e);
            var o = "../submit/submit?order=" + (e = encodeURIComponent(e));
            wx.navigateTo({
                url: o
            });
        } else app.look.alert("请选择属性");
    },
    toindex: function() {
        wx.reLaunch({
            url: "../index/index"
        });
    },
    hidesc: function() {
        this.setData({
            shengc: !1,
            show2: !1,
            show1: !1
        });
    },
    settimedown: function(t) {
        console.log("nn"), console.log(t);
        var a = new app.util.date(), i = a.dateToLong(new Date()), e = t.date_end;
        e = a.dateToLong(new Date(app.look.change_date(e))), e = Math.floor((e - i) / 1e3), 
        this.countDown(e);
    },
    onLoad: function(c) {
        var u = this;
        console.log(c), u.setData({
            options: c
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "limitdetail",
                id: c.id
            },
            success: function(t) {
                var a = t.data;
                if (console.log("hhhs"), console.log(a.data.list), a.data.list) {
                    WxParse.wxParse("article", "html", a.data.list.contents, u, 10), u.settimedown(a.data.list);
                    var i = a.data.list, e = {
                        list: i,
                        id: c.id,
                        show_img: i.bimg,
                        show_price: i.prices
                    };
                    if (i.attrs) {
                        var o = Object.keys(i.attrs)[0];
                        e.attr = o;
                        var n = "";
                        n = "" == i.attrs[o].img ? i.bimg : i.attrs[o].img;
                        var s = i.attrs[o].sale, r = i.attrs[o].stock;
                        e.num = 1, e.show_img = n, e.show_stock = r, e.sale = s;
                    }
                    u.setData(e);
                    var l = {
                        currentTarget: {
                            dataset: {
                                attr: e.attr
                            }
                        }
                    };
                    u.change(l);
                }
            }
        });
    },
    onReady: function() {
        app.look.navbar(this), app.look.accredit(this), app.look.goHome(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "limitdetail",
                id: i.data.options.id
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var a = t.data;
                a.data.list && (i.settimedown(a.data.list), i.setData({
                    list: a.data.list,
                    show_img: a.data.list.bimg,
                    show_price: a.data.list.prices
                }));
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {
        this.setData({
            share: !1,
            show1: !1
        }), wx.showShareMenu({
            withShareTicket: !0
        });
        var t = this.data.list.id, a = "", i = "";
        a = app.look.istrue(this.data.list.share.title) ? this.data.list.share.title : this.data.list.name, 
        app.look.istrue(this.data.list.share.img) && (i = this.data.list.share.img);
        var e = "../limitDetail/limitDetail?id=" + t;
        return {
            title: a,
            path: "/xc_xinguwu/pages/base/base?share=" + (e = encodeURIComponent(e)) + "&userid=" + app.globalData.userInfo.id,
            imageUrl: i,
            success: function(t) {
                wx.showToast({
                    title: "转发成功"
                });
            },
            fail: function(t) {}
        };
    },
    shengcheng: function() {
        var a = this, t = this.data.list;
        console.log(t), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            method: "POST",
            data: {
                op: "limitdetail_poster",
                good_img: t.bimg,
                good_name: t.name,
                old_price: t.oprice,
                price: t.prices,
                id: t.id
            },
            success: function(t) {
                wx.hideLoading(), a.setData({
                    poster: t.data.data,
                    shengc: !0,
                    share: !1
                });
            }
        });
    },
    saveImageToPhotosAlbum: function() {
        wx.downloadFile({
            url: this.data.poster,
            success: function(t) {
                var a = t.tempFilePath;
                wx.authorize({
                    scope: "scope.writePhotosAlbum",
                    success: function(t) {
                        wx.saveImageToPhotosAlbum({
                            filePath: a,
                            success: function(t) {
                                app.look.alert("保存成功");
                            },
                            fail: function(t) {
                                "saveImageToPhotosAlbum:fail auth deny" === t.errMsg && wx.openSetting({
                                    success: function(t) {}
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    countDown: function(c) {
        var u = this;
        clearInterval(this.data.interval);
        var h = setInterval(function() {
            var t = c, a = Math.floor(t / 3600 / 24), i = a.toString();
            1 == i.length && (i = "0" + i);
            var e = Math.floor((t - 3600 * a * 24) / 3600), o = e.toString();
            1 == o.length && (o = "0" + o);
            var n = Math.floor(t / 3600).toString();
            1 == n.length && (n = "0" + n);
            var s = Math.floor((t - 3600 * a * 24 - 3600 * e) / 60), r = s.toString();
            1 == r.length && (r = "0" + r);
            var l = (t - 3600 * a * 24 - 3600 * e - 60 * s).toString();
            1 == l.length && (l = "0" + l), u.setData({
                countHour: n,
                countDownDay: i,
                countDownHour: o,
                countDownMinute: r,
                countDownSecond: l
            }), --c < 0 && (clearInterval(h), wx.showToast({
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
            interval: h
        });
    },
    previewImage_poster: function() {
        wx.previewImage({
            urls: [ this.data.poster ]
        });
    },
    onGotUserInfo: function(t) {
        app.look.getuserinfo(t, this);
    }
});