var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var s in a) Object.prototype.hasOwnProperty.call(a, s) && (t[s] = a[s]);
    }
    return t;
}, _api = require("../../../resource/js/api.js"), _reload = require("../../../resource/js/reload.js"), app = getApp();

Component({
    data: {
        show: !0
    },
    attached: function() {
        var e = this;
        this.checkUrl().then(function(t) {
            return (0, _api.SupportData)();
        }).then(function(t) {
            e.setData({
                msg: t
            }), "" == t.sup_logo && "" == t.sup_name && "" == t.sup_tel && e.setData({
                show: !1
            }), wx.setNavigationBarTitle({
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