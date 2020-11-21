function e(e) {
    return (0, n.isObj)(e) ? e : {
        text: e
    };
}

function t() {
    var e = getCurrentPages();
    return e[e.length - 1];
}

Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.default = function(n) {
    void 0 === n && (n = {});
    var r = ((n = Object.assign({}, o, e(n))).context || t()).selectComponent(n.selector);
    delete n.selector, r ? (r.set(n), r.show()) : console.warn("未找到 van-notify 节点，请确认 selector 及 context 是否正确");
};

var n = require("../common/utils"), o = {
    selector: "#van-notify",
    duration: 3e3
};