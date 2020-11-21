Object.defineProperty(exports, "__esModule", {
    value: !0
});

var behavior = exports.behavior = Behavior({
    created: function() {
        var i = this;
        if (this.$options) {
            var o = {}, s = this.setData, r = this.$options().computed, c = Object.keys(r);
            this.setData = function(t, a) {
                var e;
                t && s.call(i, t, a), s.call(i, (e = {}, c.forEach(function(t) {
                    var a = r[t].call(i);
                    o[t] !== a && (o[t] = e[t] = a);
                }), e));
            };
        }
    },
    attached: function() {
        this.setData();
    }
});