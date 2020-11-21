var weekday = [ "周日", "周一", "周二", "周三", "周四", "周五", "周六" ], minutes = [ "00", "30" ], hours = [ "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23" ], myDate = new Date(), hh = myDate.getHours();

++hh;

for (var dateTemp, time1, dateArrays = [], time = [], c = [], flag = 1, i = 0; i < 7; i++) {
    var m = "", d = "";
    dateTemp = (m = myDate.getMonth() + 1 < 10 ? "0" + (myDate.getMonth() + 1) : myDate.getMonth() + 1) + "月" + (d = myDate.getDate() < 10 ? "0" + myDate.getDate() : myDate.getDate()) + "日 " + weekday[myDate.getDay()], 
    dateArrays.push(dateTemp), time1 = m + "-" + d, time.push(time1), myDate.setDate(myDate.getDate() + flag);
}

var Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page, app = getApp();

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
    cilck: function(a) {
        var t = this, e = t.data.prizeList.length, i = t.rand(e);
        this.setData({
            current: i,
            gname: t.data.prizeList[i].name
        });
    },
    rand: function(a) {
        var t = this.data.current, e = Math.floor(Math.random() * a);
        return t == e ? this.rand(a) : e;
    },
    onLoad: function(a) {
        var t = this, e = a.avatar;
        if (e) {
            var i = app.util.url("entry/wxapp/Toupload") + "&m=yzcj_sun";
            wx.uploadFile({
                url: i,
                filePath: e,
                name: "file",
                success: function(a) {
                    t.setData({
                        pic: a.data
                    });
                }
            }), this.setData({
                imgSrc: e
            });
        }
        app.util.request({
            url: "entry/wxapp/GetPi",
            data: {},
            success: function(a) {
                console.log(a), t.setData({
                    prizeList: a.data
                });
            }
        });
    },
    upload: function() {
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var t = a.tempFilePaths[0];
                wx.redirectTo({
                    url: "../piupload/piupload?src=" + t
                });
            }
        });
    },
    bindChange: function(a) {
        var t = this, e = a.detail.value, i = a.detail.value[1], u = t.data.inputValue6show;
        console.log(t.data.nowhour), u = i < t.data.nowhour && 0 == a.detail.value[0], this.setData({
            dateArray: this.data.dateArrays[e[0]],
            time1: this.data.time[e[0]],
            choosehour: i,
            hour: this.data.hours[e[1]],
            minute: this.data.minutes[e[2]],
            inputValue6show: u
        });
    },
    onShow: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/GetRed",
            data: {},
            success: function(a) {
                t.setData({
                    tz_audit: a.data.tz_audit,
                    is_car: a.data.is_car,
                    status: a.data.is_sjrz,
                    day: a.data.is_open_pop
                });
            }
        });
    },
    goTicketdetail: function(a) {
        var t = this;
        if (null != t.data.gname) var e = t.data.gname; else e = t.data.prizeList[0].name;
        console.log(e);
        var i = t.data.inputValue2, u = t.data.inputValue2show, s = t.data.inputValue5show;
        u = 0 == t.data.inputValue2 || 200 < t.data.inputValue2, s = 0 == t.data.inputValue5, 
        this.setData({
            inputValue2show: u,
            inputValue5show: s
        });
        var n = wx.getStorageSync("users").openid;
        if (1 == t.data.index) u || s || app.util.request({
            url: "entry/wxapp/AddPI",
            data: {
                index: t.data.index,
                gname: e,
                count: i,
                accurate: t.data.accurate,
                imgSrc: t.data.pic,
                openid: n,
                status: t.data.status
            },
            success: function(a) {
                wx.reLaunch({
                    url: "../ticketdetail/ticketdetail?gid=" + a.data
                });
            }
        }); else if (0 == t.data.index) {
            if (!u) {
                if (null == t.data.choosehour) var d = myDate.getFullYear() + "-" + t.data.time1 + " " + t.data.nowhour + ":" + t.data.minute + ":00"; else d = myDate.getFullYear() + "-" + t.data.time1 + " " + t.data.choosehour + ":" + t.data.minute + ":00";
                app.util.request({
                    url: "entry/wxapp/AddPI",
                    data: {
                        index: t.data.index,
                        gname: e,
                        count: i,
                        accurate: d,
                        imgSrc: t.data.pic,
                        openid: n,
                        status: t.data.status
                    },
                    success: function(a) {
                        wx.reLaunch({
                            url: "../ticketdetail/ticketdetail?gid=" + a.data
                        });
                    }
                });
            }
        } else 2 == t.data.index && (u || app.util.request({
            url: "entry/wxapp/AddPI",
            data: {
                index: t.data.index,
                gname: e,
                count: i,
                imgSrc: t.data.pic,
                openid: n,
                status: t.data.status
            },
            success: function(a) {
                wx.reLaunch({
                    url: "../ticketdetail/ticketdetail?gid=" + a.data
                });
            }
        }));
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
        var i = this, u = app.util.url("entry/wxapp/Toupload") + "&m=yzcj_sun";
        wx.chooseImage({
            count: 1,
            sizeType: [ "compressed" ],
            sourceType: [ "album" ],
            success: function(a) {
                var t = a.tempFilePaths, e = i.data.imgSrc;
                e = t, console.log(e), i.setData({
                    imgSrc: e
                }), wx.uploadFile({
                    url: u,
                    filePath: i.data.imgSrc[0],
                    name: "file",
                    formData: {},
                    success: function(a) {
                        console.log(a), i.setData({
                            pic: a.data
                        });
                    }
                });
            }
        });
    },
    bindKeyInput2: function(a) {
        var t = this.data.inputValue2show;
        t = 0 == a.detail.value || 100 < a.detail.value, this.setData({
            inputValue2: a.detail.value,
            inputValue2show: t
        });
    },
    bindKeyInput5: function(a) {
        var t = this.data.inputValue5show;
        t = 0 == a.detail.value.length, this.setData({
            inputValue5: a.detail.value.length,
            inputValue5show: t,
            accurate: a.detail.value
        });
    }
});