var weekday = [ "周日", "周一", "周二", "周三", "周四", "周五", "周六" ], minutes = [ "00", "30" ], hours = [ "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23" ], myDate = new Date();

console.log(myDate);

var hh = myDate.getHours(), mm = myDate.getMinutes();

++hh;

for (var dateTemp, time1, dateArrays = [], time = [], c = [], flag = 1, i = 0; i < 7; i++) {
    var m = "", d = "";
    dateTemp = (m = myDate.getMonth() + 1 < 10 ? "0" + (myDate.getMonth() + 1) : myDate.getMonth() + 1) + "月" + (d = myDate.getDate() < 10 ? "0" + myDate.getDate() : myDate.getDate()) + "日 " + weekday[myDate.getDay()], 
    dateArrays.push(dateTemp), time1 = m + "-" + d, time.push(time1), myDate.setDate(myDate.getDate() + flag);
}

var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        current: 0,
        awardtype: 1,
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
        inputValue1: 0,
        inputValue1show: !1,
        inputValue2: 0,
        inputValue2show: !1,
        inputValue3: 0,
        inputValue3show: !1,
        inputValue4: 0,
        inputValue4show: !1,
        inputValue5: 0,
        inputValue5show: !1,
        inputValue6show: !1,
        imgSrc: "",
        gName: "",
        pic: "",
        prizeList: []
    },
    onLoad: function(a) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                wx.setStorageSync("url", a.data), t.setData({
                    url: a.data
                });
            }
        });
        var e = a.avatar;
        if (e) {
            var u = app.util.url("entry/wxapp/Toupload") + "&m=yzcj_sun";
            wx.uploadFile({
                url: u,
                filePath: e,
                name: "file",
                success: function(a) {
                    console.log(a), t.setData({
                        pic: a.data
                    });
                }
            }), this.setData({
                imgSrc: e
            });
        }
    },
    upload: function() {
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var t = a.tempFilePaths[0];
                wx.redirectTo({
                    url: "../upload/upload?src=" + t
                });
            }
        });
    },
    bindChange: function(a) {
        var t = this, e = a.detail.value, u = a.detail.value[1], i = t.data.inputValue6show, n = a.detail.value[2];
        0 == a.detail.value[0] && (u < t.data.nowhour - 1 && (i = !0), u == t.data.nowhour - 1 && (i = n <= t.data.nowmm)), 
        u > t.data.nowhour - 1 && (i = !1), this.setData({
            dateArray: this.data.dateArrays[e[0]],
            time1: this.data.time[e[0]],
            choosehour: u,
            hour: this.data.hours[e[1]],
            minute: this.data.minutes[e[2]],
            inputValue6show: i
        });
    },
    goPi: function() {
        wx.navigateTo({
            url: "../ticketPi/ticketPi"
        });
    },
    onShow: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/GetRed",
            data: {},
            success: function(a) {
                console.log(a), t.setData({
                    tz_audit: a.data.tz_audit,
                    is_car: a.data.is_car,
                    status: a.data.is_sjrz,
                    cjzt: a.data.cjzt,
                    cjzt1: a.data.cjzt ? t.data.url + "/" + a.data.cjzt : "../../../resource/images/banner.jpg",
                    day: a.data.is_open_pop,
                    senior: a.data.senior
                }), console.log(t.data.status);
            }
        });
        var a = new Date();
        console.log(a);
        var e = a.getHours(), u = a.getMinutes();
        ++e;
        for (var i, n, d = [], s = [], o = 0; o < 7; o++) {
            var l = "", r = "";
            i = (l = a.getMonth() + 1 < 10 ? "0" + (a.getMonth() + 1) : a.getMonth() + 1) + "月" + (r = a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + "日 " + weekday[a.getDay()], 
            d.push(i), n = l + "-" + r, s.push(n), a.setDate(a.getDate() + 1);
        }
        t.setData({
            dateArrays: d,
            time: s,
            time1: s[0],
            dateArray: d[0],
            hours: hours,
            hour: hours[0],
            nowhour: e,
            nowmm: 30 < u ? 1 : 0,
            minutes: minutes,
            minute: minutes[0]
        });
    },
    goTicketdetail: function(a) {
        var t = this, e = (t.data.current, t.data.status);
        console.log(e);
        t.data.inputValue1;
        var u = t.data.inputValue2, i = t.data.inputValue1show, n = t.data.inputValue2show, d = t.data.inputValue3show, s = t.data.inputValue4show, o = t.data.inputValue5show;
        i = 0 == t.data.inputValue1, n = 0 == t.data.inputValue2 || 200 < t.data.inputValue2, 
        d = 0 == t.data.inputValue3 || 200 < t.data.inputValue3, s = 0 == t.data.inputValue4 || 100 < t.data.inputValue4, 
        o = 0 == t.data.inputValue5, this.setData({
            inputValue1show: i,
            inputValue2show: n,
            inputValue3show: d,
            inputValue4show: s,
            inputValue5show: o
        });
        var l = wx.getStorageSync("users").openid;
        if (console.log(t.data.pic), 1 == t.data.awardtype) if (1 == t.data.index) i || n || o || app.util.request({
            url: "entry/wxapp/AddPro",
            data: {
                awardtype: t.data.awardtype,
                index: t.data.index,
                gName: t.data.gName,
                count: u,
                accurate: t.data.accurate,
                imgSrc: t.data.pic,
                openid: l,
                status: e
            },
            success: function(a) {
                wx.reLaunch({
                    url: "../ticketdetail/ticketdetail?gid=" + a.data
                });
            }
        }); else if (0 == t.data.index) {
            if (!i && !n) {
                if (null == t.data.choosehour) var r = myDate.getFullYear() + "-" + t.data.time1 + " " + t.data.nowhour + ":" + t.data.minute + ":00"; else r = myDate.getFullYear() + "-" + t.data.time1 + " " + t.data.choosehour + ":" + t.data.minute + ":00";
                app.util.request({
                    url: "entry/wxapp/AddPro",
                    data: {
                        awardtype: t.data.awardtype,
                        index: t.data.index,
                        gName: t.data.gName,
                        count: u,
                        accurate: r,
                        imgSrc: t.data.pic,
                        openid: l,
                        status: e
                    },
                    success: function(a) {
                        wx.reLaunch({
                            url: "../ticketdetail/ticketdetail?gid=" + a.data
                        });
                    }
                });
            }
        } else 2 == t.data.index && (i || n || app.util.request({
            url: "entry/wxapp/AddPro",
            data: {
                awardtype: t.data.awardtype,
                index: t.data.index,
                gName: t.data.gName,
                count: u,
                imgSrc: t.data.pic,
                openid: l,
                status: e
            },
            success: function(a) {
                wx.reLaunch({
                    url: "../ticketdetail/ticketdetail?gid=" + a.data
                });
            }
        })); else if (1 == t.data.index) {
            if (!d && !s && !o) {
                var c = t.data.tz_audit / 100, p = t.data.inputValue3 * t.data.inputValue4 * (1 + c), h = t.data.awardtype, m = t.data.index, w = t.data.inputValue3, g = t.data.inputValue4, y = t.data.pic, V = t.data.accurate;
                app.util.request({
                    url: "entry/wxapp/Orderarr",
                    cachetime: "30",
                    data: {
                        openid: l,
                        price: p
                    },
                    success: function(a) {
                        console.log(a), wx.requestPayment({
                            timeStamp: a.data.timeStamp,
                            nonceStr: a.data.nonceStr,
                            package: a.data.package,
                            signType: "MD5",
                            paySign: a.data.paySign,
                            success: function(a) {
                                wx.showToast({
                                    title: "支付成功",
                                    icon: "success",
                                    duration: 2e3
                                }), app.util.request({
                                    url: "entry/wxapp/AddPro",
                                    data: {
                                        awardtype: h,
                                        index: m,
                                        gName: w,
                                        count: g,
                                        accurate: V,
                                        imgSrc: y,
                                        openid: l,
                                        status: e
                                    },
                                    success: function(a) {
                                        wx.reLaunch({
                                            url: "../ticketdetail/ticketdetail?gid=" + a.data
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        } else if (0 == t.data.index) {
            if (!d && !s) {
                h = t.data.awardtype, m = t.data.index, w = t.data.inputValue3, g = t.data.inputValue4, 
                y = t.data.pic;
                if (null == t.data.choosehour) r = myDate.getFullYear() + "-" + t.data.time1 + " " + t.data.nowhour + ":" + t.data.minute + ":00"; else r = myDate.getFullYear() + "-" + t.data.time1 + " " + t.data.choosehour + ":" + t.data.minute + ":00";
                c = t.data.tz_audit / 100, p = t.data.inputValue3 * t.data.inputValue4 * (1 + c);
                app.util.request({
                    url: "entry/wxapp/Orderarr",
                    cachetime: "30",
                    data: {
                        openid: l,
                        price: p
                    },
                    success: function(a) {
                        console.log(a), wx.requestPayment({
                            timeStamp: a.data.timeStamp,
                            nonceStr: a.data.nonceStr,
                            package: a.data.package,
                            signType: "MD5",
                            paySign: a.data.paySign,
                            success: function(a) {
                                wx.showToast({
                                    title: "支付成功",
                                    icon: "success",
                                    duration: 2e3
                                }), app.util.request({
                                    url: "entry/wxapp/AddPro",
                                    data: {
                                        awardtype: h,
                                        index: m,
                                        gName: w,
                                        count: g,
                                        accurate: r,
                                        imgSrc: y,
                                        openid: l,
                                        status: e
                                    },
                                    success: function(a) {
                                        wx.reLaunch({
                                            url: "../ticketdetail/ticketdetail?gid=" + a.data
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        } else if (2 == t.data.index && !d && !s) {
            h = t.data.awardtype, m = t.data.index, w = t.data.inputValue3, g = t.data.inputValue4, 
            y = t.data.pic, c = t.data.tz_audit / 100, p = t.data.inputValue3 * t.data.inputValue4 * (1 + c);
            app.util.request({
                url: "entry/wxapp/Orderarr",
                cachetime: "30",
                data: {
                    openid: l,
                    price: p
                },
                success: function(a) {
                    console.log(a), wx.requestPayment({
                        timeStamp: a.data.timeStamp,
                        nonceStr: a.data.nonceStr,
                        package: a.data.package,
                        signType: "MD5",
                        paySign: a.data.paySign,
                        success: function(a) {
                            wx.showToast({
                                title: "支付成功",
                                icon: "success",
                                duration: 2e3
                            }), app.util.request({
                                url: "entry/wxapp/AddPro",
                                data: {
                                    awardtype: h,
                                    index: m,
                                    gName: w,
                                    count: g,
                                    imgSrc: y,
                                    openid: l,
                                    status: e
                                },
                                success: function(a) {
                                    wx.reLaunch({
                                        url: "../ticketdetail/ticketdetail?gid=" + a.data
                                    });
                                }
                            });
                        }
                    });
                }
            });
        }
    },
    goTicketmy: function(a) {
        wx.navigateTo({
            url: "../ticketmy/ticketmy"
        });
    },
    goBalance: function(a) {
        wx.navigateTo({
            url: "../balance/balance"
        });
    },
    changetype: function(a) {
        var t = this, e = t.data.awardtype;
        t.data.inputValue1, t.data.inputValue2, t.data.inputValue1show, t.data.inputValue2show;
        e = 1 == e ? 2 : 1, t.setData({
            awardtype: e,
            inputValue1show: !1,
            inputValue2show: !1,
            inputValue1: 0,
            inputValue2: 0
        });
    },
    choosetime: function(a) {
        var t = this.data.showtime;
        t = !t, this.setData({
            showtime: t
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
    chooseImage: function(a) {
        var u = this, i = app.util.url("entry/wxapp/Toupload") + "&m=yzcj_sun";
        wx.chooseImage({
            count: 1,
            sizeType: [ "compressed" ],
            sourceType: [ "album" ],
            success: function(a) {
                var t = a.tempFilePaths, e = u.data.imgSrc;
                e = t, console.log(e), u.setData({
                    imgSrc: e
                }), wx.uploadFile({
                    url: i,
                    filePath: u.data.imgSrc[0],
                    name: "file",
                    formData: {},
                    success: function(a) {
                        console.log(a), u.setData({
                            pic: a.data
                        });
                    }
                });
            }
        });
    },
    bindKeyInput1: function(a) {
        var t = this.data.inputValue1show;
        t = 0 == a.detail.value.length, this.setData({
            inputValue1: a.detail.value.length,
            inputValue1show: t,
            gName: a.detail.value
        });
    },
    bindKeyInput2: function(a) {
        var t = this.data.inputValue2show;
        t = 0 == a.detail.value || 100 < a.detail.value, this.setData({
            inputValue2: a.detail.value,
            inputValue2show: t
        });
    },
    bindKeyInput3: function(a) {
        var t = this.data.inputValue3show;
        t = 0 == a.detail.value || 200 < a.detail.value, this.setData({
            inputValue3: a.detail.value,
            inputValue3show: t
        });
    },
    bindKeyInput4: function(a) {
        var t = this.data.inputValue4show;
        t = 0 == a.detail.value || 100 < a.detail.value, this.setData({
            inputValue4: a.detail.value,
            inputValue4show: t
        });
    },
    bindKeyInput5: function(a) {
        var t = this.data.inputValue5show;
        t = 0 == a.detail.value.length, this.setData({
            inputValue5: a.detail.value.length,
            inputValue5show: t,
            accurate: a.detail.value
        });
    },
    tonewadd: function() {
        wx.redirectTo({
            url: "../ticketnewadd/ticketnewadd"
        });
    }
});