var _driver = require("../../../modules/driver"), _address = require("../../../modules/address"), addressModule = new _address.address(), driverModule = new _driver.driver(), app = getApp();

Page({
    data: {
        PageCur: "driver_index",
        info: {}
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        this.getInfo(), this.getPosition();
    },
    getPosition: function() {
        addressModule.getCurrentCityMessage().then(function(e) {
            driverModule.updatePosition({
                lat: e.location.lat,
                lng: e.location.lng,
                name: e.title,
                address: e.address
            }).then(function(e) {}, function(e) {});
        }, function(e) {});
    },
    getInfo: function() {
        var t = this;
        driverModule.driverInfo().then(function(e) {
            e.is_driver || t.setData({
                PageCur: "my_center"
            }), t.setData({
                info: e
            });
        }, function(e) {});
    },
    switch: function(e) {
        var t = this.data.info;
        t.info.statef = e.detail.status, this.setData({
            info: t
        });
    },
    NavChange: function(e) {
        app.saveFromId(e.detail.formId), this.data.info.is_driver && (this.getPosition(), 
        this.setData({
            PageCur: e.currentTarget.dataset.cur
        }));
    },
    onShareAppMessage: function() {
        return app.userShare();
    }
});