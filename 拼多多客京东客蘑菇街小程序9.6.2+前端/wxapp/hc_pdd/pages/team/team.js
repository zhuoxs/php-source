var app = getApp(), pageNum = 0;

Page({
    data: {
        yiji: [],
        chshi: 0
    },
    onLoad: function(a) {
        var t = this, e = Number(t.data.chshi) + 1;
        t.team(e);
        var i = app.globalData.Headcolor;
        t.setData({
            backgroundColor: i
        });
    },
    team: function(a) {
        var s = this;
        app.util.request({
            url: "entry/wxapp/myteam",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                level: a
            },
            success: function(a) {
                var t = a.data.data.info, e = a.data.data.data, i = a.data.data.list, n = t.fx_level, o = [ t.yiji, t.erji, t.sanji ];
                s.setData({
                    yuca: e,
                    info: t,
                    goodslist: i,
                    fx_level: n,
                    yiji: o
                });
            }
        });
    },
    jaizai: function(a) {
        var i = this, n = i.data.goodsist;
        app.util.request({
            url: "entry/wxapp/myteam",
            method: "POST",
            data: {
                pageNum: a,
                user_id: app.globalData.user_id
            },
            success: function(a) {
                for (var t = a.data.data.list, e = 0; e < t.length; e++) n.push(t[e]);
                i.setData({
                    goodsist: n
                });
            }
        });
    },
    onReachBottom: function() {
        console.log(this.data.goods), pageNum++, this.jaizai(pageNum);
    },
    qiehuan: function(a) {
        var t = Number(a.currentTarget.dataset.index) + 1;
        a.currentTarget.dataset.index;
        this.setData({
            chshi: a.currentTarget.dataset.index
        }), this.team(t);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onShareAppMessage: function() {}
});