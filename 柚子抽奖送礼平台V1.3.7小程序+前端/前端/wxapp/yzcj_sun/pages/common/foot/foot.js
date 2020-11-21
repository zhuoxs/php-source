var app = getApp();

Component({
    properties: {
        chooseNav: {
            type: Number,
            value: 0,
            observer: function(t, e) {}
        }
    },
    data: {},
    ready: function() {},
    attached: function() {
        var e = this, n = this;
        return new Promise(function(r, t) {
            app.util.request({
                url: "entry/wxapp/url",
                cachetime: "0",
                success: function(t) {
                    wx.setStorageSync("url", t.data), n.setData({
                        imgLink: t.data
                    });
                }
            }), app.util.request({
                url: "entry/wxapp/settab",
                success: function(t) {
                    console.log(t), r(t);
                    var e = getCurrentPages(), a = e[e.length - 1].route;
                    n.setData({
                        foot: t.data,
                        url: "/" + a
                    });
                }
            });
        }).catch(function(t) {
            e.tips("请求过期（foot）");
        });
    },
    methods: {
        _onNavTab: function(t) {
            var e = getCurrentPages(), a = e[e.length - 1].route, r = (t.currentTarget.dataset.index, 
            t.currentTarget.dataset.path);
            a !== r && "/yzcj_sun/pages/ticket/ticketadd/ticketadd" != r && wx.reLaunch({
                url: r
            }), a !== r && "/yzcj_sun/pages/ticket/ticketadd/ticketadd" == r && wx.navigateTo({
                url: r
            });
        }
    }
});