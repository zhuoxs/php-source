function t(t, e) {
    return new Promise(function(i) {
        t.setData(e, i);
    });
}

Object.defineProperty(exports, "__esModule", {
    value: !0
});

exports.behavior = Behavior({
    created: function() {
        var t = this;
        if (this.$options) {
            var e = {}, i = this.$options().computed, o = Object.keys(i);
            this.calcComputed = function() {
                var n = {};
                return o.forEach(function(o) {
                    var s = i[o].call(t);
                    e[o] !== s && (e[o] = n[o] = s);
                }), n;
            };
        }
    },
    attached: function() {
        this.set();
    },
    methods: {
        set: function(e, i) {
            var o = this, n = [];
            return e && n.push(t(this, e)), this.calcComputed && n.push(t(this, this.calcComputed())), 
            Promise.all(n).then(function(t) {
                return i && "function" == typeof i && i.call(o), t;
            });
        }
    }
});