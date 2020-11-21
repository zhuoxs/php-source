var app = getApp();

Page({
    data: {
        navigate_type: "",
        slideWidth: "",
        slideLeft: 0,
        totalLength: "",
        slideShow: !1,
        slideRatio: ""
    },
    onLoad: function() {
        var t = wx.getSystemInfoSync();
        this.setData({
            list: _list,
            windowHeight: 1 == app.globalData.navigate_type ? t.windowHeight : t.windowHeight - 35,
            windowWidth: t.windowWidth,
            navigate_type: app.globalData.navigate_type
        }), this.getRatio();
    },
    getRatio: function() {
        var t = this;
        if (!t.data.tlist[t.data.currentTab].secondList || t.data.tlist[t.data.currentTab].secondList.length <= 5) this.setData({
            slideShow: !1
        }); else {
            var a = 150 * t.data.tlist[t.data.currentTab].secondList.length, i = 230 / a * (750 / this.data.windowWidth), e = 750 / a * 230;
            this.setData({
                slideWidth: e,
                totalLength: a,
                slideShow: !0,
                slideRatio: i
            });
        }
    },
    getleft: function(t) {
        this.setData({
            slideLeft: t.detail.scrollLeft * this.data.slideRatio
        });
    }
});