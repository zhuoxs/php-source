var app = getApp();

Page({
    data: {
        i: 0,
        keshi: [ {
            id: 0,
            name: "外科",
            arr: [ {
                id: 0,
                txt: "外科1"
            }, {
                id: 1,
                txt: "外科2"
            }, {
                id: 2,
                txt: "外科3"
            }, {
                id: 3,
                txt: "外科4"
            } ]
        }, {
            id: 0,
            name: "内科",
            arr: [ {
                id: 0,
                txt: "内科1"
            }, {
                id: 1,
                txt: "内科2"
            }, {
                id: 2,
                txt: "内科3"
            }, {
                id: 3,
                txt: "内科4"
            } ]
        } ]
    },
    keshi: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Categoryfl2",
            data: {
                id: e
            },
            success: function(t) {
                console.log(t.data.data), a.setData({
                    categoryfl2: t.data.data
                });
            }
        }), this.setData({
            i: t.currentTarget.dataset.index
        });
    },
    doctor: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/hyb_yl/zhuanjialiebiao/zhuanjialiebiao?id=" + a
        });
    },
    onLoad: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Categoryf1",
            success: function(t) {
                console.log(t.data.data);
                var a = t.data.data[0].id;
                app.util.request({
                    url: "entry/wxapp/Categoryfl2",
                    data: {
                        id: a
                    },
                    success: function(t) {
                        console.log(t.data.data), e.setData({
                            categoryfl2: t.data.data
                        });
                    }
                }), e.setData({
                    category: t.data.data
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
    onShareAppMessage: function() {}
});