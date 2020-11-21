var _extends = Object.assign || function(a) {
    for (var t = 1; t < arguments.length; t++) {
        var s = arguments[t];
        for (var e in s) Object.prototype.hasOwnProperty.call(s, e) && (a[e] = s[e]);
    }
    return a;
}, _api = require("../../../resource/js/api.js"), _reload = require("../../../resource/js/reload.js"), app = getApp();

Component({
    data: {
        showMaskFlag: !1,
        close: !0
    },
    ready: function() {
        var t = this;
        this.setData({
            showMaskFlag: app.globalData.showMaskFlag
        }), this.checkUrl().then(function(a) {
            return (0, _api.AdpicData)();
        }).then(function(a) {
            t.setData({
                info: a
            }), a.length < 1 && t.setData({
                close: !1
            });
        }).catch(function(a) {
            -1 === a.code ? t.tips(a.msg) : t.tips("false");
        });
    },
    methods: _extends({}, _reload.reload, {
        _onCloseTab: function() {
            this.setData({
                showMaskFlag: !this.data.showMaskFlag
            }), app.globalData.showMaskFlag = !0;
        },
        _onLinkTab: function(a) {
            var t = a.currentTarget.dataset.idx;
            switch (this.data.info[t].link_type) {
              case "0":
                break;

              case "1":
                this.navTo("../houses/houses?hid=" + this.data.info[t].link_typeid);
            }
        },
        _onCardTab: function(a) {
            var t = a.currentTarget.dataset.idx, s = this.data.info.couponlist[t].id;
            this.navTo("../cardinfo/cardinfo?cid=" + s);
        }
    })
});