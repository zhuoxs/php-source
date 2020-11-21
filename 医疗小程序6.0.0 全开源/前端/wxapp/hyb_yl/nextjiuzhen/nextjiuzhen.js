var app = getApp();

Page({
    data: {
        startdate: null,
        enddate: null,
        date: "",
        times: ""
    },
    onLoad: function(t) {
        var n = this;
        if (console.log(t), t.ds_id) {
            var e = t.ds_id;
            app.util.request({
                url: "entry/wxapp/Selecttx",
                data: {
                    ds_id: e
                },
                success: function(t) {
                    var e = t.data.data.timearr, a = t.data.data;
                    n.setData({
                        detal: a,
                        timearr: e
                    });
                }
            }), n.setData({
                ds_id: e
            });
        }
        this.setdates();
    },
    setdates: function() {
        var t = new Date(), e = t.getFullYear(), a = 9 < t.getMonth() + 1 ? t.getMonth() + 1 : "0" + (t.getMonth() + 1), n = 9 < t.getDate() ? t.getDate() : "0" + t.getDate(), i = 9 < t.getHours() ? t.getHours() : "0" + t.getHours(), s = 9 < t.getMinutes() ? t.getMinutes() : "0" + t.getMinutes();
        this.setData({
            date: e + "-" + a + "-" + n,
            startdate: e + "-" + a + "-" + n,
            enddate: e + 10 + "-" + a + "-" + n,
            times: i + ":" + s
        });
    },
    datesel: function(t) {
        this.setData({
            date: t.detail.value
        });
    },
    timesel: function(t) {
        this.setData({
            times: t.detail.value
        });
    },
    remind: function(t) {
        var e = this.data.date, a = this.data.times, n = t.detail.value, i = n.content, s = n.xiangmu, o = e + " " + a;
        console.log(t);
        var d = t.detail.formId;
        "" == n.xiangmu ? wx.showToast({
            title: "项目不能为空",
            image: "/hyb_yl/images/err.png"
        }) : app.util.request({
            url: "entry/wxapp/Savestime",
            data: {
                timearr: o,
                content: i,
                openid: wx.getStorageSync("openid"),
                xiangmu: s,
                formid: d
            },
            success: function(t) {
                console.log(t);
                var e = getCurrentPages();
                e[e.length - 2].setData({
                    xctime: o
                }), wx.navigateBack({
                    delta: 1
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
    onShareAppMessage: function() {},
    shouye: function() {
        wx.reLaunch({
            url: "/hyb_yl/index/index"
        });
    }
});