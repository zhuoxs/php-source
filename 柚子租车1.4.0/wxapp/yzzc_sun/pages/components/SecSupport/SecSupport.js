var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var n in a) Object.prototype.hasOwnProperty.call(a, n) && (t[n] = a[n]);
    }
    return t;
}, _reload = require("../../../common/js/reload.js"), _api = require("../../../common/js/api.js"), app = getApp();

Component({
    properties: {},
    data: {
        imgLink: wx.getStorageSync("url")
    },
    attached: function() {
        this._getUrl();
    },
    methods: _extends({}, _reload.reload, {
        _getUrl: function() {
            var e = this;
            this.checkUrl().then(function(t) {
                return (0, _api.SupportData)();
            }).then(function(t) {
                e.setData({
                    msg: t
                });
            }).catch(function(t) {
                -1 === t.code ? e.tips(t.msg) : e.tips("false");
            });
        },
        _onCallTab: function() {
            wx.makePhoneCall({
                phoneNumber: this.data.msg.sup_tel
            });
        }
    })
});