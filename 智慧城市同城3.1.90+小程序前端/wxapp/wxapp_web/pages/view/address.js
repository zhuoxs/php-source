var _base = require("../../../we7/resource/js/base64"), _webview = require("../../../we7/resource/js/webview");

Page({
    data: {
        url: ""
    },
    onLoad: function(e) {
        this.setData(e);
        var n = this;
        n.setData({
            url: ""
        }), wx.chooseAddress({
            success: function(e) {
                var o = decodeURIComponent(n.data.back);
                console.log((0, _base.base64_encode)(encodeURI(JSON.stringify(e)))), o = o + "&wxAddress=" + (0, 
                _base.base64_encode)(encodeURI(JSON.stringify(e))), console.log(o), (0, _webview.backApp)(o);
            },
            fail: function() {
                wx.navigateBack();
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});