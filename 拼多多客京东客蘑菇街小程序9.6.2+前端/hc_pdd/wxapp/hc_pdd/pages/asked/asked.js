var app = getApp();

Page({
    data: {
        wenzi: [ {
            name: "问题1",
            checked: 0,
            daan: "答案1"
        }, {
            name: "问题2",
            checked: 0,
            daan: "答案2"
        }, {
            name: "问题3",
            checked: 0,
            daan: "答案3"
        }, {
            name: "问题4",
            checked: 0,
            daan: "答案4"
        }, {
            name: "问题5",
            checked: 0,
            daan: "答案5"
        }, {
            name: "问题6",
            checked: 0,
            daan: "答案6"
        } ]
    },
    onLoad: function(a) {
        this.Headcolor();
    },
    Headcolor: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            success: function(a) {
                var e = a.data.data.config.search_color, n = a.data.data.config.share_icon;
                a.data.data.config.head_color;
                app.globalData.Headcolor = a.data.data.config.head_color;
                var t = a.data.data.config.title, o = a.data.data.yesno, c = a.data.data.config.shenhe, d = a.data.data.config.text;
                i.setData({
                    search_color: e,
                    share_icon: n,
                    yesno: o,
                    shenhe: c,
                    text: d
                }), wx.setNavigationBarTitle({
                    title: t
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    dinajf: function(a) {
        for (var e = a.currentTarget.dataset.index, n = [], t = this.data.wenzi, o = 0; o < t.length; o++) t[o].checked = 0, 
        t[e].checked = 1, n.push(t[o]);
        console.log(t), this.setData({
            wenzi: n
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});