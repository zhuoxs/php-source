var _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp();

Page({
    data: {
        src: ""
    },
    onLoad: function(t) {
        var a = this;
        console.log(t, "options webview");
        var e = this;
        wx.hideShareMenu();
        var i = decodeURIComponent(t.url), o = t.to_uid, n = t.from_id, r = t.id, s = t.fromshare, u = t.status, d = t.url, l = t.name, p = {
            to_uid: o,
            from_id: n,
            id: r,
            fromshare: s,
            status: u,
            url: d,
            name: l
        };
        t.status && ("toNewsLine" != u && "newsLine" != u || wx.showShareMenu()), l && wx.setNavigationBarTitle({
            title: l
        }), getApp().getConfigInfo().then(function() {
            a.setData({
                paramObj: p,
                src: i,
                globalData: app.globalData
            }, function() {
                if ("toNewsLine" == e.data.paramObj.status || "newsLine" == e.data.paramObj.status) {
                    var t = e.data.paramObj, a = {
                        to_uid: t.to_uid,
                        sign: "view",
                        type: 9,
                        target: t.id,
                        scene: app.globalData.loginParam.scene,
                        uniacid: app.siteInfo.uniacid
                    };
                    app.globalData.to_uid != wx.getStorageSync("userid") && (e.toGetReport(a), getApp().getCardAfter()), 
                    e.getDetailData();
                }
            });
        });
    },
    onHide: function() {
        "toNewsLine" == this.data.paramObj.status && this.goToHome();
    },
    onUnload: function() {
        "toNewsLine" == this.data.paramObj.status && this.goToHome();
    },
    onShareAppMessage: function() {
        var t = this.data.paramObj, a = t.status, e = t.to_uid, i = t.from_id, o = t.name, n = t.shareimg, r = t.id, s = this.data.tmpData;
        if (o = s.title, n = s.cover[0], "toNewsLine" == a || "newsLine" == a) {
            var u = "/longbing_card/common/transtion/transtion?id=" + r + "&to_uid=" + e + "&from_id=" + i + "&status=toNewsLine&name=" + o + "&fromshare=true";
            return console.log(u, "tmpPath"), {
                title: o,
                path: u,
                imageUrl: n
            };
        }
    },
    toGetReport: function(t) {
        _index.baseModel.getReport(t).then(function(t) {
            _xx_util2.default.hideAll();
        });
    },
    getDetailData: function() {
        var s = this, t = s.data.paramObj, a = {
            id: t.id,
            to_uid: t.to_uid
        };
        _index.userModel.getTimeLineDetail(a).then(function(t) {
            var a = t.data;
            if (s.setData({
                tmpData: a
            }), -2 == t.errno) {
                var e = s.data.paramObj, i = e.fromshare, o = e.to_uid, n = e.from_id;
                n || (n = wx.getStorageSync("userid"));
                var r = "确定";
                "true" == i && (r = "返回首页"), wx.showModal({
                    title: "提示",
                    content: t.message,
                    confirmText: r,
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && "true" == i && wx.reLaunch({
                            url: "/longbing_card/pages/index/index?to_uid=" + o + "&from_id=" + n + "&currentTabBar=toNews"
                        });
                    }
                });
            }
        });
    },
    goToHome: function() {
        var t = this.data.paramObj, a = t.to_uid, e = t.from_id, i = (t.type, "/longbing_card/pages/index/index?to_uid=" + a + "&from_id=" + e + "&currentTabBar=toCard");
        wx.reLaunch({
            url: i
        });
    }
});