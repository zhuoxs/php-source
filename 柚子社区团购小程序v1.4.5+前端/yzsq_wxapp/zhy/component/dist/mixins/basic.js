Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.basic = void 0;

var _classNames = require("../common/class-names"), basic = exports.basic = Behavior({
    methods: {
        classNames: _classNames.classNames,
        $emit: function() {
            this.triggerEvent.apply(this, arguments);
        },
        getRect: function(t, r) {
            var c = this;
            return new Promise(function(s, e) {
                wx.createSelectorQuery().in(c)[r ? "selectAll" : "select"](t).boundingClientRect(function(e) {
                    r && Array.isArray(e) && e.length && s(e), !r && e && s(e);
                }).exec();
            });
        }
    }
});