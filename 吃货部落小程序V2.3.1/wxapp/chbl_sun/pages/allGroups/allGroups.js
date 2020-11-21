Page({
    data: {
        headers: [ "../../resource/images/first/tanchuan.png", "../../resource/images/first/tanchuan.png", "../../resource/images/first/tanchuan.png", "../../resource/images/first/tanchuan.png", "../../resource/images/first/tanchuan.png", "../../resource/images/first/tanchuan.png", "../../resource/images/first/tanchuan.png", "../../resource/images/first/tanchuan.png", "../../resource/images/first/tanchuan.png", "../../resource/images/first/tanchuan.png" ]
    },
    onLoad: function(n) {
        for (var a = this, e = [], s = 0, r = a.data.headers.length; s < r; s += 5) e.push(a.data.headers.slice(s, s + 5));
        console.log(e), a.setData({
            row: e
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});