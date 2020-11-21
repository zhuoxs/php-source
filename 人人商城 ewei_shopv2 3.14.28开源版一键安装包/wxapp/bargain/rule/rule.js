var e = getApp(), r = e.requirejs("core"), a = (e.requirejs("jquery"), e.requirejs("foxui"), 
e.requirejs("wxParse/wxParse"));

Page({
    data: {
        list: {}
    },
    onLoad: function(e) {
        var s = this;
        r.get("bargain/rule", e, function(e) {
            a.wxParse("wxParseData", "html", e.rule.rule, s, "0");
        });
    }
});