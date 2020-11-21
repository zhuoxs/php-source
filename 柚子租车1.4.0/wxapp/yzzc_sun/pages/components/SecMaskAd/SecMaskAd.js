var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (t[i] = e[i]);
    }
    return t;
}, _reload = require("../../../common/js/reload.js"), _api = require("../../../common/js/api.js"), app = getApp();

Component({
    properties: {},
    data: {
        imgLink: "",
        show: !0,
        close: !1
    },
    attached: function() {
        var a = this;
        this.checkUrl().then(function(t) {
            return (0, _api.AdpicData)();
        }).then(function(t) {
            t.length < 1 ? a.setData({
                close: !1
            }) : a.setData({
                close: !0
            }), a.setData({
                list: t
            });
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        }), this.setData({
            show: app.globalData.showMaskFlag
        });
    },
    methods: _extends({}, _reload.reload, {
        _onCloseTab: function() {
            this.setData({
                show: !this.data.show
            }), app.globalData.showMaskFlag = !1;
        },
        _onLinkTab: function(t) {
            var a = t.currentTarget.dataset.idx, e = this.data.list[a];
            switch (e.link_type) {
              case "1":
                wx.navigateTo({
                    url: "../choosetime/choosetime?table=1&cid=" + e.link_typeid
                });
                break;

              case "2":
                wx.navigateTo({
                    url: "../storeinfo/storeinfo?sid=" + e.link_typeid
                });
                break;

              case "3":
                wx.navigateTo({
                    url: "../activitydetails/activitydetails?aid=" + e.link_typeid
                });
            }
        }
    })
});