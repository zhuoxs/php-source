var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (t[i] = e[i]);
    }
    return t;
}, _reload = require("../../../common/js/reload.js"), _api = require("../../../common/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {},
    onLoad: function(t) {
        this.onloadData();
    },
    onloadData: function() {
        var a = this;
        this.checkUrl().then(function(t) {
            return (0, _api.RuleData)();
        }).then(function(t) {
            a.setData({
                list: t.rule,
                img: t.img
            });
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    onRuleDetails: function(t) {
        var a = t.currentTarget.dataset.idx;
        JSON.stringify(this.data.list[a]), this.data.list[a].title, this.data.list[a].content;
        this.navTo("../../ruledetails/ruledetails?index=" + a);
    }
}));