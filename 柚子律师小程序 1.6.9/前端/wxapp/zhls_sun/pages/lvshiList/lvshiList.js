var app = getApp();

Page({
    data: {
        curIndex: 0,
        city_id: 0,
        num: 0,
        light: "",
        kong: "",
        array: [ "美国", "中国", "巴西", "日本" ]
    },
    bindPickerChange: function(e) {
        var a = this;
        console.log("picker发送选择改变，携带值为", e.detail.value);
        var n = a.data.city[e.detail.value].id, t = wx.getStorageSync("lat"), i = wx.getStorageSync("lng");
        app.util.request({
            url: "entry/wxapp/CityLawyers",
            cachetime: "0",
            data: {
                latitude: t,
                longitude: i,
                city_id: n
            },
            success: function(t) {
                a.setData({
                    index: e.detail.value,
                    city_id: n,
                    lawyers: t.data,
                    curIndex: 0
                });
            }
        });
    },
    goTap: function(t) {
        console.log(t);
        var e = this;
        e.setData({
            current: t.currentTarget.dataset.index
        }), 1 == e.data.current && wx.redirectTo({
            url: "../article/index?currentIndex=1"
        }), 0 == e.data.current && wx.redirectTo({
            url: "../shouye/index?currentIndex=0"
        }), 3 == e.data.current && wx.redirectTo({
            url: "../mine/index?currentIndex=3"
        });
    },
    onLoad: function(e) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/LawtypeData",
            cachetime: "0",
            success: function(t) {
                console.log(t.data);
                3 < t.data.length && a.setData({
                    limit: "min-width"
                }), a.setData({
                    category: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/tab",
            cachetime: "10",
            success: function(t) {
                a.setData({
                    tab: t.data,
                    current: e.currentIndex
                });
            }
        }), a.url();
    },
    tabClick: function(t) {
        var e = this, a = t.currentTarget.dataset.id, n = e.data.city_id;
        if (console.log(a), console.log(n), 0 == a && 0 == n) e.onShow(); else {
            var i = wx.getStorageSync("lat"), r = wx.getStorageSync("lng");
            app.util.request({
                url: "entry/wxapp/TypeIdData",
                cachetime: "0",
                data: {
                    id: a,
                    latitude: i,
                    longitude: r,
                    city_id: n
                },
                success: function(t) {
                    console.log(t.data), e.setData({
                        lawyers: t.data
                    });
                }
            });
        }
        e.setData({
            curIndex: t.currentTarget.dataset.index
        });
    },
    url: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    freeConsult: function(t) {
        wx.navigateTo({
            url: "../consult/free"
        });
    },
    watchClassic: function(t) {
        0 == t.currentTarget.dataset.index && wx.navigateTo({
            url: "../yuyue/online"
        }), 1 == t.currentTarget.dataset.index && wx.navigateTo({
            url: "../consult/free"
        }), 2 == t.currentTarget.dataset.index && wx.navigateTo({
            url: "../consult/fufei"
        }), 3 == t.currentTarget.dataset.index && wx.makePhoneCall({
            phoneNumber: this.data.shopData.tel,
            success: function(t) {
                console.log("-----拨打电话成功-----");
            },
            fail: function(t) {
                console.log("-----拨打电话失败-----");
            }
        });
    },
    joinNow: function() {
        wx.navigateTo({
            url: "../active-list/details"
        });
    },
    goHongBao: function(t) {
        wx.navigateTo({
            url: "../hongbao/index"
        });
    },
    goQuestion: function(t) {
        wx.navigateTo({
            url: "../consult/fufei?id=" + t.currentTarget.dataset.id
        });
    },
    gofreeQues: function(t) {
        wx.navigateTo({
            url: "../consult/free"
        });
    },
    toYewuDetails: function(t) {
        wx.navigateTo({
            url: "../yewuDetails/yewuDetails"
        });
    },
    goLvshiIntro: function(t) {
        wx.navigateTo({
            url: "../lvshi-intro/lvshi-intro?id=" + t.currentTarget.dataset.id
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = wx.getStorageSync("lat"), a = wx.getStorageSync("lng");
        app.util.request({
            url: "entry/wxapp/Alllawyers",
            cachetime: "0",
            data: {
                latitude: t,
                longitude: a
            },
            success: function(t) {
                console.log(t.data.data), e.setData({
                    lawyers: t.data.data.hair,
                    city: t.data.data.city,
                    index: t.data.data.index,
                    city_id: t.data.data.city_id
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});