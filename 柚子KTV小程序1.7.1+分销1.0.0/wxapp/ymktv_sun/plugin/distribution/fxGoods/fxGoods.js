Page({
    data: {
        curIndex: 0,
        nav: [ "全部", "普通", "抢购", "拼团", "砍价", "集卡" ],
        orderlist: [ {
            id: 1,
            gname: "名称啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊",
            img: "http://wx2.sinaimg.cn/small/005ysW6agy1ftkrhn7x33j306o0500ue.jpg",
            price: "20.00"
        }, {
            id: 1,
            gname: "名称啊啊啊啊啊",
            img: "http://wx2.sinaimg.cn/small/005ysW6agy1ftkrhn7x33j306o0500ue.jpg",
            price: "20.00"
        }, {
            id: 1,
            gname: "名称啊啊啊啊啊",
            img: "http://wx2.sinaimg.cn/small/005ysW6agy1ftkrhn7x33j306o0500ue.jpg",
            price: "20.00"
        } ]
    },
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bargainTap: function(n) {
        var a = parseInt(n.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
    }
});