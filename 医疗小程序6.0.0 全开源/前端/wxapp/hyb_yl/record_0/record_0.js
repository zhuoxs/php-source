Page({
    data: {
        date: "",
        values: "",
        values1: "山西大医院",
        headerImg: "../images/active_04.jpg"
    },
    onLoad: function(o) {
        var e = o.hzid, a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        }), this.setData({
            backgroundColor: a,
            hzid: e
        });
    },
    bindDateChange: function(o) {
        console.log("picker发送选择改变，携带值为", o.detail.value), this.setData({
            date: o.detail.value
        });
    },
    inputClick: function(o) {
        var e = o.detail.value;
        this.setData({
            values: e
        });
    },
    chooseImg: function() {
        var a = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(o) {
                var e = o.tempFilePaths;
                a.setData({
                    headerImg: e
                });
            }
        });
    },
    subClick: function(o) {
        this.data.headerImg;
        var e = JSON.stringify(o.detail.value);
        console.log(e), "" == e.dates ? wx.showToast({
            title: "请选择体检时间"
        }) : "" == e.pic ? wx.showToast({
            title: "请填写体检价格"
        }) : wx.navigateTo({
            url: "/hyb_yl/record_1/record_1?obj=" + e
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