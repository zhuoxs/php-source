var app = getApp();

Page({
    data: {
        wendaArr1: [],
        wendaArr: [],
        array: [ "图文", "挂号", "在线", "电话", "课堂" ],
        index: ""
    },
    onLoad: function(a) {
        var n = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: n
        });
        var o = this;
        app.util.request({
            url: "entry/wxapp/Selmypay",
            data: {
                use_openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                console.log(a);
                var n = o.data.wendaArr, e = a.data.data.countmoney;
                n = Array.from(e), o.setData({
                    wendaArr: n,
                    wendaArr1: e
                });
            }
        });
    },
    bindMultiPickerChange: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value);
        var n, e = this, o = [], t = e.data.wendaArr1;
        n = Array.from(t);
        for (var r = e.data.array, i = 0, l = n.length; i < l; i++) console.log(n[i].leixing, r[a.detail.value]), 
        n[i].leixing == r[a.detail.value] && o.push(n[i]);
        e.setData({
            wendaArr: o
        }), this.setData({
            multiIndex: a.detail.value
        });
    },
    input: function(a) {
        console.log(a);
        for (var n = a.detail.value, e = [], o = this.data.wendaArr1, t = [], r = 0, i = (t = Array.from(o)).length; r < i; r++) -1 != t[r].leixing.indexOf(n) && e.push(t[r]);
        this.setData({
            wendaArr: e
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});