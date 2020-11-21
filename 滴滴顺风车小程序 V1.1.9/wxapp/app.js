var e = require("/45D6CB846A7AF98C23B0A3830BD19D70.js");

App({
    data: {
        url: "https://pingche.yibangit.com/index.php/Ht/Index/",
        nid: "0",
        nclass: "",
        logintag: "",
        QD: "",
        title: "",
        address: "",
        JWD: "",
        piansheng_title: "",
        piansheng_email: "",
        piansheng_qq: "",
        piansheng_content: ""
    },
    onLaunch: function() {
        var o = this, a = (n = e.siteroot).split("/")[0] + "//" + n.split("/")[2];
        console.log(a);
        var n = o.data.url;
        console.log(n);
    },
    login: function() {
        console.log("app.js => login调用了");
        var e = this, o = e.data.url, a = e.data.nid;
        wx.login({
            success: function(e) {
                if (console.log("wx.login => 获取code"), console.log(e), e.code) {
                    wx.setStorage({
                        key: "code",
                        data: e.code
                    });
                    var n = e.code;
                    wx.request({
                        url: o + "memberlogin",
                        data: {
                            code: n,
                            nid: a
                        },
                        success: function(e) {
                            console.log("1111111memberlogin => 获取登录信息"), console.log(e), e.data.wx_headimg || wx.redirectTo({
                                url: "/pages/index/getinfo/getinfo"
                            }), wx.setStorage({
                                key: "session",
                                data: e.data.logintag
                            }), wx.setStorage({
                                key: "nclass",
                                data: e.data.nclass
                            });
                        }
                    });
                } else console.log("获取用户登录态失败！" + e.errMsg);
            }
        });
    },
    acquire: function(e) {
        var o = this;
        try {
            var a = wx.getStorageSync("session");
            a && (console.log("logintag:", a), wx.request({
                url: o.data.url + "show_car_owner_share_view",
                data: {
                    logintag: a
                },
                header: {
                    "content-type": "application/x-www-form-urlencoded"
                },
                success: function(e) {
                    if (console.log(e), "0000" == e.data.retCode) wx.setStorage({
                        key: "ac_nid",
                        data: e.data.nid
                    }); else if ("账号已冻结" == e.data.retDesc) return void wx.navigateTo({
                        url: "/pages/index/index"
                    });
                }
            }));
        } catch (e) {}
    },
    onShow: function() {},
    globalData: {
        userInfo: null
    }
});