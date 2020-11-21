var t = new getApp();

Page({
    data: {
        src: ""
    },
    onLoad: function(e) {
        var i = e.src;
        this.setData({
            src: i
        }), this.videoContext = wx.createVideoContext("myVideo", this), t.util.setNavColor(t.siteInfo.uniacid);
    },
    onHide: function() {
        this.videoContext.pause();
    }
});