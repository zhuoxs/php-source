App({
    onLaunch: function() {
        var o = this;
        o.gengxin(), o.getUserInfo(), o.Headcolor();
    },
    gengxin: function() {
        var n = wx.getUpdateManager();
        n.onCheckForUpdate(function(o) {
            console.log(o.hasUpdate);
        }), n.onUpdateReady(function() {
            wx.showModal({
                title: "更新提示",
                content: "新版本已经准备好，是否重启应用？",
                success: function(o) {
                    o.confirm && n.applyUpdate();
                }
            });
        }), n.onUpdateFailed(function() {});
    },
    Headcolor: function() {},
    getUserInfo: function(o) {
        var t = this;
        this.globalData.userInfo ? "function" == typeof o && o(this.globalData.userInfo) : wx.login({
            success: function() {
                t.util.request({
                    url: "entry/wxapp/Indexcolorbox",
                    method: "POST",
                    success: function(o) {
                        var n = o.data.data, e = n[0].color;
                        t.globalData.Indexcolorbox = n, t.globalData.bacolor = e;
                    }
                });
            }
        });
    },
    util: require("we7/resource/js/util.js"),
    globalData: {
        userInfo: null,
        user_id: null,
        we_app_info: null,
        xiantime: 0,
        Headcolor: "#000"
    },
    siteInfo: require("siteinfo.js")
});