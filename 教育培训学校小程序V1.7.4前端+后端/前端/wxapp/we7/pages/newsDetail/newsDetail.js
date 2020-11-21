var e = getApp(), o = require("../../resource/js/htmlToWxml.js");

Page({
    data: {
        scrollHeight: 0,
        newsData: {}
    },
    getNewsDetail: function() {
        var n = this;
        wx.request({
            url: "https://wedengta.com/wxnews/getNews?action=DiscNewsContent&type=4&id=1478677877_1406730_1_9",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(t) {
                var s = t.data;
                if (0 == s.ret) {
                    var a = JSON.parse(s.content);
                    a.content = o.html2json(a.sContent), a.time = e.util.formatTime(1e3 * a.iTime), 
                    n.setData({
                        newsData: a
                    });
                } else console.log("数据拉取失败");
            },
            fail: function(e) {
                console.log("数据拉取失败");
            }
        });
    },
    stockClick: function(e) {
        var o = e.currentTarget.dataset.seccode, n = e.currentTarget.dataset.secname;
        console.log("stockClick:" + o + ";secName:" + n);
    },
    onLoad: function(e) {
        this.getNewsDetail(), console.log("onLoad");
    },
    onShow: function() {
        console.log("onShow");
    },
    onReady: function() {
        console.log("onReady");
    },
    onHide: function() {
        console.log("onHide");
    },
    onUnload: function() {
        console.log("onUnload");
    }
});