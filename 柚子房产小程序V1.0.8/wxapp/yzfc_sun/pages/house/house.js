var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var r in e) Object.prototype.hasOwnProperty.call(e, r) && (t[r] = e[r]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: _extends({}, _reload.data),
    onLoad: function(t) {
        this.setData({
            id: t.id
        }), this.onloadData();
    },
    onloadData: function() {
        var a = this;
        this.checkUrl().then(function(t) {
            return a.setData({
                show: !0
            }), (0, _api.HouseTypeDetailsData)({
                id: a.data.id
            });
        }).then(function(t) {
            a.setData({
                info: t
            });
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    previewImage: function(t) {
        var a = t.currentTarget.dataset.index, e = [], r = !0, n = !1, i = void 0;
        try {
            for (var o, s = this.data.info.banner[Symbol.iterator](); !(r = (o = s.next()).done); r = !0) {
                var d = o.value;
                e.push(this.data.imgLink + d);
            }
        } catch (t) {
            n = !0, i = t;
        } finally {
            try {
                !r && s.return && s.return();
            } finally {
                if (n) throw i;
            }
        }
        wx.previewImage({
            current: e[a],
            urls: e
        });
    }
}));