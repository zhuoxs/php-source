var weekday = [ "周日", "周一", "周二", "周三", "周四", "周五", "周六" ], minutes = [ "00", "30" ], hours = [ "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23" ], myDate = new Date(), hh = myDate.getHours();

++hh;

for (var dateTemp, time1, mm = myDate.getMinutes(), dateArrays = [], time = [], c = [], flag = 1, i = 0; i < 7; i++) {
    var m = "", d = "";
    dateTemp = (m = myDate.getMonth() + 1 < 10 ? "0" + (myDate.getMonth() + 1) : myDate.getMonth() + 1) + "月" + (d = myDate.getDate() < 10 ? "0" + myDate.getDate() : myDate.getDate()) + "日 " + weekday[myDate.getDay()], 
    dateArrays.push(dateTemp), time1 = m + "-" + d, time.push(time1), myDate.setDate(myDate.getDate() + flag);
}

var app = getApp(), Page = require("../../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        showtime: !1,
        showpaly: !1,
        index: 0,
        palylist: [ "按时间自动开奖", "按人数自动开奖", "手动开奖" ],
        dateArrays: dateArrays,
        time: time,
        time1: time[0],
        dateArray: dateArrays[0],
        hours: hours,
        hour: hours[0],
        nowhour: hh,
        nowmm: 30 < mm ? 1 : 0,
        minutes: minutes,
        minute: minutes[0],
        team: [ 2, 4, 6, 8 ],
        pics: [],
        imgSrc: "",
        pic: "",
        inputValue5show: !1,
        can: !0,
        third: 0
    },
    onLoad: function(a) {
        console.log(a.price1), console.log(a.price2);
        var t = this;
        t.setData({
            rad: a.rad ? a.rad : "",
            rad2: a.rad2 ? a.rad2 : "",
            num: 2 == a.rad ? 2 : "",
            price2: a.price2,
            price1: a.price1
        });
        var e = a.avatar;
        if (e) {
            var n = app.util.url("entry/wxapp/Toupload") + "&m=yzcj_sun";
            wx.uploadFile({
                url: n,
                filePath: e,
                name: "file",
                success: function(a) {
                    console.log(a), t.setData({});
                }
            }), this.setData({
                imgSrc: e
            });
        }
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                wx.setStorageSync("url", a.data), t.setData({
                    url: a.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        console.log("重置啦");
        var t = this;
        app.util.request({
            url: "entry/wxapp/Getseniorpage",
            success: function(a) {
                console.log(a), t.setData({
                    tz_audit: a.data.tz_audit,
                    is_car: a.data.is_car,
                    status: a.data.is_sjrz,
                    cjzt: a.data.cjzt,
                    cjzt1: a.data.cjzt ? t.data.url + "/" + a.data.cjzt : "../../../../resource/images/banner.jpg",
                    day: a.data.is_open_pop
                });
            }
        });
        var a = new Date();
        console.log(a);
        var e = a.getHours(), n = a.getMinutes();
        ++e;
        for (var o, i, r = [], s = [], u = 0; u < 7; u++) {
            var d = "", c = "";
            o = (d = a.getMonth() + 1 < 10 ? "0" + (a.getMonth() + 1) : a.getMonth() + 1) + "月" + (c = a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + "日 " + weekday[a.getDay()], 
            r.push(o), i = d + "-" + c, s.push(i), a.setDate(a.getDate() + 1);
        }
        t.setData({
            dateArrays: r,
            time: s,
            time1: wx.getStorageSync("time1") ? wx.getStorageSync("time1") : s[0],
            dateArray: wx.getStorageSync("dateArray") ? wx.getStorageSync("dateArray") : r[0],
            hours: hours,
            hour: wx.getStorageSync("hour") ? wx.getStorageSync("hour") : hours[0],
            nowhour: e,
            nowmm: 30 < n ? 1 : 0,
            minutes: minutes,
            minute: wx.getStorageSync("minute") ? wx.getStorageSync("minute") : minutes[0]
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindKeyInput1: function(a) {
        var t = this, e = t.data.inputValue1show, n = a.currentTarget.dataset.id;
        0 == a.detail.value || 1024 < a.detail.value ? e = !0 : (e = !1, 1 == n && t.setData({
            firstValue: a.detail.value
        }), 2 == n && t.setData({
            secondValue: a.detail.value
        }), 3 == n && t.setData({
            thirdValue: a.detail.value
        })), t.setData({
            inputValue1show: e
        });
    },
    bindkeys: function(a) {
        var t = this, e = a.currentTarget.dataset.id;
        console.log(e), 1 == e && (console.log(222222), t.setData({
            first: a.detail.value
        })), 2 == e && t.setData({
            second: a.detail.value
        }), 3 == e && (console.log(1111111), t.setData({
            third: a.detail.value
        }));
    },
    inputValueBase: function(a) {
        var t = this.data.inputValue1base;
        0 == a.detail.value.length ? t = !0 : (t = !1, this.setData({
            baseName: a.detail.value
        })), this.setData({
            inputValue1base: t
        });
    },
    bindKeyInput1Base: function(a) {
        var t = this.data.inputValue1base;
        a.detail.value <= 0 || 1024 < a.detail.value ? t = !0 : (t = !1, this.setData({
            baseNum: a.detail.value
        })), this.setData({
            inputValue1base: t
        });
    },
    bindKeyInput4: function(a) {
        var t = this.data.inputValue4show;
        a.detail.value <= 0 || 1024 < a.detail.value || 20 < a.detail.value.length ? t = !0 : (t = !1, 
        this.setData({
            code: a.detail.value
        })), this.setData({
            inputValue4show: t
        });
    },
    bindKeyInput4all: function(a) {
        var t = this.data.inputValue4show;
        a.detail.value <= 0 || 1024 < a.detail.value || 20 < a.detail.value.length ? t = !0 : (t = !1, 
        this.setData({
            codeAll: a.detail.value
        })), this.setData({
            inputValue4show: t
        });
    },
    bindKeyInput3: function(a) {
        var t = this.data.inputValue3show;
        "" == a.detail.value || 200 < a.detail.value ? t = !0 : (t = !1, this.setData({
            payment: a.detail.value
        })), this.setData({
            inputValue3show: t
        });
    },
    bindKeyInputOrder: function(a) {
        var t = this.data.inputValueOrder;
        0 == a.detail.value.lenbgth || 20 < a.detail.value.length ? t = !0 : (t = !1, this.setData({
            order: a.detail.value
        })), this.setData({
            inputValueOrder: t
        });
    },
    chooselotterytime: function() {
        this.data.showpaly;
        this.setData({
            showpaly: !0
        });
    },
    closeplay: function(a) {
        this.data.showpaly;
        var t = a.currentTarget.dataset.index;
        this.setData({
            showpaly: !1,
            index: t
        });
    },
    choosetime: function(a) {
        var t = this.data.showtime;
        t = !t, this.setData({
            showtime: t
        });
    },
    bindChange: function(a) {
        var t = this, e = a.detail.value, n = a.detail.value[1], o = t.data.inputValue6show, i = a.detail.value[2];
        console.log(a), 0 == a.detail.value[0] && (n < t.data.nowhour - 1 && (o = !0), n == t.data.nowhour - 1 && (o = i <= t.data.nowmm)), 
        0 < a.detail.value[0] && (o = !1), n > t.data.nowhour - 1 && (o = !1), this.setData({
            dateArray: this.data.dateArrays[e[0]],
            time1: this.data.time[e[0]],
            choosehour: n,
            hour: this.data.hours[e[1]],
            minute: this.data.minutes[e[2]],
            inputValue6show: o,
            data_day: a.detail.value[0]
        }), wx.setStorageSync("hour", this.data.hours[e[1]]), wx.setStorageSync("minute", this.data.minutes[e[2]]), 
        wx.setStorageSync("dateArray", this.data.dateArrays[e[0]]), wx.setStorageSync("time1", this.data.time[e[0]]);
    },
    bindKeyInput5: function(a) {
        var t = this.data.inputValue5show;
        t = 0 == a.detail.value.length, this.setData({
            inputValue5show: t,
            accurate: a.detail.value
        });
    },
    upload: function() {
        var e = this.data.rad, n = this.data.rad2, o = this.data.price1, i = this.data.price2;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var t = a.tempFilePaths[0];
                wx.navigateTo({
                    url: "../../upimg/upimg?src=" + t + "&rad=" + e + "&rad2=" + n + "&price1=" + o + "&price2=" + i
                });
            }
        });
    },
    chooseTeam: function(a) {
        var t = a.currentTarget.dataset.num;
        this.setData({
            num: t
        });
    },
    chooseImages: function() {
        var t = this, e = t.data.pics;
        console.log(e), e.length < 9 ? wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                e = e.concat(a.tempFilePaths), console.log(11111111), t.setData({
                    pics: e
                });
            }
        }) : wx.showToast({
            title: "只允许上传9张图片！！！",
            icon: "none"
        });
    },
    uploadimg: function(a, t) {
        var e = this, n = a.i ? a.i : 0, o = a.success ? a.success : 0, i = a.fail ? a.fail : 0;
        console.log(JSON.stringify(t) + "这是上传图片事件参数"), console.log(a.path + "进入上传图片"), console.log(a.url), 
        wx.uploadFile({
            url: a.url,
            filePath: a.path[n],
            name: "file",
            formData: t,
            success: function(a) {
                1 == a.data && o++, console.log("tu11111111"), console.log(a), console.log(n);
            },
            fail: function(a) {
                2 == a.data && i++, console.log("fail:" + n + "fail:" + i);
            },
            complete: function() {
                ++n == a.path.length ? (console.log("执行完毕"), wx.hideLoading(), wx.showToast({
                    title: "发布成功！！！",
                    icon: "success",
                    success: function() {
                        e.setData({
                            pics: [],
                            content: "",
                            disabled: !1,
                            sendtitle: "发送"
                        }), app.globalData.aci = "", wx.reLaunch({
                            url: "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + t.id
                        });
                    }
                })) : (a.i = n, a.success = o, a.fail = i, e.uploadimg(a, t));
            }
        });
    },
    goTicketdetail: function(a) {
        var n = this, t = n.data.rad, e = n.data.rad2, o = n.data.inputValue1base, i = n.data.baseNum, r = n.data.baseName, s = n.data.inputValue1show, u = n.data.first, d = n.data.second, c = n.data.third, l = n.data.firstValue, p = n.data.secondValue, m = n.data.thirdValue, g = n.data.inputValue3show, y = n.data.payment, h = n.data.inputValue4show, w = n.data.code, S = n.data.codeAll, x = n.data.orderway, v = n.data.inputValueOrder, f = n.data.order, D = n.data.num, k = n.data.pics, T = app.util.url("entry/wxapp/Toupload2") + "&m=yzcj_sun", V = wx.getStorageSync("users").openid, q = n.data.index, z = n.data.accurate, b = n.data.inputValue5show, P = (n.data.price2, 
        n.data.price1, parseFloat(n.data.price1) + parseFloat(n.data.price2)), A = n.data.can, _ = n.data.pic, j = this.data.lottery;
        if (console.log(w), null == n.data.choosehour) var M = myDate.getFullYear() + "-" + n.data.time1 + " " + n.data.nowhour + ":" + n.data.minute + ":00"; else M = myDate.getFullYear() + "-" + n.data.time1 + " " + n.data.choosehour + ":" + n.data.minute + ":00";
        if (o || s || g || h || v || b || !A) return console.log("eeee"), wx.showToast({
            title: "信息填写不完整",
            icon: "none",
            duration: 2e3
        }), n.setData({
            can: !0
        }), !1;
        n.setData({
            can: !1
        }), 0 == e && 0 <= t && i && r && (0 != q ? 1 == q ? z : q : M) ? y ? app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                openid: V,
                price: P
            },
            success: function(a) {
                wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: "MD5",
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/addSeniorPro",
                            data: 0 == q ? {
                                paidprice: y,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                accurate: M,
                                openid: V,
                                imgSrc: _,
                                gName: r,
                                count: i,
                                lottery: j
                            } : 1 == q ? {
                                paidprice: y,
                                status: n.data.status,
                                awardtype: 1,
                                accurate: z,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                gName: r,
                                count: i,
                                lottery: j
                            } : {
                                paidprice: y,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                gName: r,
                                count: i,
                                lottery: j
                            },
                            success: function(a) {
                                var t = a.data;
                                if (wx.removeStorageSync("hour"), wx.removeStorageSync("minute"), wx.removeStorageSync("time1"), 
                                wx.removeStorageSync("dataArray"), a.data && 0 < k.length) {
                                    var e = {
                                        id: a.data
                                    };
                                    n.uploadimg({
                                        url: T,
                                        path: k
                                    }, e);
                                } else wx.reLaunch({
                                    url: "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + t
                                });
                            }
                        });
                    },
                    fail: function() {
                        wx.showToast({
                            title: "支付失败",
                            icon: "none",
                            duration: 2e3
                        }), n.setData({
                            can: !0
                        });
                    }
                });
            }
        }) : w && S && x ? app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                openid: V,
                price: P
            },
            success: function(a) {
                wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: "MD5",
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/addSeniorPro",
                            data: 0 == q ? {
                                codenum: S,
                                codemost: w,
                                codeway: x,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                accurate: M,
                                openid: V,
                                imgSrc: _,
                                gName: r,
                                count: i,
                                lottery: j
                            } : 1 == q ? {
                                codenum: S,
                                codemost: w,
                                codeway: x,
                                status: n.data.status,
                                awardtype: 1,
                                accurate: z,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                gName: r,
                                count: i,
                                lottery: j
                            } : {
                                codenum: S,
                                codemost: w,
                                codeway: x,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                gName: r,
                                count: i,
                                lottery: j
                            },
                            success: function(a) {
                                var t = a.data;
                                if (wx.removeStorageSync("hour"), wx.removeStorageSync("minute"), wx.removeStorageSync("time1"), 
                                wx.removeStorageSync("dataArray"), a.data && 0 < k.length) {
                                    var e = {
                                        id: a.data
                                    };
                                    n.uploadimg({
                                        url: T,
                                        path: k
                                    }, e);
                                } else wx.reLaunch({
                                    url: "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + t
                                });
                            }
                        });
                    },
                    fail: function() {
                        wx.showToast({
                            title: "支付失败",
                            icon: "none",
                            duration: 2e3
                        }), n.setData({
                            can: !0
                        });
                    }
                });
            }
        }) : f ? app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                openid: V,
                price: P
            },
            success: function(a) {
                wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: "MD5",
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/addSeniorPro",
                            data: 0 == q ? {
                                password: f,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                accurate: M,
                                openid: V,
                                imgSrc: _,
                                gName: r,
                                count: i,
                                lottery: j
                            } : 1 == q ? {
                                password: f,
                                status: n.data.status,
                                awardtype: 1,
                                accurate: z,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                gName: r,
                                count: i,
                                lottery: j
                            } : {
                                password: f,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                gName: r,
                                count: i,
                                lottery: j
                            },
                            success: function(a) {
                                var t = a.data;
                                if (wx.removeStorageSync("hour"), wx.removeStorageSync("minute"), wx.removeStorageSync("time1"), 
                                wx.removeStorageSync("dataArray"), a.data && 0 < k.length) {
                                    var e = {
                                        id: a.data
                                    };
                                    n.uploadimg({
                                        url: T,
                                        path: k
                                    }, e);
                                } else wx.reLaunch({
                                    url: "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + t
                                });
                            }
                        });
                    },
                    fail: function() {
                        wx.showToast({
                            title: "支付失败",
                            icon: "none",
                            duration: 2e3
                        }), n.setData({
                            can: !0
                        });
                    }
                });
            }
        }) : D ? (console.log("num" + D), app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                openid: V,
                price: P
            },
            success: function(a) {
                wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: "MD5",
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/addSeniorPro",
                            data: 0 == q ? {
                                group: D,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                accurate: M,
                                openid: V,
                                imgSrc: _,
                                gName: r,
                                count: i,
                                lottery: j
                            } : 1 == q ? {
                                group: D,
                                num: D,
                                status: n.data.status,
                                awardtype: 1,
                                accurate: z,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                gName: r,
                                count: i,
                                lottery: j
                            } : {
                                group: D,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                gName: r,
                                count: i,
                                lottery: j
                            },
                            success: function(a) {
                                var t = a.data;
                                if (wx.removeStorageSync("hour"), wx.removeStorageSync("minute"), wx.removeStorageSync("time1"), 
                                wx.removeStorageSync("dataArray"), a.data && 0 < k.length) {
                                    var e = {
                                        id: a.data
                                    };
                                    n.uploadimg({
                                        url: T,
                                        path: k
                                    }, e);
                                } else wx.reLaunch({
                                    url: "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + t
                                });
                            }
                        });
                    },
                    fail: function() {
                        wx.showToast({
                            title: "支付失败",
                            icon: "none",
                            duration: 2e3
                        }), n.setData({
                            can: !0
                        });
                    }
                });
            }
        })) : (console.log("aaa"), wx.showToast({
            title: "信息填写不完整",
            icon: "none",
            duration: 2e3
        })) : 0 != e && -1 == t && (0 != q ? 1 == q ? z : q : M) ? (console.log(33333), 
        u && d && l && p ? app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                openid: V,
                price: P
            },
            success: function(a) {
                wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: "MD5",
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/addSeniorPro",
                            data: 0 == q ? {
                                one: 1,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                accurate: M,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            } : 1 == q ? {
                                one: 1,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                status: n.data.status,
                                awardtype: 1,
                                accurate: z,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            } : {
                                one: 1,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            },
                            success: function(a) {
                                var t = a.data;
                                if (wx.removeStorageSync("hour"), wx.removeStorageSync("minute"), wx.removeStorageSync("time1"), 
                                wx.removeStorageSync("dataArray"), a.data && 0 < k.length) {
                                    var e = {
                                        id: a.data
                                    };
                                    n.uploadimg({
                                        url: T,
                                        path: k
                                    }, e);
                                } else wx.reLaunch({
                                    url: "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + t
                                });
                            }
                        });
                    },
                    fail: function() {
                        wx.showToast({
                            title: "支付失败",
                            icon: "none",
                            duration: 2e3
                        }), n.setData({
                            can: !0
                        });
                    }
                });
            }
        }) : (console.log("bbbb"), wx.showToast({
            title: "信息填写不完整",
            icon: "none",
            duration: 2e3
        }))) : 0 != e && 0 <= t && (0 != q ? 1 == q ? z : q : M) ? (console.log(4444444), 
        u && d && l && p && D ? (console.log("组团加一二三"), console.log(P), app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                openid: V,
                price: P
            },
            success: function(a) {
                wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: "MD5",
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/addSeniorPro",
                            data: 0 == q ? {
                                one: 1,
                                group: D,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                num: D,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                accurate: M,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            } : 1 == q ? {
                                one: 1,
                                group: D,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                num: D,
                                status: n.data.status,
                                awardtype: 1,
                                accurate: z,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            } : {
                                one: 1,
                                group: D,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                num: D,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            },
                            success: function(a) {
                                var t = a.data;
                                if (wx.removeStorageSync("hour"), wx.removeStorageSync("minute"), wx.removeStorageSync("time1"), 
                                wx.removeStorageSync("dataArray"), a.data && 0 < k.length) {
                                    var e = {
                                        id: a.data
                                    };
                                    n.uploadimg({
                                        url: T,
                                        path: k
                                    }, e);
                                } else wx.reLaunch({
                                    url: "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + t
                                });
                            }
                        });
                    },
                    fail: function() {
                        wx.showToast({
                            title: "支付失败",
                            icon: "none",
                            duration: 2e3
                        }), n.setData({
                            can: !0
                        });
                    }
                });
            }
        })) : u && d && l && p && w && S && x ? (console.log("抽奖码加一二三"), console.log(P), 
        app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                openid: V,
                price: P
            },
            success: function(a) {
                console.log("zzzzzzzz"), wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: "MD5",
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/addSeniorPro",
                            data: 0 == q ? {
                                one: 1,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                codenum: S,
                                codemost: w,
                                codeway: x,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                accurate: M,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            } : 1 == q ? {
                                one: 1,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                codenum: S,
                                codemost: w,
                                codeway: x,
                                status: n.data.status,
                                awardtype: 1,
                                accurate: z,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            } : {
                                one: 1,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                codenum: S,
                                codemost: w,
                                codeway: x,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            },
                            success: function(a) {
                                var t = a.data;
                                if (wx.removeStorageSync("hour"), wx.removeStorageSync("minute"), wx.removeStorageSync("time1"), 
                                wx.removeStorageSync("dataArray"), a.data && 0 < k.length) {
                                    var e = {
                                        id: a.data
                                    };
                                    n.uploadimg({
                                        url: T,
                                        path: k
                                    }, e);
                                } else wx.reLaunch({
                                    url: "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + t
                                });
                            }
                        });
                    },
                    fail: function() {
                        wx.showToast({
                            title: "支付失败",
                            icon: "none",
                            duration: 2e3
                        }), n.setData({
                            can: !0
                        });
                    }
                });
            }
        })) : u && d && l && p && f ? (console.log("口令加一二三"), console.log(t), console.log(e), 
        console.log(P), app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                openid: V,
                price: P
            },
            success: function(a) {
                wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: "MD5",
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/addSeniorPro",
                            data: 0 == q ? {
                                one: 1,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                password: f,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                accurate: M,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            } : 1 == q ? {
                                one: 1,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                password: f,
                                status: n.data.status,
                                awardtype: 1,
                                accurate: z,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            } : {
                                one: 1,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                password: f,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            },
                            success: function(a) {
                                var t = a.data;
                                if (wx.removeStorageSync("hour"), wx.removeStorageSync("minute"), wx.removeStorageSync("time1"), 
                                wx.removeStorageSync("dataArray"), a.data && 0 < k.length) {
                                    var e = {
                                        id: a.data
                                    };
                                    n.uploadimg({
                                        url: T,
                                        path: k
                                    }, e);
                                } else wx.reLaunch({
                                    url: "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + t
                                });
                            }
                        });
                    },
                    fail: function() {
                        wx.showToast({
                            title: "支付失败",
                            icon: "none",
                            duration: 2e3
                        }), n.setData({
                            can: !0
                        });
                    }
                });
            }
        })) : u && d && l && p && y ? (console.log("付费加一二三"), app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                openid: V,
                price: P
            },
            success: function(a) {
                wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: "MD5",
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/addSeniorPro",
                            data: 0 == q ? {
                                one: 1,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                paidprice: y,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                accurate: M,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            } : 1 == q ? {
                                one: 1,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                paidprice: y,
                                status: n.data.status,
                                awardtype: 1,
                                accurate: z,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            } : {
                                one: 1,
                                onename: u,
                                onenum: l,
                                twoname: d,
                                twonum: p,
                                threename: c,
                                threenum: m,
                                paidprice: y,
                                status: n.data.status,
                                awardtype: 1,
                                index: q,
                                openid: V,
                                imgSrc: _,
                                lottery: j
                            },
                            success: function(a) {
                                var t = a.data;
                                if (wx.removeStorageSync("hour"), wx.removeStorageSync("minute"), wx.removeStorageSync("time1"), 
                                wx.removeStorageSync("dataArray"), a.data && 0 < k.length) {
                                    var e = {
                                        id: a.data
                                    };
                                    n.uploadimg({
                                        url: T,
                                        path: k
                                    }, e);
                                } else wx.reLaunch({
                                    url: "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + t
                                });
                            }
                        });
                    },
                    fail: function() {
                        wx.showToast({
                            title: "支付失败",
                            icon: "none",
                            duration: 2e3
                        }), n.setData({
                            can: !0
                        });
                    }
                });
            }
        })) : (console.log("cccccc"), wx.showToast({
            title: "信息填写不完整",
            icon: "none",
            duration: 2e3
        }), n.setData({
            can: !0
        }))) : (console.log("dddd"), wx.showToast({
            title: "信息填写不完整",
            icon: "none",
            duration: 2e3
        }), n.setData({
            can: !0
        }));
    },
    radiochange: function(a) {
        var t = a.detail.value;
        this.setData({
            orderway: t
        });
    },
    deleteImage: function(a) {
        var t = this.data.pics, e = a.currentTarget.dataset.index;
        t.splice(e, 1), this.setData({
            pics: t
        });
    },
    set_lottery: function(a) {
        this.setData({
            lottery: a.detail.value
        });
    }
});