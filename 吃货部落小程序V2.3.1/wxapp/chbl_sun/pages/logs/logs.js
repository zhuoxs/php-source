var util = require("../../resource/js/utils/util.js");

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
            logs: (wx.getStorageSync("logs") || []).map(function(o) {
                return util.formatTime(new Date(o));
            })
        });
    }
});