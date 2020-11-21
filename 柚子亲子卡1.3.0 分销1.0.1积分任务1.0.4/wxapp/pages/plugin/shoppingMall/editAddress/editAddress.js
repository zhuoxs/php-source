var app = getApp();

Page({
    data: {
        addressInfo: [],
        radioValue: 1,
        AddressDetails: [],
        id: "",
        region: [ "广东省", "广州市", "海珠区" ]
    },
    bindRegionChange: function(a) {
        this.setData({
            region: a.detail.value
        });
    },
    onLoad: function(a) {
        var e = this, t = a.id;
        e.setData({
            id: t
        });
        var d = wx.getStorageSync("user").openid;
        app.util.request({
            url: "entry/wxapp/getAddressDetail",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: d,
                id: t
            },
            success: function(a) {
                1 == a.data.lottery ? e.setData({
                    value: !0
                }) : e.setData({
                    values: !0
                }), e.setData({
                    AddressDetails: a.data
                });
            }
        });
    },
    radioChange: function(a) {
        var e = a.detail.value;
        this.setData({
            radioValue: e
        });
    },
    saveAddress: function(a) {
        var e = this, t = e.data.id, d = (e.data.valueid, e.data.region);
        if (t) {
            console.log(i);
            var i = e.data.id, s = a.detail.value.username, l = a.detail.value.telephone, o = d[0], n = d[1], r = d[2], u = a.detail.value.address, p = a.detail.value.zipCode, c = e.data.radioValue, g = wx.getStorageSync("user").openid;
            app.util.request({
                url: "entry/wxapp/editAddress",
                data: {
                    m: app.globalData.Plugin_scoretask,
                    id: i,
                    openid: g,
                    name: s,
                    phone: l,
                    province: o,
                    city: n,
                    zip: r,
                    address: u,
                    postalcode: p,
                    lottery: c
                },
                success: function(a) {
                    wx.navigateBack({
                        delta: 1
                    });
                }
            });
        } else {
            s = a.detail.value.username, l = a.detail.value.telephone, o = d[0], n = d[1], r = d[2], 
            u = a.detail.value.address, p = a.detail.value.zipCode, c = e.data.radioValue, g = wx.getStorageSync("user").openid;
            app.util.request({
                url: "entry/wxapp/setAddress",
                data: {
                    m: app.globalData.Plugin_scoretask,
                    openid: g,
                    name: s,
                    phone: l,
                    province: o,
                    city: n,
                    zip: r,
                    address: u,
                    postalcode: p,
                    lottery: c
                },
                success: function(a) {
                    wx.navigateBack({
                        delta: 1
                    });
                }
            });
        }
    }
});