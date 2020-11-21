var app = getApp();

Page({
    data: {
        navTab: [ {
            con: "异常指标"
        }, {
            con: "正常指标"
        }, {
            con: "全部指标"
        } ],
        current: 0,
        yearContrastArr: []
    },
    onLoad: function(a) {
        var o = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: o
        });
        var t = JSON.parse(a.chooseId);
        console.log(t), this.setData({
            backgroundColor: o,
            bg_id: t
        }), this.getDuibi();
    },
    navTab: function(a) {
        this.setData({
            current: a.currentTarget.dataset.index
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getDuibi: function() {
        var e = this, a = e.data.bg_id;
        console.log(a), app.util.request({
            url: "entry/wxapp/Duibi",
            data: {
                bg_id: a
            },
            success: function(a) {
                console.log(a);
                var o = [];
                console.log(a.data.data);
                for (var t = 0; t < a.data.data.length; t++) if ("" == a.data.data[t][0].description) ; else {
                    var n = {};
                    n.title = a.data.data[t][0].time, n.labels = a.data.data[t], o.push(n);
                }
                console.log(o), e.setData({
                    yearContrastArr: o
                });
            }
        });
    }
});