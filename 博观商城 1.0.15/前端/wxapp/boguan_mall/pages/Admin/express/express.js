var e = require("../../../utils/base.js"), t = require("../../../../api.js"), a = new e.Base();

Page({
    data: {
        hide: !0,
        expressList: []
    },
    onLoad: function(e) {
        this.getExpress();
    },
    getName: function(e) {
        this.setData({
            name: e.detail.value
        }), this.getEName();
    },
    getEName: function() {
        var e = this.data.name, t = [];
        if (this.data.express.length > 0) for (var a = 0; a < this.data.express.length; a++) this.data.express[a].name.indexOf(e) >= 0 && t.push(this.data.express[a]);
        this.setData({
            expressArr: t,
            hide: !1,
            name: e
        });
    },
    getExpress: function() {
        var e = this, s = {
            url: t.mobile.mobile_express,
            method: "GET"
        };
        a.getData(s, function(t) {
            1 == t.errorCode && e.setData({
                express: t.data
            });
        });
    },
    selectExpress: function(e) {
        var t = e.currentTarget.dataset.index, a = e.currentTarget.dataset.name, s = getCurrentPages(), r = s[s.length - 2];
        this.setData({
            express_name: a,
            express_index: t
        }), r.setData({
            expressName: a
        }), wx.navigateBack({
            delta: 1
        });
    },
    selectExpress2: function(e) {
        var t = e.currentTarget.dataset.index, a = e.currentTarget.dataset.name, s = getCurrentPages(), r = s[s.length - 2];
        this.setData({
            express_name: a,
            express_index: t
        }), r.setData({
            expressName: a
        }), wx.navigateBack({
            delta: 1
        });
    }
});