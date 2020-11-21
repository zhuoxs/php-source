var weekday = [ "周日", "周一", "周二", "周三", "周四", "周五", "周六" ], minutes = [ "00", "30" ], hours = [ "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23" ], myDate = new Date(), hh = myDate.getHours();

++hh;

for (var dateTemp, time1, dateArrays = [], time = [], c = [], flag = 1, i = 0; i < 7; i++) {
    var m = "", d = "";
    dateTemp = (m = myDate.getMonth() + 1 < 10 ? "0" + (myDate.getMonth() + 1) : myDate.getMonth() + 1) + "月" + (d = myDate.getDate() < 10 ? "0" + myDate.getDate() : myDate.getDate()) + "日 " + weekday[myDate.getDay()], 
    dateArrays.push(dateTemp), time1 = m + "-" + d, time.push(time1), myDate.setDate(myDate.getDate() + flag);
}

var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        dateArrays: dateArrays,
        dateArray: dateArrays[0],
        hours: hours,
        hour: hours[0],
        nowhour: hh,
        minutes: minutes,
        minute: minutes[0],
        time: time,
        time1: time[0],
        type1: 1,
        total: "0.00",
        typeIndex: 0,
        palyBtn: !1,
        typeList: [ "直接送礼", "定时开奖", "满人开奖" ],
        gift: []
    },
    onLoad: function(t) {
        var a, e = this;
        e.setData({
            gift: [],
            giftNumTotal: 0
        }), a = wx.getStorageSync("shopcart"), e.setData({
            gift: a,
            giftNumTotal: a.num
        }), e.getUrl(), e.calculation();
        this.data.isLogin;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(t) {
                        e.setData({
                            isLogin: !1,
                            userInfo: t.userInfo
                        });
                    }
                });
            }
        }) : e.setData({
            isLogin: !0
        });
    },
    bindGetUserInfo: function(t) {
        var e = this;
        wx.setStorageSync("user_info", t.detail.userInfo);
        var i = t.detail.userInfo.nickName, n = t.detail.userInfo.avatarUrl;
        wx.login({
            success: function(t) {
                var a = t.code;
                console.log(a), app.util.request({
                    url: "entry/wxapp/openid",
                    cachetime: "0",
                    data: {
                        code: a
                    },
                    success: function(t) {
                        console.log(t), wx.setStorageSync("key", t.data.session_key), wx.setStorageSync("openid", t.data.openid);
                        var a = t.data.openid;
                        app.util.request({
                            url: "entry/wxapp/Login",
                            cachetime: "0",
                            data: {
                                openid: a,
                                img: n,
                                name: i
                            },
                            success: function(t) {
                                console.log(t), e.setData({
                                    isLogin: !1
                                }), wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid);
                            }
                        });
                    }
                });
            }
        });
    },
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        var a = this, e = a.data.gid;
        return console.log(e), "button" === t.from && console.log(t.target), {
            title: a.data.userInfo.nickName + "赠送您[" + a.data.gift.name + "] 礼品了！",
            path: "/yzcj_sun/pages/gift/giftorder/giftorder?gid=" + e,
            success: function(t) {},
            fail: function(t) {}
        };
    },
    opendPlay: function() {
        this.setData({
            palyBtn: !0
        });
    },
    closePlay: function() {
        this.setData({
            palyBtn: !1
        });
    },
    changeType: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            typeIndex: a,
            palyBtn: !1
        });
    },
    bindKeyInput4: function(t) {
        this.setData({
            inputValue4: t.detail.value
        });
    },
    bindKeyInput5: function(t) {
        var a = this.data.inputValue5show;
        a = 0 == t.detail.value.length, this.setData({
            inputValue5: t.detail.value.length,
            inputValue5show: a,
            accurate: t.detail.value
        });
    },
    bindChange: function(t) {
        var a = t.detail.value, e = t.detail.value[1], i = this.data.inputValue6show;
        i = e < this.data.nowhour && 0 == t.detail.value[0], this.setData({
            dateArray: this.data.dateArrays[a[0]],
            hour: this.data.hours[a[1]],
            minute: this.data.minutes[a[2]],
            inputValue6show: i,
            time1: this.data.time[a[0]],
            choosehour: e
        });
    },
    choosetime: function(t) {
        var a = this.data.showtime;
        a = !a, this.setData({
            showtime: a
        });
    },
    goGiftlist: function() {
        wx.navigateTo({
            url: "../giftlist/giftlist"
        });
    },
    changSeeAll: function() {
        this.setData({
            seeAll: !0
        });
    },
    count: function(t) {
        var a = this, e = t.detail.value, i = a.data.gift.count;
        "" == e ? a.setData({
            giftNumTotal: 0
        }) : Number(e) > Number(i) ? a.setData({
            giftNumTotal: i
        }) : a.setData({
            giftNumTotal: e
        }), a.calculation();
    },
    addnum: function(t) {
        var a = this, e = a.data.gift, i = (i = a.data.giftNumTotal) + 1;
        Number(i) > Number(e.count) ? a.setData({
            giftNumTotal: e.count
        }) : (console.log(Number(i)), a.setData({
            giftNumTotal: i
        })), wx.setStorageSync("shopcart", e), a.calculation();
    },
    subbnum: function(t) {
        var a = this, e = a.data.gift, i = a.data.giftNumTotal;
        1 == i ? wx.showModal({
            title: "提示",
            content: "确定删除?",
            success: function(t) {
                t.confirm && (wx.removeStorageSync("shopcart"), i -= 1, a.setData({
                    gift: [],
                    giftNumTotal: i
                }), a.calculation());
            }
        }) : (i -= 1, a.setData({
            giftNumTotal: i
        }), wx.setStorageSync("shopcart", e), a.calculation());
    },
    calculation: function() {
        var t = this.data.gift, a = 0, e = Number(t.price);
        e && (a += e * this.data.giftNumTotal), a = a.toFixed(2), this.setData({
            total: a
        });
    },
    gohome: function() {
        wx.reLaunch({
            url: "../../ticket/ticketmiannew/ticketmiannew"
        });
    },
    goTicketdetail: function(t) {
        var a = this, e = a.data.inputValue5show;
        e = 0 == a.data.inputValue5, this.setData({
            inputValue5show: e
        });
        var i = wx.getStorageSync("users").openid, n = a.data.gift.id;
        if (0 == a.data.typeIndex) {
            if (a.data.gift) {
                var o = a.data.total, u = 3, s = 4, c = a.data.gift.name, r = a.data.giftNumTotal, d = a.data.gift.imgSrc, l = "直接送礼", g = a.data.inputValue4;
                app.util.request({
                    url: "entry/wxapp/getGift",
                    data: {
                        giftId: n,
                        count: r
                    },
                    success: function(t) {
                        console.log(t), 1 == t.data.num ? (wx.showToast({
                            title: "库存不足，购买失败",
                            icon: "none",
                            duration: 2e3
                        }), a.setData({
                            gift: t.data.gift,
                            giftNumTotal: t.data.gift.count
                        }), a.calculation()) : app.util.request({
                            url: "entry/wxapp/Orderarr",
                            cachetime: "30",
                            data: {
                                openid: i,
                                price: o
                            },
                            success: function(t) {
                                wx.requestPayment({
                                    timeStamp: t.data.timeStamp,
                                    nonceStr: t.data.nonceStr,
                                    package: t.data.package,
                                    signType: "MD5",
                                    paySign: t.data.paySign,
                                    success: function(t) {
                                        wx.showToast({
                                            title: "支付成功",
                                            icon: "success",
                                            duration: 2e3
                                        }), app.util.request({
                                            url: "entry/wxapp/AddGift",
                                            data: {
                                                awardtype: u,
                                                index: s,
                                                gName: c,
                                                count: r,
                                                imgSrc: d,
                                                accurate: l,
                                                openid: i,
                                                status: 4,
                                                lottery: g,
                                                giftId: n,
                                                price: o
                                            },
                                            success: function(t) {
                                                a.setData({
                                                    type1: 2,
                                                    gid: t.data
                                                }), console.log(a.data.gid);
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        } else if (1 == a.data.typeIndex) {
            if (a.data.gift) {
                u = 3, s = 0, c = a.data.gift.name, r = a.data.giftNumTotal, d = a.data.gift.imgSrc, 
                g = a.data.inputValue4;
                if (null == a.data.choosehour) var p = myDate.getFullYear() + "-" + a.data.time1 + " " + a.data.nowhour + ":" + a.data.minute + ":00"; else p = myDate.getFullYear() + "-" + a.data.time1 + " " + a.data.choosehour + ":" + a.data.minute + ":00";
                o = a.data.total;
                app.util.request({
                    url: "entry/wxapp/getGift",
                    data: {
                        giftId: n,
                        count: r
                    },
                    success: function(t) {
                        console.log(t), 1 == t.data.num ? (wx.showToast({
                            title: "库存不足，购买失败",
                            icon: "none",
                            duration: 2e3
                        }), a.setData({
                            gift: t.data.gift,
                            giftNumTotal: t.data.gift.count
                        }), a.calculation()) : app.util.request({
                            url: "entry/wxapp/Orderarr",
                            cachetime: "30",
                            data: {
                                openid: i,
                                price: o
                            },
                            success: function(t) {
                                wx.requestPayment({
                                    timeStamp: t.data.timeStamp,
                                    nonceStr: t.data.nonceStr,
                                    package: t.data.package,
                                    signType: "MD5",
                                    paySign: t.data.paySign,
                                    success: function(t) {
                                        wx.showToast({
                                            title: "支付成功",
                                            icon: "success",
                                            duration: 2e3
                                        }), app.util.request({
                                            url: "entry/wxapp/AddGift",
                                            data: {
                                                awardtype: u,
                                                index: s,
                                                gName: c,
                                                count: r,
                                                imgSrc: d,
                                                accurate: p,
                                                openid: i,
                                                status: 2,
                                                lottery: g,
                                                giftId: n,
                                                price: o
                                            },
                                            success: function(t) {
                                                console.log(t.data), wx.removeStorageSync("shopcart"), wx.reLaunch({
                                                    url: "../../ticket/ticketdetail/ticketdetail?gid=" + t.data
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        } else if (2 == a.data.typeIndex && !e && a.data.gift) {
            o = a.data.total, u = 3, s = 1, c = a.data.gift.name, r = a.data.giftNumTotal, d = a.data.gift.imgSrc, 
            l = a.data.accurate, g = a.data.inputValue4;
            app.util.request({
                url: "entry/wxapp/getGift",
                data: {
                    giftId: n,
                    count: r
                },
                success: function(t) {
                    console.log(t), 1 == t.data.num ? (wx.showToast({
                        title: "库存不足，购买失败",
                        icon: "none",
                        duration: 2e3
                    }), a.setData({
                        gift: t.data.gift,
                        giftNumTotal: t.data.gift.count
                    }), a.calculation()) : app.util.request({
                        url: "entry/wxapp/Orderarr",
                        cachetime: "30",
                        data: {
                            openid: i,
                            price: o
                        },
                        success: function(t) {
                            wx.requestPayment({
                                timeStamp: t.data.timeStamp,
                                nonceStr: t.data.nonceStr,
                                package: t.data.package,
                                signType: "MD5",
                                paySign: t.data.paySign,
                                success: function(t) {
                                    wx.showToast({
                                        title: "支付成功",
                                        icon: "success",
                                        duration: 2e3
                                    }), app.util.request({
                                        url: "entry/wxapp/AddGift",
                                        data: {
                                            awardtype: u,
                                            index: s,
                                            gName: c,
                                            count: r,
                                            imgSrc: d,
                                            accurate: l,
                                            openid: i,
                                            status: 2,
                                            lottery: g,
                                            giftId: n,
                                            price: o
                                        },
                                        success: function(t) {
                                            console.log(t.data), wx.removeStorageSync("shopcart"), wx.reLaunch({
                                                url: "../../ticket/ticketdetail/ticketdetail?gid=" + t.data
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            });
        }
    }
});