var weekday = [ "周日", "周一", "周二", "周三", "周四", "周五", "周六" ], minutes = [ "00", "30" ], hours = [ "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23" ], myDate = new Date(), hh = myDate.getHours();

hh++;

for (var dateTemp, time1, dateArrays = [], time = [], c = [], flag = 1, i = 0; i < 7; i++) {
    var m = "", d = "";
    dateTemp = (m = myDate.getMonth() + 1 < 10 ? "0" + (myDate.getMonth() + 1) : myDate.getMonth() + 1) + "月" + (d = myDate.getDate() < 10 ? "0" + myDate.getDate() : myDate.getDate()) + "日 " + weekday[myDate.getDay()], 
    dateArrays.push(dateTemp), time1 = m + "-" + d, time.push(time1), myDate.setDate(myDate.getDate() + flag);
}

var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
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
        pic: ""
    },
    bindChange: function(a) {
        var t = this, e = a.detail.value, i = a.detail.value[1], u = t.data.inputValue6show;
        console.log(t.data.nowhour), u = i < t.data.nowhour && 0 == a.detail.value[0], this.setData({
            dateArray: this.data.dateArrays[e[0]],
            time1: this.data.time[e[0]],
            nowhour: this.data.hours[e[1]],
            minute: this.data.minutes[e[2]],
            inputValue6show: u
        }), console.log(t.data.dateArray + " " + t.data.hour + ":" + t.data.minute);
    },
    goTicketdetail: function(a) {
        var t = this, e = (t.data.inputValue1, t.data.inputValue2), i = t.data.inputValue1show, u = t.data.inputValue2show, n = t.data.inputValue3show, d = t.data.inputValue4show, l = t.data.inputValue5show;
        i = 0 == t.data.inputValue1, u = 0 == t.data.inputValue2 || 100 < t.data.inputValue2, 
        n = 0 == t.data.inputValue3 || 100 < t.data.inputValue3, d = 0 == t.data.inputValue4 || 100 < t.data.inputValue4, 
        l = 0 == t.data.inputValue5, this.setData({
            inputValue1show: i,
            inputValue2show: u,
            inputValue3show: n,
            inputValue4show: d,
            inputValue5show: l
        });
        var s = wx.getStorageSync("users").openid;
        if (1 == t.data.awardtype) {
            if (1 == t.data.index) i || u || l || app.util.request({
                url: "entry/wxapp/AddPro",
                data: {
                    awardtype: t.data.awardtype,
                    index: t.data.index,
                    gName: t.data.gName,
                    count: e,
                    accurate: t.data.accurate,
                    imgSrc: t.data.pic,
                    openid: s
                },
                success: function(a) {
                    wx.setStorageSync("gid", a.data), wx.navigateTo({
                        url: "../ticketdetail/ticketdetail"
                    });
                }
            }); else if (0 == t.data.index && !i && !u) {
                var o = myDate.getFullYear() + "-" + t.data.time1 + " " + t.data.nowhour + ":" + t.data.minute + ":00";
                app.util.request({
                    url: "entry/wxapp/AddPro",
                    data: {
                        awardtype: t.data.awardtype,
                        index: t.data.index,
                        gName: t.data.gName,
                        count: e,
                        accurate: o,
                        imgSrc: t.data.pic,
                        openid: s
                    },
                    success: function(a) {
                        wx.setStorageSync("gid", a.data), wx.navigateTo({
                            url: "../ticketdetail/ticketdetail"
                        });
                    }
                });
            }
        } else if (1 == t.data.index) n || d || l || app.util.request({
            url: "entry/wxapp/AddPro",
            data: {
                awardtype: t.data.awardtype,
                index: t.data.index,
                gName: t.data.gName,
                count: e,
                accurate: t.data.accurate,
                imgSrc: t.data.pic,
                openid: s
            },
            success: function(a) {
                wx.setStorageSync("gid", a.data), wx.navigateTo({
                    url: "../ticketdetail/ticketdetail"
                });
            }
        }); else if (!n && !d) {
            o = myDate.getFullYear() + "-" + t.data.time1 + " " + t.data.nowhour + ":" + t.data.minute + ":00";
            app.util.request({
                url: "entry/wxapp/AddPro",
                data: {
                    awardtype: t.data.awardtype,
                    index: t.data.index,
                    gName: t.data.gName,
                    count: e,
                    accurate: o,
                    imgSrc: t.data.pic,
                    openid: s
                },
                success: function(a) {
                    wx.setStorageSync("gid", a.data), wx.navigateTo({
                        url: "../ticketdetail/ticketdetail"
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
                        i.setData({
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
    onShow: function() {
        var t = this, a = wx.getStorageSync("gid");
        app.util.request({
            url: "entry/wxapp/Editor",
            data: {
                gid: a
            },
            success: function(a) {
                t.setData({
                    imgSrc: a.data[0].pic,
                    awardtype: a.data[0].cid,
                    gname: a.data[0].gname,
                    count: a.data[0].count,
                    index: a.data[0].condition,
                    accurate: a.data[0].accraute,
                    time: a.data[0].time
                }), t.getUrl();
            }
        });
    },
    getUrl: function() {
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
    }
});