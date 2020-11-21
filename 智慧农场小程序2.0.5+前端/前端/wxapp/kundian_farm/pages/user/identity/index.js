var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        name: "",
        id_card: ""
    },
    onLoad: function(e) {
        var n = wx.getStorageSync("kundian_farm_uid"), i = (wx.getStorageSync("kundian_farm_setData"), 
        this);
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "index",
                op: "getUserBindPhone",
                uid: n,
                uniacid: t
            },
            success: function(a) {
                var t = a.data.userInfo;
                i.setData({
                    name: t.truename,
                    id_card: t.id_card
                });
            }
        }), a.util.setNavColor(t);
    },
    getstatusValue: function(a) {
        this.setData({
            id_card: a.detail.value
        });
    },
    getNameValue: function(a) {
        this.setData({
            name: a.detail.value
        });
    },
    submit: function() {
        var e = this.data, n = e.name, i = e.id_card, d = /^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/;
        if ("" == n || void 0 === n) return wx.showToast({
            title: "姓名不能为空",
            icon: "none",
            duration: 2e3
        }), !1;
        if ("" == i && wx.showToast({
            title: "身份证号码不能为空",
            icon: "none",
            duration: 2e3
        }), !d.test(i)) return wx.showToast({
            title: "请输入正确的身份证号码",
            icon: "none",
            duration: 2e3
        }), !1;
        var o = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "index",
                op: "realNameAuth",
                name: n,
                id_card: i,
                uniacid: t,
                uid: o
            },
            success: function(a) {
                wx.showToast({
                    title: a.data.msg,
                    icon: "none"
                });
            }
        });
    }
});