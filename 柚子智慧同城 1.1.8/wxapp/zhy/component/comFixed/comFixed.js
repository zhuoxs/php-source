var e = getApp();

Component({
    properties: {
        show: {
            type: Array,
            value: [],
            observer: function(e, t) {
                var a = this;
                setTimeout(function() {
                    a._delShow(e);
                }, 80);
            }
        },
        padding: {
            type: [ Number, String ],
            value: 60,
            observer: function(e, t) {}
        }
    },
    data: {
        share: !1,
        serve: !1,
        home: !1,
        newPage: !1
    },
    attached: function() {
        var e = getCurrentPages(), t = e[e.length - 1].route, a = e[e.length - 2];
        this.setData({
            nowPage: t
        }), void 0 == a && this.setData({
            newPage: !0
        });
    },
    methods: {
        _delShow: function(e) {
            for (var t in e) 1 == e[t] ? this.setData({
                share: !0
            }) : 2 == e[t] ? this.setData({
                serve: !0
            }) : 3 == e[t] && this.setData({
                home: !0
            });
            var a = wx.getStorageSync("setting").nav;
            if (a) {
                var n = JSON.stringify(a);
                -1 != n.search("/pages/home/home") && -1 != n.search(this.data.nowPage) && this.setData({
                    home: !1
                });
            }
        },
        _onHomeTap: function() {
            e.lunchTo("/pages/home/home");
        },
        _thankServe: function(e) {}
    }
});