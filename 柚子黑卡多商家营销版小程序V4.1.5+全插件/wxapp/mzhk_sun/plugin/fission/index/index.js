/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {
        page: 1,
        list: []
    },
    onLoad: function(t) {
        var e = this;
        wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude,
                    n = t.longitude;
                app.util.request({
                    url: "entry/wxapp/GetFission",
                    data: {
                        lat: a,
                        lon: n,
                        type: 2,
                        m: app.globalData.Plugin_fission
                    },
                    success: function(t) {
                        console.log(t.data), e.setData({
                            list: t.data
                        })
                    }
                })
            }
        }), app.util.request({
            url: "entry/wxapp/GetSet",
            showLoading: !1,
            data: {
                m: app.globalData.Plugin_fission
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    banner: t.data
                })
            }
        })
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this,
            o = e.data.page,
            i = e.data.list;
        wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude,
                    n = t.longitude;
                app.util.request({
                    url: "entry/wxapp/GetFission",
                    cachetime: "30",
                    data: {
                        lat: a,
                        lon: n,
                        page: o,
                        type: 2,
                        m: app.globalData.Plugin_fission
                    },
                    success: function(t) {
                        if (console.log(t.data), 2 == t.data) wx.showToast({
                            title: "已经没有内容了哦！！！",
                            icon: "none"
                        });
                        else {
                            var a = t.data;
                            i = i.concat(a), e.setData({
                                list: i,
                                page: o + 1
                            })
                        }
                    }
                })
            }
        })
    },
    toDetail: function(t) {
        var a = parseInt(t.currentTarget.dataset.id),
            n = parseInt(t.currentTarget.dataset.bid);
        wx.navigateTo({
            url: "/mzhk_sun/plugin/fission/detail/detail?id=" + a + "&bid=" + n
        })
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "/mzhk_sun/pages/index/index"
        })
    }
});