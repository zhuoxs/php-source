var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        this.tudizhi();
    },
    onReady: function() {},
    submitInfotwo: function(t) {
        console.log("获取id");
        var o = t.detail.formId;
        console.log(o), console.log("获取formid结束"), this.setData({
            formid: o
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
                    success: function(t) {
                        console.log(t);
                    }
                });
            }
        });
    },
    submitInsearch: function(t) {
        this.submitInfotwo(t), this.search();
    },
    onShow: function() {
        this.tudizhi();
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
                var o = t.data.data;
                i.setData({
                    Notice: o
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});