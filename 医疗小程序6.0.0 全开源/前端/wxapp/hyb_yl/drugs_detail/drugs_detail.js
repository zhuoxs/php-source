Page({
    data: {
        broadcastArr: [ {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/active_01.png"
        } ],
        img: "../images/active_ve_01.jpg",
        title: "上班族支付体检基本套餐",
        names: "爱因斯坦",
        pay: "￥1293",
        now_num: 1
    },
    onLoad: function(n) {},
    onReady: function() {},
    yuClick: function() {
        this.setData({
            overflow: "hidden"
        });
    },
    numInput: function(n) {
        n.detail.value <= 0 && (n.detail.value = 1), this.setData({
            now_num: n.detail.value
        });
    },
    subClick: function() {
        var n = this.data.now_num;
        --n <= 0 && (n = 1), this.setData({
            now_num: n
        });
    },
    addClick: function() {
        this.data.now_num++, this.setData({
            now_num: this.data.now_num
        });
    },
    payClick: function() {
        this.setData({
            overflow: ""
        });
    },
    guanbi: function() {
        this.setData({
            overflow: ""
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});