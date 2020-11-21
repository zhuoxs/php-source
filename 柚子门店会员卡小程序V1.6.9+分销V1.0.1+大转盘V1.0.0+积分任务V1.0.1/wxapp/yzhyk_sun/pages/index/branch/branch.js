var app = getApp();

Page({
    data: {
        navTile: "附近门店",
        stores: [],
        currstore: {}
    },
    onLoad: function(t) {
        var n = this;
        wx.setNavigationBarTitle({
            title: n.data.navTile
        }), app.get_imgroot().then(function(e) {
            app.get_store_info().then(function(t) {
                n.setData({
                    currstore: t,
                    imgroot: e
                }), app.get_wxuser_location().then(function(t) {
                    app.util.request({
                        url: "entry/wxapp/GetStores",
                        cachetime: "0",
                        data: {
                            latitude: t.latitude,
                            longitude: t.longitude
                        },
                        success: function(t) {
                            console.log(t.data), n.setData({
                                stores: t.data
                            });
                        }
                    });
                });
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    chooseNav: function(t) {
        var e = t.currentTarget.dataset.index;
        app.set_store_info(this.data.stores[e]), wx.navigateBack({});
    },
    dialog: function(t) {
        var e = t.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: e
        });
    }
});