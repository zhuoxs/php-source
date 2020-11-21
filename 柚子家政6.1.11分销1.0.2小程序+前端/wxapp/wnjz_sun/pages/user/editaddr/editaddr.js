Page({
    data: {
        region: [ "福建省", "厦门市", " " ],
        customItem: "全部",
        flag: "true"
    },
    onLoad: function(o) {
        this.setData({
            orderid: o.id
        });
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        console.log("options", this.data.orderid);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindRegionChange: function(o) {
        this.setData({
            region: o.detail.value
        });
    },
    formSubmit: function(o) {
        var n = "", t = !0;
        "" == o.detail.value.uname ? n = "请先填写名字" : /^1(3|4|5|7|8)\d{9}$/.test(o.detail.value.phone) ? "" == o.detail.value.region ? n = "请选择地区" : "" == o.detail.value.detaddr ? n = "请填写详细地址" : t = "false" : n = "请填写正确手机号码", 
        1 == t && wx.showModal({
            title: "提示",
            content: n,
            showCancel: !1
        });
    },
    toAddress: function(o) {
        wx.navigateTo({
            url: "../address/address"
        });
    }
});