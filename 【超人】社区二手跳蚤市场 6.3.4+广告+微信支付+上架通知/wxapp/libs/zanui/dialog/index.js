var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var o in a) Object.prototype.hasOwnProperty.call(a, o) && (t[o] = a[o]);
    }
    return t;
}, defaultData = require("./data"), _f = function() {};

Component({
    properties: {},
    data: _extends({}, defaultData, {
        key: "",
        show: !1,
        showCustomBtns: !1,
        promiseFunc: {}
    }),
    methods: {
        handleButtonClick: function(t) {
            var e = t.currentTarget, a = (void 0 === e ? {} : e).dataset, o = void 0 === a ? {} : a, r = this.data.promiseFunc || {}, n = r.resolve, s = void 0 === n ? _f : n, i = r.reject, c = void 0 === i ? _f : i;
            this.setData({
                show: !1
            }), this.data.showCustomBtns ? s({
                type: o.type
            }) : "confirm" === o.type ? s({
                type: "confirm"
            }) : c({
                type: "cancel"
            });
        }
    }
});