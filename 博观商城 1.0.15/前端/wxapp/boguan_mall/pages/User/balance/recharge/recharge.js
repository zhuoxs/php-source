Page({
    data: {
        show: !1,
        hide: !0,
        swith: 0,
        recharge_price: 0
    },
    onLoad: function(t) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    otherPrice: function(t) {
        this.setData({
            show: !this.data.show,
            hide: !this.data.hide,
            focus: !0,
            swith: -1
        });
    },
    tabSwith: function(t) {
        var n = t.currentTarget.dataset.index;
        this.setData({
            swith: n,
            show: !1,
            hide: !0
        });
    },
    getPrice: function(t) {
        console.log(t), this.setData({
            recharge_price: t.detail.value
        });
    }
});