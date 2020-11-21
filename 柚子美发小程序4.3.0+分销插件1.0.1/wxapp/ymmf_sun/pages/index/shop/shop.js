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
        shoppping: [],
        navTile: "分店",
        branch: []
    }, _defineProperty(_data, "shoppping", []), _defineProperty(_data, "curInde", "0"), 
    _defineProperty(_data, "shopList", [ {
        shopname: "柚子美发",
        shoplogo: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152670871389.png",
        branch: "湖里店",
        phone: "0592-666666",
        address: "福建省厦门市集美区杏林湾路厦门市集美区杏林湾路"
    }, {
        shopname: "柚子美发",
        shoplogo: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152670871389.png",
        branch: "思明店",
        phone: "0592-666666",
        address: "福建省厦门市集美区杏林湾路"
    } ]), _data),
    onLoad: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
    },
    curAddress: function(t) {
        var e = t.currentTarget.dataset.index, a = t.currentTarget.dataset.address;
        this.setData({
            curindex: e
        }), wx.openLocation({
            name: a,
            latitude: 24.5169881473,
            longitude: 118.1312012672,
            scale: 18,
            address: a
        });
    },
    onShow: function() {
        var n = this, o = wx.getStorageSync("openid"), r = wx.getStorageSync("Switch");
        console.log(r), wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var e = t.latitude, a = t.longitude;
                app.util.request({
                    url: "entry/wxapp/Address",
                    data: {
                        openid: o,
                        lat: e,
                        lon: a,
                        Switch: r
                    },
                    success: function(t) {
                        console.log(t), n.setData({
                            branch: t.data
                        }), n.shopp();
                    }
                });
            }
        });
    },
    shopp: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Shopps",
            success: function(t) {
                console.log(t), e.setData({
                    shoppping: t.data
                });
            }
        });
    },
    chooseNav: function(t) {
        var e = this, a = e.data.branch, n = t.currentTarget.dataset.index, o = a[n].id, r = wx.getStorageSync("openid");
        console.log(o), app.util.request({
            url: "entry/wxapp/SwitchBranch",
            cachetime: "0",
            data: {
                id: o,
                openid: r
            },
            success: function(t) {
                console.log(t.data), 1 == t.data && (a[n].switch = 1, e.setData({
                    branch: a
                }), wx.reLaunch({
                    url: "/ymmf_sun/pages/index/index"
                }), wx.setStorageSync("isSwitch", 1), wx.setStorageSync("build_id", o));
            }
        });
    },
    dialog: function(t) {
        var e = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    openMap: function(t) {
        wx.getLocation({
            type: "wgs84",
            success: function(t) {
                t.latitude, t.longitude, t.speed, t.accuracy;
            }
        });
    },
    toShopdet: function(t) {
        wx.navigateTo({
            url: "../shopdet/shopdet"
        });
    }
});