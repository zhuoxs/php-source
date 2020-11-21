function observeProps(t) {
    t && Object.keys(t).forEach(function(e) {
        var r = t[e];
        null !== r && r.type || (r = {
            type: r
        });
        var s = r.observer;
        r.observer = function() {
            s && ("string" == typeof s && (s = this[s]), s.apply(this, arguments)), this.setData();
        }, t[e] = r;
    });
}

Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.observeProps = observeProps;