var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var i in a) Object.prototype.hasOwnProperty.call(a, i) && (t[i] = a[i]);
    }
    return t;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js"), app = getApp(), wxParse = require("../wxParse/wxParse.js");

Page(_extends({}, _reload.reload, {
    data: {},
    onLoad: function(t) {
        this.setData({
            index: t.index
        }), this.onloadData();
    },
    onloadData: function() {
        var e = this;
        this.checkUrl().then(function(t) {
            return (0, _api.RuleData)();
        }).then(function(t) {
            e.setData({
                title: t.rule[e.data.index].title
            }), wxParse.wxParse("detail", "html", t.rule[e.data.index].content, e, 10);
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : e.tips("false");
        });
    },
    onRuleDetails: function(t) {
        var e = t.currentTarget.dataset.idx, a = (JSON.stringify(this.data.list[e]), this.data.list[e].title), i = this.data.list[e].content;
        this.navTo("../../ruledetails/ruledetails?title=" + a + "&content=" + i);
    }
}));