var a = function(a) {
    return a && a.__esModule ? a : {
        default: a
    };
}(require("../../../template/calendarTemplate/calendarTemplate")), t = new getApp(), e = t.siteInfo.uniacid;

Page({
    data: {
        SystemInfo: t.globalData.sysData,
        isIphoneX: t.globalData.isIphoneX,
        bg: "",
        date: 3,
        userInfo: [],
        userData: [],
        is_sign: 2,
        aboutData: [],
        tarbar: wx.getStorageSync("kundianFarmTarbar"),
        is_tarbar: !1
    },
    onLoad: function(n) {
        (0, a.default)();
        var r = this, i = wx.getStorageSync("kundian_farm_uid"), s = wx.getStorageSync("userInfo"), o = this.data.calendar, d = this.data.calendar.curYear, u = this.data.calendar.curMonth, c = wx.getStorageSync("kundian_farm_setData"), g = !1;
        n.is_tarbar && (g = n.is_tarbar), r.setData({
            sign_title: c.sign_title,
            tarbar: wx.getStorageSync("kundianFarmTarbar"),
            is_tarbar: g
        }), 0 != i ? t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "sign",
                op: "getSignData",
                uid: i,
                uniacid: e,
                year: d,
                month: u
            },
            success: function(a) {
                if (a.data.signData) {
                    for (var t = a.data.signData, e = 0; e < t.length; e++) for (var n = 0; n < o.days.length; n++) o.days[n].day == t[e].day && (o.days[n].choosed = !0, 
                    o.days[n].sign = !0);
                    r.setData({
                        calendar: o
                    });
                }
                var i = a.data, d = i.userData, u = i.is_sign, c = i.aboutData;
                r.setData({
                    userInfo: s.memberInfo,
                    userData: d,
                    is_sign: u,
                    aboutData: c,
                    bg: c.sign_banner
                });
            }
        }) : wx.redirectTo({
            url: "../../../login/index"
        }), t.util.setNavColor(e);
    },
    intoIntegral: function(a) {
        wx.navigateTo({
            url: "../exchange/index"
        });
    },
    intoRecord: function(a) {
        wx.navigateTo({
            url: "../record/index"
        });
    },
    addSign: function(a) {
        var n = wx.getStorageSync("kundian_farm_uid"), r = this, i = r.data.calendar.days;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "sign",
                op: "addSign",
                uid: n,
                uniacid: e
            },
            success: function(a) {
                if (1 == a.data.code) {
                    wx.showToast({
                        title: "签到成功"
                    });
                    for (var t = 0; t < i.length; t++) i[t].day == a.data.day && (i[t].choosed = !0);
                    r.setData({
                        userData: a.data.userData,
                        is_sign: 1,
                        "calendar.days": i
                    });
                } else 2 == a.data.code ? wx.showToast({
                    title: "签到失败"
                }) : 3 == a.data.code ? wx.showToast({
                    title: "今日已签到"
                }) : wx.showToast({
                    title: "签到失败1"
                });
            }
        });
    },
    intoSignRule: function(a) {
        wx.navigateTo({
            url: "/kundian_farm/pages/common/agreement/index?type=3"
        });
    },
    onShareAppMessage: function() {},
    signCard: function() {
        var a = wx.getStorageSync("kundian_farm_uid");
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "sign",
                op: "signCard",
                uid: a,
                uniacid: e
            },
            success: function(a) {
                console.log(a);
            }
        });
    }
});