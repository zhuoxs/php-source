var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var r in a) Object.prototype.hasOwnProperty.call(a, r) && (t[r] = a[r]);
    }
    return t;
}, _api = require("../../../resource/js/api.js"), _reload = require("../../../resource/js/reload.js"), app = getApp();

Component({
    attached: function() {
        var e = this;
        this.checkUrl().then(function(t) {
            return e.setData({
                imgLink: t
            }), (0, _api.SupportData)();
        }).then(function(t) {
            wx.setNavigationBarTitle({
                title: t.top_title
            }), e.setData({
                msg: t,
                title: t.top_title
            });
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : e.tips("false");
        });
    },
    methods: _extends({}, _reload.reload, {
        _onCallTab: function() {
            wx.makePhoneCall({
                phoneNumber: this.data.msg.sup_tel
            });
        }
    })
});