Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.observe = observe;

var _behavior = require("./behavior"), _props = require("./props");

function observe(e) {
    e.computed && (e.behaviors.push(_behavior.behavior), e.methods = e.methods || {}, 
    e.methods.$options = function() {
        return e;
    }, e.properties && (0, _props.observeProps)(e.properties));
}