Object.defineProperty(exports, "__esModule", {
    value: !0
});

exports.basic = Behavior({
    methods: {
        $emit: function() {
            this.triggerEvent.apply(this, arguments);
        },
        getRect: function(e, t) {
            var r = this;
            return new Promise(function(i) {
                wx.createSelectorQuery().in(r)[t ? "selectAll" : "select"](e).boundingClientRect(function(e) {
                    t && Array.isArray(e) && e.length && i(e), !t && e && i(e);
                }).exec();
            });
        }
    }
});