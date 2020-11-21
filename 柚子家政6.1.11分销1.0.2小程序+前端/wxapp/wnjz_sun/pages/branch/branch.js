var app = getApp();

Page({
    data: {
        navTile: "分店",
        isIpx: app.globalData.isIpx,
        whichone: 7
    },
    onLoad: function() {
        app.editTabBar();
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }), wx.setNavigationBarTitle({
            title: a.data.navTile
        });
    },
    onReady: function() {
        app.getNavList(2);
    },
    toShopdet: function(t) {
        wx.navigateTo({
            url: "shopdet/shopdet"
        });
    },
    onShow: function() {
        var n = this, i = wx.getStorageSync("openid"), c = wx.getStorageSync("Switch");
        wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude, e = t.longitude;
                app.util.request({
                    url: "entry/wxapp/Address",
                    data: {
                        openid: i,
                        lat: a,
                        lon: e,
                        Switch: c
                    },
                    success: function(t) {
                        console.log(t), n.setData({
                            branch: t.data
                        });
                    }
                });
            }
        });
    },
    chooseNav: function(t) {
        var a = this, e = a.data.branch, n = t.currentTarget.dataset.index, i = e[n].id, c = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/SwitchBranch",
            cachetime: "0",
            data: {
                id: i,
                openid: c
            },
            success: function(t) {
                1 == t.data && (e[n].switch = 1, a.setData({
                    branch: e
                }), wx.reLaunch({
                    url: "/wnjz_sun/pages/index/index?Switch=1"
                }), wx.setStorageSync("isSwitch", 1), wx.setStorageSync("build_id", i));
            }
        });
    }
});