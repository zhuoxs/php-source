Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.observeProps = function(e) {
    e && Object.keys(e).forEach(function(t) {
        var r = e[t];
        null !== r && "type" in r || (r = {
            type: r
        });
        var s = r.observer;
        r.observer = function() {
            s && ("string" == typeof s && (s = this[s]), s.apply(this, arguments)), this.set();
        }, e[t] = r;
    });
};