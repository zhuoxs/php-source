var e = getApp();

Page({
    data: {
        markers: [ {
            iconPath: "../../../pages/img/address_module.png",
            id: 0,
            latitude: "",
            longitude: "",
            width: 20,
            height: 20,
            zIndex: 999,
            callout: {
                content: "",
                color: "#000000",
                fontSize: "14",
                borderRadius: 5,
                padding: 5,
                display: "ALWAYS",
                textAlign: "center"
            }
        } ],
        polygons: [ {
            points: [],
            fillColor: "#2277ff60",
            strokeWidth: 1,
            strokeColor: "#2277ff"
        } ]
    },
    onLoad: function(o) {
        var t = this;
        e.getInformation(function(e) {
            var o = t.data.markers;
            o[0].latitude = e.info.latitude, o[0].longitude = e.info.longitude, o[0].callout.content = e.info.name, 
            o[0].address = e.info.address;
            var a = {
                store_logo: e.info.logo,
                store_name: e.info.name,
                store_address: e.info.address,
                store_phone: e.info.tel
            }, n = t.data.polygons, r = [];
            for (var i in e.deliver.delivery_area) {
                var d = {
                    latitude: e.deliver.delivery_area[i].lat,
                    longitude: e.deliver.delivery_area[i].lng
                };
                r.push(d);
            }
            n[0].points = r, t.setData({
                markers: o,
                storeInfo: a,
                polygons: n
            });
        });
    },
    storeCall: function(e) {
        wx.makePhoneCall({
            phoneNumber: e.currentTarget.dataset.phone
        });
    }
});