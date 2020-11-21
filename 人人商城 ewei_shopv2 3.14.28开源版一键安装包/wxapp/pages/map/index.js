var e = getApp().requirejs("core");

Page({
    data: {
        lng: 0,
        lat: 0,
        scale: 13,
        name: "未填写",
        address: "地址：未填写",
        tel1: "",
        tel2: "",
        logo: "/static/images/noface.png",
        markers: [ {
            iconPath: "/static/images/location.png",
            id: 0,
            longitude: 0,
            latitude: 0,
            width: 30,
            height: 30,
            label: {
                content: "未填写",
                color: "#666666",
                fontSize: 12,
                borderRadius: 10,
                bgColor: "#ffffff",
                padding: 5,
                display: "ALWAYS",
                textAlign: "center",
                x: -20,
                y: -60
            }
        } ],
        circles: [ {
            longitude: 0,
            latitude: 0,
            color: "#4e73f1DD",
            fillColor: "#4e73f1AA",
            radius: 15,
            strokeWidth: 1
        } ]
    },
    get_list: function() {},
    regionchange: function(e) {},
    markertap: function(e) {},
    controltap: function(e) {},
    onLoad: function(t) {
        var a = this;
        e.get("shop.cityexpress.map", {}, function(e) {
            a.setData({
                lng: e.cityexpress.lng,
                lat: e.cityexpress.lat,
                scale: e.cityexpress.zoom,
                name: e.cityexpress.name,
                address: e.cityexpress.address,
                tel1: e.cityexpress.tel1,
                tel2: e.cityexpress.tel2,
                logo: e.cityexpress.logo,
                "markers[0].longitude": e.cityexpress.lng,
                "markers[0].latitude": e.cityexpress.lat,
                "markers[0].label.content": e.cityexpress.name,
                "circles[0].longitude": e.cityexpress.lng,
                "circles[0].latitude": e.cityexpress.lat,
                "circles[0].radius": parseInt(e.cityexpress.range)
            });
        });
    },
    call: function() {
        var e = this;
        "" == e.data.tel1 || "" == e.data.tel2 ? ("" != e.data.tel1 && wx.makePhoneCall({
            phoneNumber: e.data.tel1
        }), "" != e.data.tel2 && wx.makePhoneCall({
            phoneNumber: e.data.tel2
        })) : e.setData({
            listout: "out",
            listin: "in"
        });
    },
    calldown: function() {
        this.setData({
            listout: "",
            listin: ""
        });
    },
    callup: function(e) {
        wx.makePhoneCall({
            phoneNumber: e.target.dataset.tel
        });
    }
});