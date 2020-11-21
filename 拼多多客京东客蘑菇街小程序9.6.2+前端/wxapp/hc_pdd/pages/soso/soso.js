var app = getApp();

Page({
    data: {
        keyid: 0
    },
    onLoad: function(t) {},
    shuxhjan: function(t) {
        this.setData({
            keyid: t.currentTarget.dataset.index
        });
    },
    onReady: function() {},
    submitInfotwo: function(t) {
        var a = t.detail.formId;
        this.setData({
            formid: a
        }), app.util.request({
            url: "entry/wxapp/formid",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                formid: this.data.formid
            },
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Formid",
                    method: "POST",
                    data: {
                        user_id: app.globalData.user_id
                    },
                    success: function(t) {}
                });
            }
        });
    },
    Chaojisojd: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Chaojisojd",
            method: "POST",
            success: function(t) {
                var a = t.data.data.is_jd;
                i.setData({
                    is_jd: a
                });
            }
        });
    },
    submitInsearch: function(t) {
        this.submitInfotwo(t), this.search();
    },
    onShow: function() {
        this.tudizhi(), this.Chaojisojd();
    },
    search: function() {
        wx.navigateTo({
            url: "../search/search"
        });
    },
    tudizhi: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Chaojiso",
            method: "POST",
            success: function(t) {
                var a = t.data.data;
                i.setData({
                    Notice: a
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});