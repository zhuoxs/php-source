var e = getApp();

Component({
    properties: {
        src: {
            type: String,
            value: ""
        },
        poster: {
            type: String,
            value: ""
        },
        scrollTop: {
            type: Number,
            value: 0,
            observer: function(e, t, a) {
                var i = this;
                wx.createSelectorQuery().in(this).select(".video").boundingClientRect(function(e) {
                    var t = e.bottom, a = i.data.pause, o = i.data.isFullScreen, s = i.data.windowHeight, n = 51;
                    o && (n += 34), a = s - t <= n, i.setData({
                        pause: a
                    });
                }).exec();
            }
        }
    },
    data: {
        pause: !0,
        isFullScreen: !1,
        windowHeight: 0
    },
    attached: function() {
        this.setData({
            windowHeight: e.globalData.sysData.windowHeight,
            isFullScreen: e.globalData.isIphoneX
        });
    },
    methods: {}
});