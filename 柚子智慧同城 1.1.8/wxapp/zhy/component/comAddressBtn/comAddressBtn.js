Component({
    properties: {
        disabled: {
            type: Boolean,
            value: !1
        }
    },
    externalClasses: [ "btn" ],
    data: {
        gps: !1
    },
    attached: function() {
        var t = this;
        wx.getLocation({
            type: "wgs84",
            success: function(s) {
                s.latitude, s.longitude;
                t.setData({
                    gps: !0
                });
            },
            fail: function(s) {
                t.setData({
                    gps: !1
                });
            }
        });
    },
    methods: {
        onAddressTap: function() {
            var t = this;
            wx.chooseLocation({
                success: function(s) {
                    t.triggerEvent("getAddress", s);
                }
            });
        },
        getAddress: function(t) {
            t.detail.authSetting["scope.userLocation"] ? (this.setData({
                gps: !0
            }), this.onAddressTap()) : this.setData({
                gps: !1
            });
        }
    }
});