var _extends = Object.assign || function(a) {
    for (var t = 1; t < arguments.length; t++) {
        var e = arguments[t];
        for (var s in e) Object.prototype.hasOwnProperty.call(e, s) && (a[s] = e[s]);
    }
    return a;
}, _api = require("../../../resource/js/api.js"), _reload = require("../../../resource/js/reload.js"), app = getApp();

Component({
    data: {
        show: !1,
        close: !0
    },
    attached: function() {
        var t = this;
        this.checkUrl().then(function(a) {
            return t.setData({
                imgLink: a
            }), (0, _api.AdpicData)();
        }).then(function(a) {
            t.setData({
                show: app.globalData.showMaskFlag
            }), a.length < 1 && t.setData({
                close: !1
            }), t.setData({
                list: a
            });
        }).catch(function(a) {
            -1 === a.code ? t.tips(a.msg) : t.tips("false");
        });
    },
    methods: _extends({}, _reload.reload, {
        _onCloseTab: function() {
            this.setData({
                show: !this.data.show
            }), app.globalData.showMaskFlag = !1;
        },
        _onLinkTab: function(a) {
            var t = a.currentTarget.dataset.idx;
            switch (this.data.list[t].link_type) {
              case "1":
                wx.navigateTo({
                    url: "../classlist/classlist"
                });
                break;

              case "2":
                wx.navigateTo({
                    url: "../play/play"
                });
                break;

              case "3":
                wx.navigateTo({
                    url: "../activitylist/activitylist"
                });
            }
        }
    })
});