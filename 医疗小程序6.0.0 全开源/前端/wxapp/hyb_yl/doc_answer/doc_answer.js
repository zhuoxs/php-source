Page({
    data: {},
    onLoad: function(n) {},
    subClick: function(n) {
        console.log(n);
        var o = n.detail.value.answer;
        wx.showLoading({
            title: ""
        }), setTimeout(function() {
            wx.hideLoading(), wx.showToast({
                title: "保存成功",
                success: function() {
                    wx.redirectTo({
                        url: "/hyb_yl/doc_answer_detail/doc_answer_detail?con=" + o
                    });
                }
            });
        }, 500);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});