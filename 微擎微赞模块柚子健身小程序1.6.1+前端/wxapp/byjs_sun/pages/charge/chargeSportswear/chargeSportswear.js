Page({
    data: {
        fight1: [ {
            img: "http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png",
            address: "马来西亚",
            picer: "1990"
        }, {
            img: "http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png",
            address: "马来西亚",
            picer: "1990"
        }, {
            img: "http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png",
            address: "马来西亚",
            picer: "1990"
        } ],
        screenNumber: 0,
        screenPicer: 0
    },
    onLoad: function(e) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    screenNumber: function() {
        var e = Number(JSON.parse(JSON.stringify(this.data.screenNumber))) + 1;
        2 < e ? this.setData({
            screenNumber: 0
        }) : this.setData({
            screenNumber: e
        });
    },
    screenPicer: function() {
        var e = Number(JSON.parse(JSON.stringify(this.data.screenPicer))) + 1;
        2 < e ? this.setData({
            screenPicer: 0
        }) : this.setData({
            screenPicer: e
        });
    }
});