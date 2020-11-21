var _extends = Object.assign || function(e) {
    for (var t = 1; t < arguments.length; t++) {
        var r = arguments[t];
        for (var a in r) Object.prototype.hasOwnProperty.call(r, a) && (e[a] = r[a]);
    }
    return e;
}, _reload = require("../../../resource/js/reload.js");

Component({
    properties: {
        listItem: {
            type: Object
        },
        isRecommend: {
            type: Boolean,
            value: !1
        },
        imgLink: {
            type: String
        }
    },
    data: {},
    methods: _extends({}, _reload.reload, {
        _onClassTab: function() {
            var e = this.data.listItem.id;
            this.navTo("../class/class?cid=" + e);
        }
    })
});