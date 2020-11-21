var util = require("../../../style/utils/util.js");

Page({
    data: {
        logs: []
    },
    onLoad: function() {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), this.setData({
            logs: (wx.getStorageSync("logs") || []).map(function(t) {
                return util.formatTime(new Date(t));
            })
        });
    }
});