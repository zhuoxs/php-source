if (typeof wx === 'undefined') var wx = getApp().core;
Page({

    /**
     * 页面的初始数据
     */
    data: {
        url: "",
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
        getApp().page.onLoad(this, options);
        if (!getApp().core.canIUse("web-view")) {
            getApp().core.showModal({
                title: "提示",
                content: "您的版本过低，无法打开本页面，请升级至最新版。",
                showCancel: false,
                success: function (res) {
                    if (res.confirm) {
                        getApp().core.navigateBack({
                            delta: 1,
                        });
                    }
                }
            });
            return;
        }
        this.setData({
            url: decodeURIComponent(options.url),
        });
    },

    /**
     * 生命周期函数--监听页面初次渲染完成
     */
    onReady: function (options) {
        getApp().page.onReady(this);

    },

    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function (options) {
        getApp().page.onShow(this);

    },

    /**
     * 生命周期函数--监听页面隐藏
     */
    onHide: function (options) {
        getApp().page.onHide(this);

    },

    /**
     * 生命周期函数--监听页面卸载
     */
    onUnload: function (options) {
        getApp().page.onUnload(this);

    },

    /**
     * 用户点击右上角分享
     */
    onShareAppMessage: function (options) {
        return {
            path: 'pages/web/web?url=' + encodeURIComponent(options.webViewUrl)
        };
    }
});