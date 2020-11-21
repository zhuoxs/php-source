Page({
    data: {
        title: "白细胞",
        values: "5.51  10^9/L",
        now: 300,
        lowStandard: 125,
        highStandard: 350,
        overflow: !1,
        conArr: [ {
            con: "引起胃胀的病因较为复杂，其中急性胃炎、胃 神经官能症、十二指肠溃疡、胃癌。",
            img: "../images/header_01.png",
            name: "张三丰",
            time: "刚刚",
            imgArr: [ {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/active_01.png",
                name: "药品名字"
            } ]
        } ],
        imgArr: []
    },
    onLoad: function(a) {
        var o = this, t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
        var n = o.data.highStandard, e = o.data.lowStandard, r = e - (n - e), i = n + (n - e) - r, c = (o.data.now - r) / i * 100;
        o.setData({
            left: c
        });
    },
    overClick: function() {
        this.setData({
            overflow: !this.data.overflow
        });
    },
    drugsRecommend: function() {
        wx.navigateTo({
            url: "/hyb_yl/drugs_recommend/drugs_recommend"
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = wx.getStorageSync("imgArr");
        console.log(a), this.setData({
            imgArr: a
        });
    },
    valInput: function(a) {
        this.setData({
            value: a.detail.value
        });
    },
    sendClick: function() {
        var a = this.data.imgArr, o = this.data.value, t = this.data.conArr, n = {
            img: "../images/header_01.png",
            name: "张三丰",
            time: "刚刚"
        };
        n.con = o, n.imgArr = a, t.push(n), this.setData({
            conArr: t,
            value: ""
        });
    },
    onHide: function() {
        wx.removeStorageSync("imgArr");
    },
    onUnload: function() {
        wx.removeStorageSync("imgArr");
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});