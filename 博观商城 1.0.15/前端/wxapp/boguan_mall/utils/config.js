function e(e, o) {
    if (!(e instanceof o)) throw new TypeError("Cannot call a class as a function");
}

Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.Config = void 0;

require("token.js");

var o = function o() {
    e(this, o);
};

o.onPay = !0, exports.Config = o;