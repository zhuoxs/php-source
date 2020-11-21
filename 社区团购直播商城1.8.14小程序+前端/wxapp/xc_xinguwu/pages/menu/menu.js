var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        console.log(app.toolbar), null == app.toolbar || this.setData({
            toolbar: app.toolbar
        });
    },
    onReady: function() {
        app.look.footer(this), app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});