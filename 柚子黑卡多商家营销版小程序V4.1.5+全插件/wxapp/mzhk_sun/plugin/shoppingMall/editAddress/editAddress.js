/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {
        addressInfo: [],
        is_modal_Hidden: !0,
        radioValue: 1,
        AddressDetails: [],
        id: "",
        region: ["广东省", "广州市", "海珠区"]
    },
    bindRegionChange: function(a) {
        this.setData({
            region: a.detail.value
        })
    },
    onLoad: function(a) {
        var e = this;
        app.wxauthSetting();
        var t = a.id;
        e.setData({
            id: t
        });
        var d = wx.getStorageSync("users").openid;
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
                })
            }
        })
    },
    onShow: function() {
        app.func.islogin(app, this)
    },
    radioChange: function(a) {
        var e = a.detail.value;
        this.setData({
            radioValue: e
        })
    },
    saveAddress: function(a) {
        var e = this,
            t = e.data.id,
            d = (e.data.valueid, e.data.region);
        if (t) {
            console.log(i);
            var i = e.data.id,
                s = a.detail.value.username,
                n = a.detail.value.telephone,
                l = d[0],
                o = d[1],
                r = d[2],
                u = a.detail.value.address,
                p = a.detail.value.zipCode,
                c = e.data.radioValue,
                g = wx.getStorageSync("users").openid;
            app.util.request({
                url: "entry/wxapp/editAddress",
                data: {
                    m: app.globalData.Plugin_scoretask,
                    id: i,
                    openid: g,
                    name: s,
                    phone: n,
                    province: l,
                    city: o,
                    zip: r,
                    address: u,
                    postalcode: p,
                    lottery: c
                },
                success: function(a) {
                    wx.navigateBack({
                        delta: 1
                    })
                }
            })
        } else {
            s = a.detail.value.username, n = a.detail.value.telephone, l = d[0], o = d[1], r = d[2], u = a.detail.value.address, p = a.detail.value.zipCode, c = e.data.radioValue, g = wx.getStorageSync("users").openid;
            app.util.request({
                url: "entry/wxapp/setAddress",
                data: {
                    m: app.globalData.Plugin_scoretask,
                    openid: g,
                    name: s,
                    phone: n,
                    province: l,
                    city: o,
                    zip: r,
                    address: u,
                    postalcode: p,
                    lottery: c
                },
                success: function(a) {
                    wx.navigateBack({
                        delta: 1
                    })
                }
            })
        }
    },
    updateUserInfo: function(a) {
        app.wxauthSetting()
    }
});