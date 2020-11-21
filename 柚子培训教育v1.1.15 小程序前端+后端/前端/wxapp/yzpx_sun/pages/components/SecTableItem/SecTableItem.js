var _extends = Object.assign || function(e) {
    for (var t = 1; t < arguments.length; t++) {
        var r = arguments[t];
        for (var s in r) Object.prototype.hasOwnProperty.call(r, s) && (e[s] = r[s]);
    }
    return e;
}, _reload = require("../../../resource/js/reload.js");

Component({
    properties: {
        listItem: {
            type: Object
        }
    },
    data: {},
    methods: _extends({}, _reload.reload, {
        _onClassTab: function() {
            var e = this.data.listItem.couid;
            this.navTo("../class/class?cid=" + e);
        }
    })
});