function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

function isToday(t) {
    var a = new app.util.date();
    return a.dateToStr("yyyy-MM-DD", a.longToDate(1e3 * t)) == a.dateToStr("yyyy-MM-DD");
}

function list(t) {
    for (var a = new app.util.date(), e = [], o = 0; o < 12; o++) {
        var s = {};
        s.date = a.dateToStr("yyyy-MM", a.dateAdd("m", -(t + o))), s.show = -1, s.sub = "", 
        e.push(s);
    }
    return console.log(e), e;
}

Page({
    data: {},
    showDetail: function(t) {
        var e = t.currentTarget.dataset.index;
        if (this.setData(_defineProperty({}, "list[" + e + "].show", -this.data.list[e].show)), 
        "" == this.data.list[e].sub) {
            var o = this;
            app.util.request({
                url: "entry/wxapp/sport",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "getStepLog",
                    date: o.data.list[e].date
                },
                success: function(t) {
                    var a = t.data;
                    a.data.list && o.setData(_defineProperty({}, "list[" + e + "].sub", a.data.list));
                }
            });
        }
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("weRunData");
        a && isToday(a.timestamp) ? this.setData({
            step: a.step,
            totalstep: app.globalData.userInfo.totalstep
        }) : this.setData({
            step: 0,
            totalstep: app.globalData.userInfo.totalstep
        }), this.setData({
            list: list(0)
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        this.setData({
            list: this.data.list.concat(list(this.data.list.length))
        });
    },
    onShareAppMessage: function() {}
});