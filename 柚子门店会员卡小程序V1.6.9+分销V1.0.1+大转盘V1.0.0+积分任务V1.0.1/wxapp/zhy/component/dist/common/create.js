Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.create = create;

var _basic = require("../mixins/basic"), _index = require("../mixins/observer/index");

function create(e) {
    e.props && (e.properties = e.props, delete e.props), e.mixins && (e.behaviors = e.mixins, 
    delete e.mixins), e.externalClasses = e.classes || [], delete e.classes, e.externalClasses.push("custom-class"), 
    e.behaviors = e.behaviors || [], e.behaviors.push(_basic.basic), e.options = e.options || {}, 
    e.options.multipleSlots = !0, e.options.addGlobalClass = !0, e.field && e.behaviors.push("wx://form-field"), 
    (0, _index.observe)(e), Component(e);
}