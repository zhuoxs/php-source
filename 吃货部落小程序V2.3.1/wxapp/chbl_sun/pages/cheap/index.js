var _data;

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp();

Page({
    data: (_data = {
        currentType: 0
    }, _defineProperty(_data, "currentType", 0), _defineProperty(_data, "listHeight", 0), 
    _defineProperty(_data, "page", 0), _data),
    statusTap: function(t) {
        this.setData({
            currentType: t.currentTarget.dataset.index
        }), console.log(t);
        t.currentTarget.dataset.index, wx.getStorageSync("latitude"), wx.getStorageSync("longitude");
    },
    goShopsDetails: function(t) {
        wx.navigateTo({
            url: "../goods-detail/index?gid=" + t.currentTarget.dataset.gid
        });
    },
    getWindowHeight: function() {
        console.log(1111);
        var e = this;
        wx.getSystemInfo({
            success: function(t) {
                console.log(t), console.log("height=" + t.windowHeight), console.log("width=" + t.windowWidth), 
                e.setData({
                    listHeight: t.windowHeight - t.windowWidth / 750 * 300 + 45
                });
            }
        });
    },
    calculWidth: function(t) {
        var e = this;
        setTimeout(function() {
            var t = e.data.carData;
            console.log(e.data), console.log(e.data.carData), 3 < t.length && e.setData({
                limit: "min-width"
            });
        }, 800);
    },
    onLoad: function(a) {
        this.getWindowHeight();
        var o = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), o.get_goods_list(0);
        var t = wx.getStorageSync("url");
        if (t) {
            var e = wx.getStorageSync("tab");
            o.setData({
                current: a.currentIndex,
                tab: e,
                url: t
            });
        } else app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                console.log("url22222222222222222222"), wx.setStorageSync("url", t.data);
                var e = wx.getStorageSync("tab");
                o.setData({
                    url: t.data,
                    tab: e,
                    current: a.currentIndex
                });
            }
        });
        app.util.request({
            url: "entry/wxapp/Type",
            cachetime: "0",
            success: function(t) {
                console.log(t), o.setData({
                    carData: t.data
                });
            }
        });
    },
    onReachBottom: function() {
        console.log(111);
        var t = this, e = t.data.page;
        e++, t.setData({
            page: e
        }), t.get_goods_list(e);
    },
    get_goods_list: function(n) {
        var i = this;
        console.log(112222), console.log(n), wx.getLocation({
            type: "wgs84",
            success: function(t) {
                console.log(t), wx.setStorageSync("latitude", t.latitude), wx.setStorageSync("longitude", t.longitude);
                var e = wx.getStorageSync("county"), a = t.latitude, o = t.longitude;
                app.util.request({
                    url: "entry/wxapp/goodList",
                    cachetime: "0",
                    data: {
                        currCityId: e.id,
                        typeIndex: 1,
                        latitude: a,
                        longitude: o,
                        page: n
                    },
                    success: function(t) {
                        if (2 == t.data) wx.showToast({
                            title: "已经没有内容了哦！！！",
                            icon: "none"
                        }); else {
                            var e = i.data.goodList;
                            e = e ? e.concat(t.data) : t.data, i.setData({
                                goodList: e
                            });
                        }
                    },
                    fail: function(t) {
                        wx.showModal({
                            title: "请授权获得地理信息",
                            content: '点击右上角...，进入关于页面，再点击右上角...，进入设置,开启"使用我的地理位置"'
                        });
                    }
                });
            }
        });
    },
    goTap: function(t) {
        console.log(t);
        var e = this;
        e.setData({
            current: t.currentTarget.dataset.index
        }), 0 == e.data.current && wx.redirectTo({
            url: "../first/index"
        }), 2 == e.data.current && wx.redirectTo({
            url: "../eater-card/index?currentIndex=2"
        }), 3 == e.data.current && wx.redirectTo({
            url: "../mine/index?currentIndex=3"
        });
    },
    goGoodsDetails: function(t) {
        console.log(t), wx.navigateTo({
            url: "../goods-detail/index?gid=" + t.currentTarget.dataset.gid
        });
    },
    tabClick: function(t) {
        console.log(t);
        var e = this, a = t.currentTarget.dataset.id, o = wx.getStorageSync("county");
        this.setData({
            currentType: t.currentTarget.dataset.index,
            page: 0
        });
        var n = wx.getStorageSync("latitude"), i = wx.getStorageSync("longitude");
        app.util.request({
            url: "entry/wxapp/goodList",
            cachetime: "0",
            data: {
                currCityId: o.id,
                typeIndex: 1,
                tid: a,
                latitude: n,
                longitude: i
            },
            success: function(t) {
                console.log(t), 2 == t.data ? e.setData({
                    goodList: []
                }) : e.setData({
                    goodList: t.data
                });
            }
        });
    },
    allClick: function(t) {
        this.setData({
            curIndex: t.currentTarget.dataset.index
        });
    },
    onReady: function() {},
    onShow: function() {
        this.calculWidth();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onShareAppMessage: function() {}
});