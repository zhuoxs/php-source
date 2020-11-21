var app = getApp();

Page({
    data: {
        values: "",
        allArr: []
    },
    onLoad: function(a) {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Alltjs",
            success: function(a) {
                console.log(a);
                n.data.allArr;
                n.setData({
                    alltjs: a.data.data,
                    allArr: a.data.data
                });
            }
        });
    },
    inputClick: function(a) {
        for (var n = this, t = a.detail.value, l = n.data.alltjs, o = [], e = 0, i = l.length; e < i; e++) n.find(t, l[e].name) && o.push(l[e]);
        n.setData({
            values: t,
            allArr: o
        });
    },
    find: function(a, n) {
        return -1 !== n.indexOf(a);
    },
    delClick: function() {
        this.setData({
            values: ""
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