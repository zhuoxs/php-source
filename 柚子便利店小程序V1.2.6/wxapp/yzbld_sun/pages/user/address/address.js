Page({
    data: {
        status: !1,
        addr: [ {
            name: "陈少勇",
            phone: "13000000000",
            addr: "福建省厦门市集美区杏林街道"
        }, {
            name: "陈少勇",
            phone: "13000000000",
            addr: "福建省厦门市集美区杏林街道"
        } ]
    },
    onLoad: function(n) {
        0 == this.data.addr.length && this.setData({
            status: !0
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toEditaddr: function(n) {
        wx.navigateTo({
            url: "../editaddr/editaddr"
        });
    },
    clickCancel: function(n) {
        var t = this, a = n.currentTarget.dataset.index, o = t.data.addr;
        wx.showModal({
            title: "提示",
            content: "确定删除该地址吗",
            success: function(n) {
                n.confirm ? (o.splice(a, 1), t.setData({
                    addr: o
                })) : n.cancel && console.log("用户点击取消");
            }
        });
    }
});