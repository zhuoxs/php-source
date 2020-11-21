Page({
    data: {
        region: [ "福建省", "厦门市", " " ],
        customItem: "全部",
        flag: "true"
    },
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindRegionChange: function(n) {
        this.setData({
            region: n.detail.value
        });
    },
    formSubmit: function(n) {
        var e = "", o = !0;
        "" == n.detail.value.uname ? e = "请先填写名字" : /^1(3|4|5|7|8)\d{9}$/.test(n.detail.value.phone) ? "" == n.detail.value.region ? e = "请选择地区" : "" == n.detail.value.detaddr ? e = "请填写详细地址" : o = "false" : e = "请填写正确手机号码", 
        1 == o && wx.showModal({
            title: "提示",
            content: e,
            showCancel: !1
        });
    },
    toAddress: function(n) {
        wx.navigateTo({
            url: "../address/address"
        });
    }
});