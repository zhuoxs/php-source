var a = new getApp();

a.siteInfo.uniacid;

Page({
    data: {
        weather: {},
        weatherSet: [],
        farm_name: ""
    },
    onLoad: function(e) {
        var t = wx.getStorageSync("kundian_farm_weather"), n = JSON.parse(e.weatherSet);
        this.setData({
            weatherSet: n,
            weather: t,
            farm_name: e.farm_name
        }), a.util.setNavColor(a.siteInfo.uniacid);
    },
    intoFarmAddress: function(a) {
        var e = this.data, t = e.weatherSet, n = e.farm_name;
        wx.openLocation({
            latitude: parseFloat(t.latitude),
            longitude: parseFloat(t.longitude),
            name: n
        });
    }
});