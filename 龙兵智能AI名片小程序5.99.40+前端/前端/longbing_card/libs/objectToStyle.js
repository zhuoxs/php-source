Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.default = function(e) {
    var r = JSON.stringify(e);
    if (r) {
        var _ = r.match(/\(.*?\)/g), t = r.replace(/\(.*?\)/g, "@_@_@_@_@_@_@_").replace(/"|{|}/g, "").replace(/,/g, ";");
        return _ && _.length && _.forEach(function(e, r) {
            t = t.replace("@_@_@_@_@_@_@_", e);
        }), t;
    }
    return "";
};