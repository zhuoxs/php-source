App({
    onLaunch: function(n) {
        var e = this;
        JSON.stringify(n);
        e.gengxin(), e.getUserInfo(), e.globalData.scene = n.scene;
    },
    gengxin: function() {
        var e = wx.getUpdateManager();
        e.onCheckForUpdate(function(n) {}), e.onUpdateReady(function() {
            wx.showModal({
                title: "更新提示",
                content: "新版本已经准备好，是否重启应用？",
                success: function(n) {
                    n.confirm && e.applyUpdate();
                }
            });
        }), e.onUpdateFailed(function() {});
    },
    getUserInfo: function(n) {
        var t = this;
        this.globalData.userInfo ? "function" == typeof n && n(this.globalData.userInfo) : wx.login({
            success: function() {
                t.util.request({
                    url: "entry/wxapp/Indexcolorbox",
                    method: "POST",
                    success: function(n) {
                        var e = n.data.data, o = e[0].color;
                        t.globalData.Indexcolorbox = e, t.globalData.bacolor = o;
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
        Headcolor: "#000",
        scene: null
    },
    siteInfo: require("siteinfo.js")
});