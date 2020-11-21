getApp();

Page({
    data: {
        longitude: "108.947040",
        latitude: "34.259430"
    },
    onLoad: function() {
        var t = this;
        wx.getLocation({
            type: "gcj02",
            success: function(e) {
                var o = e.latitude, a = e.longitude;
                console.log("yval:", o), console.log("xval:", a), t.setData({
                    latitude: e.latitude,
                    longitude: e.longitude
                });
            }
        });
    },
    regionchange: function(t) {
        if (console.log(t), "end" == t.type && ("scale" == t.causedBy || "drag" == t.causedBy)) {
            console.log(t);
            var e = this;
            this.mapCtx = wx.createMapContext("map4select"), this.mapCtx.getCenterLocation({
                type: "gcj02",
                success: function(t) {
                    console.log(t, 11111), e.setData({
                        latitude: t.latitude,
                        longitude: t.longitude,
                        circles: [ {
                            latitude: t.latitude,
                            longitude: t.longitude,
                            color: "#FF0000DD",
                            fillColor: "#d1edff88",
                            radius: 500,
                            strokeWidth: 1
                        } ]
                    });
                }
            });
        }
    },
    my_location: function(t) {
        this.onLoad();
    }
});