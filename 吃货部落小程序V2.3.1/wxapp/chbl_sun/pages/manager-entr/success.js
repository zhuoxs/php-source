var app = getApp();

Page({
    data: {
        tabBar: {
            color: "#9E9E9E",
            selectedColor: "#f00",
            backgroundColor: "#fff",
            borderStyle: "#ccc",
            list: [ {
                pagePath: "/pages/index/index",
                text: "主页",
                iconPath: "../../resource/images/entr/gongzuotai.png",
                selectedIconPath: "../../resource/images/entr/gongzuotai-h.png",
                selectedColor: "#ce0000",
                active: !0
            }, {
                pagePath: "/pages/village/city/city",
                text: "目的地",
                iconPath: "../../resource/images/entr/dingdan.png",
                selectedIconPath: "../../resource/images/entr/dingdan-h.png",
                selectedColor: "#ce0000",
                active: !1
            }, {
                pagePath: "/pages/mine/mine",
                text: "我的",
                iconPath: "../../resource/images/entr/shezhi.png",
                selectedIconPath: "../../resource/images/entr/shezhi-h.png",
                selectedColor: "#ce0000",
                active: !1
            } ],
            position: "bottom"
        }
    },
    onLoad: function(e) {
        console.log(e), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});