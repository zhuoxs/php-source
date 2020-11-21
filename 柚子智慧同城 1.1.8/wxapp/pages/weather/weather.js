var e = require("../../zhy/component/libs/bmap-wx.min.js");

Page({
    data: {
        weatherData: ""
    },
    onLoad: function() {
        var a = this;
        new e.BMapWX({
            ak: "gdRDxogqfuAqCPtMBxUD2jUSYPjsVgat"
        }).weather({
            fail: function(e) {
                console.log("fail!!!!");
            },
            success: function(e) {
                console.log("success!!!");
                var t = e.currentWeather[0];
                t = "城市：" + t.currentCity + "\nPM2.5：" + t.pm25 + "\n日期：" + t.date + "\n温度：" + t.temperature + "\n天气：" + t.weatherDesc + "\n风力：" + t.wind + "\n", 
                a.setData({
                    weatherData: t
                });
            }
        });
    }
});