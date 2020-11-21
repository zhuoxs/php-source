var _extends = Object.assign || function(e) {
    for (var a = 1; a < arguments.length; a++) {
        var n = arguments[a];
        for (var o in n) Object.prototype.hasOwnProperty.call(n, o) && (e[o] = n[o]);
    }
    return e;
}, _reload = require("../../../resource/js/reload.js"), _api = require("../../../resource/js/api.js"), app = getApp();

Component({
    properties: {
        chooseNav: {
            type: Number,
            value: 0,
            observer: function(e, a) {}
        }
    },
    data: {
        passFlag: 1
    },
    attached: function() {
        var s = this;
        this.checkUrl().then(function(e) {
            var a = getCurrentPages(), n = a[a.length - 1].route, o = wx.getStorageSync("config");
            switch (n) {
              case "yzfc_sun/pages/home/home":
                o.foot[0].choose = !0;
                break;

              case "yzfc_sun/pages/new/new":
                o.foot[1].choose = !0;
                break;

              case "yzfc_sun/pages/find/find":
                o.foot[2].choose = !0;
                break;

              case "yzfc_sun/pages/mine/mine":
                o.foot[3].choose = !0;
            }
            s.setData({
                foot: o.foot,
                color: o.color
            });
        }).catch(function(e) {
            s.tips("请求过期（foot）");
        });
    },
    ready: function() {
        this.passCheck();
    },
    methods: _extends({
        passCheck: function() {
            var a = this;
            (0, _api.ColorData)().then(function(e) {
                a.setData({
                    passFlag: e.wechat_check
                });
            });
        }
    }, _reload.reload, {
        _onNavTab: function(e) {
            var a = getCurrentPages(), n = a[a.length - 1].route;
            switch (e.currentTarget.dataset.index) {
              case 0:
                "yzfc_sun/pages/home/home" !== n && wx.reLaunch({
                    url: "../home/home"
                });
                break;

              case 1:
                "yzfc_sun/pages/new/new" !== n && wx.reLaunch({
                    url: "../new/new"
                });
                break;

              case 2:
                "yzfc_sun/pages/find/find" !== n && wx.reLaunch({
                    url: "../find/find"
                });
                break;

              case 3:
                "yzfc_sun/pages/mine/mine" !== n && wx.reLaunch({
                    url: "../mine/mine"
                });
            }
        }
    })
});