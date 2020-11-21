var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var n in e) Object.prototype.hasOwnProperty.call(e, n) && (t[n] = e[n]);
    }
    return t;
}, _reload = require("../../../common/js/reload.js"), _api = require("../../../common/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {},
    onLoad: function(t) {},
    onShow: function() {
        this.onloadData();
    },
    onloadData: function() {
        var a = this;
        this.getUrl().then(function(t) {
            return (0, _api.Getbrand)({
                brand_id: 0
            });
        }).then(function(t) {
            console.log(t), a.setData({
                detail: t.brand
            });
        });
    },
    checkselect: function(t) {
        this.setData({
            id: t.currentTarget.dataset.id,
            name: t.currentTarget.dataset.name
        });
    },
    sumbit: function(t) {
        if (this.data.id) {
            var a = getCurrentPages();
            a[a.length - 2].setData({
                _pai: this.data.name,
                brand_id: this.data.id
            }), wx.navigateBack({
                delta: 1
            });
        } else this.tips("未勾选品牌");
    },
    cance: function() {
        this.reTo("../Second");
    }
}));