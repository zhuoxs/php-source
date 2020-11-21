var app = getApp();

Page({
    data: {},
    onLoad: function() {
        this.setData({
            address: app.globalData.location,
            locationList: app.globalData.locationList
        });
    },
    back: function() {
        wx.navigateBack();
    },
    setLocation: function(a) {
        var t = a.currentTarget.dataset.lat, e = a.currentTarget.dataset.lng, n = a.currentTarget.dataset.location, o = getCurrentPages();
        o[o.length - 2].setLocation(t, e, n), wx.navigateBack();
    }
});